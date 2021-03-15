<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Redirect;

class UsuariosController extends Controller
{
    public function index(){
    $usuarios = Usuario::get();
    return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    public function mapa(){
      $usuarios = Usuario::get();
      return view('livewire.map-location',['usuarios' => $usuarios]);
    }

    public function new(){
      return view('usuarios.form');
    }

    /* Funcao para adicionar formulario no banco de dados,verificar endereco e atribuir coordenadas */
    public function add( Request $request ){
      $usuario = new Usuario;

      $mapboxinfo = $this->mapBoxGeoCoding($request->input('endereco'));

      $request['coordenada0'] = $mapboxinfo['0'];
      $request['coordenada1'] = $mapboxinfo['1'];

      $usuario = $usuario -> create($request->all());
      $mapboxinfo = $request->input('endereco');

      $usuarios = Usuario::get();

      return Redirect::to('/usuarios');
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
