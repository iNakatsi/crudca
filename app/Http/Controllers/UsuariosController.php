<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Redirect;
use Carbon\Carbon;
use DB;

class UsuariosController extends Controller
{
    public function index(){
    $usuarios = Usuario::where('usuario_ad', '=', 'admin')->
    get();
    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    public function listaTodos(){
    $usuarios = Usuario::where('usuario_ad', '=', 'admin')->
    get();
    $usuarios = Usuario::get();
    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    public function grafPieAtividade(){
      $atividades = DB::table('usuarios')
                 ->select('atividade', DB::raw('count(*) as total'))
                 ->where('usuario_ad', '=', 'admin')
                 ->groupBy('atividade')
                 ->get();

    return view('home', ['atividades' => $atividades]);
    }

    public function mapa(){
      $usuarios = Usuario::where('usuario_ad', '=', 'admin')->
      get();
      return view('livewire.map-location',['usuarios' => $usuarios]);
    }

    public function new(){
      $fila_solicitacao = DB::table('usuarios')
                 ->select('andamento', DB::raw('count(*) as total'))
                 ->where('andamento', '=', 'solicitado')
                 ->groupBy('andamento')
                 ->get();

      return view('usuarios.form', ['fila_solicitacao' => $fila_solicitacao]);
    }

    public function pendente(){
    $usuarios = Usuario::where('andamento', '=', 'solicitado')->
    where('data_entrega', '=', null)->
    where('data_finalizado', '=', null)->
    where('usuario_ad', '=', 'admin')->
    orderBy('prioridade','asc')->
    get();
    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    public function pendenteSolUser(){
    $usuarios = Usuario::where('usuario_ad', '!=', 'admin')->
    get();
    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    //Relatorio prefeitura
    public function relatorioDiario(){
    $usuarios = Usuario::where('data_entrega', Carbon::today('America/Sao_Paulo'))->
    where('usuario_ad', '=', 'admin')->
    get();

    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    //Dados com data de hoje
    public function relatorioHoje(){
    $usuarios = Usuario::where('data_finalizado', Carbon::today('America/Sao_Paulo'))->
    orwhere('data_pedido', Carbon::today('America/Sao_Paulo'))->
    orwhere('data_entrega', Carbon::today('America/Sao_Paulo'))->
    where('usuario_ad', '=', 'admin')->
    get();
    #$usuarios = DB::table('usuarios')->select(DB::raw('*'))->whereRaw('Date(data_finalizado) = CURDATE()')->get();
    #$usuarios = Usuario::whereDate('data_finalizado', '2021-03-18')->get();
    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    /* Funcao para adicionar formulario no banco de dados,verificar endereco e atribuir coordenadas */
    public function add( Request $request ){

      $validatedData = $request->validate([
        'endereco' => 'required|max:70',
        'nome' => 'required|max:70',
        'atividade' => 'required|max:20',
        'contato' => 'required',
        'observacao' => 'required|max:150',
        'data_pedido' => 'required'
    ], [
        'endereco.required' => 'Campo endereco obrigatório, Exemplo: Avenida João Theotonio Moreira Sales Neto 600',
        'nome.required' => 'Campo nome obrigatório',
        'atividade.required' => 'Campo atividade obrigatório',
        'contato.required' => 'Campo contato obrigatório',
        'data_pedido.required' => 'Campo data do pedido obrigatório',
        'endereco.max' => 'Limite de caracteres atingido, maximo 70',
        'nome.max' => 'Limite de caracteres atingido, maximo 70'
    ]);


      $usuario = new Usuario;

      $mapboxinfo = $this->mapBoxGeoCoding($request->input('endereco'));

      $request['coordenada0'] = $mapboxinfo['0'];
      $request['coordenada1'] = $mapboxinfo['1'];

      $usuario = $usuario -> create($request->all());

      #$mapboxinfo = $request->input('endereco');
      #$usuarios = Usuario::get();

      return back()->with('registrado', 'Solicitação enviada com sucesso.');
      #return Redirect::to('/usuarios');
      #return view('usuarios.list', ['mapboxinfo' => $mapboxinfo, 'usuarios' => $usuarios ]);

    }

    public function edit($id){
      $usuario = Usuario::findOrFail($id);
      return view('usuarios.form', ['usuarios' => $usuario]);
    }

    /* Funcao para editar dados ja cadastrados */
    public function update( Request $request,$id){
      $usuario = Usuario::findOrFail($id);
      $usuario -> update($request->all());
      \Session::flash('msg_update', 'Atualiza com sucesso');
      return Redirect::to('/usuarios');
    }

    /* Funcao para deletar dados */
    public function delete($id){
      $usuario = Usuario::findOrFail($id);
      $usuario -> delete();
      return Redirect::to('/usuarios');
    }

    /* Funcao com url api do mapbox para captura de informacoes do endereco */
    public function mapBoxGeoCoding($endereco){
      $curl = curl_init();

      //Substituir espaco por %20 para busca url
      $endereco = str_replace(' ', '%20', $endereco);

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.mapbox.com/geocoding/v5/mapbox.places/" . $endereco . "%20Moreira%20Sales" . ".json?access_token=" . env("MAPBOX_KEY"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);

      //Converter string para json
      $response = json_decode($response, true);

      //Atribuir coordenadas
      $coord['0'] = $response['features']['0']['geometry']['coordinates']['0'];
      $coord['1'] = $response['features']['0']['geometry']['coordinates']['1'];

      return $coord;
    }



}
