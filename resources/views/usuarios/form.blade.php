@extends('layouts.app')

<?php

//Bloco de mensagens conforme autenticacao de usuario
try{
if ($usuarios->usuario_ad == "admin") {
  $h5_titulo = "Cadastro de caçamba";
  $btn_form = "Atualizar";
  $btn_color = "btn btn-primary btn-block";
} else {
  $h5_titulo = "Cadastro externo de caçamba";
  $btn_form = "Aprovar Solicitação";
  $btn_color = "btn btn-danger btn-block";
}
} catch (Exception $e) {
  $h5_titulo = "Cadastro de caçamba";
  $btn_form = "Atualizar";
  $btn_color = "btn btn-primary btn-block";
}

//funcao para pegar ip
/*
function getIpAddress() {
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ipAddresses = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      return trim(end($ipAddresses));
  }
  else {
      return $_SERVER['REMOTE_ADDR'];
  }
}
*/

//"189.113.209.1"
$ipaddress = get_ip();
//Servico de rastreamento de informacoes IPINFO
#$details = json_decode(file_get_contents("http://ipinfo.io/{$ipaddress}/json"));
//Servico de rastreamento de informacoes GEOPLUGIN(Mais preciso na geolocalizacao)
$geoPlugin_array = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ipaddress));

$test = "<span class='badge badge-secondary'>" . $geoPlugin_array["geoplugin_request"] . "</span>";
$test2 = "<span class='badge badge-info'>" . $geoPlugin_array["geoplugin_city"] . "</span>";
$test3 = "<span class='badge badge-info'>" . $geoPlugin_array["geoplugin_region"] . "</span>";

// -----------------------------------------------------------------------------------

function get_user_agent(){
    return $_SERVER['HTTP_USER_AGENT'];
  }

function get_ip(){

    $ipaddress = '';
       if (isset($_SERVER['HTTP_CLIENT_IP']))
           $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
       else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
           $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
       else if(isset($_SERVER['HTTP_X_FORWARDED']))
           $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
       else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
           $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
       else if(isset($_SERVER['HTTP_FORWARDED']))
           $ipaddress = $_SERVER['HTTP_FORWARDED'];
       else if(isset($_SERVER['REMOTE_ADDR']))
           $ipaddress = $_SERVER['REMOTE_ADDR'];
       else
           $ipaddress = 'UNKNOWN';
       return $ipaddress;

  }

function get_os(){

    $user_agent = get_user_agent();
    $os_platform = "Unknown OS Platform";
    $os_array = array(
      '/windows nt 10/i'  => 'Windows 10',
      '/windows nt 6.3/i'  => 'Windows 8.1',
      '/windows nt 6.2/i'  => 'Windows 8',
      '/windows nt 6.1/i'  => 'Windows 7',
      '/windows nt 6.0/i'  => 'Windows Vista',
      '/windows nt 5.2/i'  => 'Windows Server 2003/XP x64',
      '/windows nt 5.1/i'  => 'Windows XP',
      '/windows xp/i'  => 'Windows XP',
      '/windows nt 5.0/i'  => 'Windows 2000',
      '/windows me/i'  => 'Windows ME',
      '/win98/i'  => 'Windows 98',
      '/win95/i'  => 'Windows 95',
      '/win16/i'  => 'Windows 3.11',
      '/macintosh|mac os x/i' => 'Mac OS X',
      '/mac_powerpc/i'  => 'Mac OS 9',
      '/linux/i'  => 'Linux',
      '/ubuntu/i'  => 'Ubuntu',
      '/iphone/i'  => 'iPhone',
      '/ipod/i'  => 'iPod',
      '/ipad/i'  => 'iPad',
      '/android/i'  => 'Android',
      '/blackberry/i'  => 'BlackBerry',
      '/webos/i'  => 'Mobile',
    );

    foreach ($os_array as $regex => $value){
      if(preg_match($regex, $user_agent)){
        $os_platform = $value;
      }
    }
    return $os_platform;
  }

function get_browsers(){

    $user_agent= get_user_agent();

    $browser = "Unknown Browser";

    $browser_array = array(
      '/msie/i'  => 'Internet Explorer',
      '/Trident/i'  => 'Internet Explorer',
      '/firefox/i'  => 'Firefox',
      '/safari/i'  => 'Safari',
      '/chrome/i'  => 'Chrome',
      '/edge/i'  => 'Edge',
      '/opera/i'  => 'Opera',
      '/netscape/'  => 'Netscape',
      '/maxthon/i'  => 'Maxthon',
      '/knoqueror/i'  => 'Konqueror',
      '/ubrowser/i'  => 'UC Browser',
      '/mobile/i'  => 'Safari Browser',
    );

    foreach($browser_array as $regex => $value){
      if(preg_match($regex, $user_agent)){
        $browser = $value;
      }
    }
    return $browser;
  }

function get_device(){

    $tablet_browser = 0;
    $mobile_browser = 0;

    if(preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
      $tablet_browser++;
    }

    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
      $mobile_browser++;
    }

    if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),
    'application/vnd.wap.xhtml+xml')> 0) or
      ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or
        isset($_SERVER['HTTP_PROFILE'])))){
          $mobile_browser++;
    }

      $mobile_ua = strtolower(substr(get_user_agent(), 0, 4));
      $mobile_agents = array(
        'w3c','acs-','alav','alca','amoi','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',

        'newt','noki','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',

        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda','xda-');

        if(in_array($mobile_ua,$mobile_agents)){
          $mobile_browser++;
        }

        if(strpos(strtolower(get_user_agent()),'opera mini') > 0){
          $mobile_browser++;

          //Check for tables on opera mini alternative headers

          $stock_ua =
          strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?
          $_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:
          (isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?
          $_SERVER['HTTP_DEVICE_STOCK_UA']:''));

          if(preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)){
            $tablet_browser++;
          }
        }

        if($tablet_browser > 0){
          //do something for tablet devices

          return 'Tablet';
        }
        else if($mobile_browser > 0){
          //do something for mobile devices

          return 'Mobile';
        }
        else{
          //do something for everything else
            return 'Computer';
        }

  }

$ipdousuario = get_ip();
$sodousuario = get_os();
$devdousuario = get_device();
$navegadordousuario = get_browsers();

if ($geoPlugin_array["geoplugin_region"] === "Parana"){
    $verif_reg = true;
    }
    else {
    $verif_reg = false;
    }

$cont_fila_solicitacao = json_decode($fila_solicitacao ?? '',true);

?>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h5><i class="fas fa-user-plus"></i> {{$h5_titulo}}</h5>
                  <span class='badge badge-secondary'><i class="fas fa-at"></i> {{$geoPlugin_array["geoplugin_request"]}}</span>
                  <span class='badge badge-secondary'><i class="fas fa-map-marker-alt"></i> {{$geoPlugin_array["geoplugin_city"]}}</span>
                  <span class='badge badge-secondary'><i class="fas fa-map-marked-alt"></i> {{$geoPlugin_array["geoplugin_region"]}}</span>
                  <span class='badge badge-secondary'><i class="fas fa-hdd"></i> {{$devdousuario}}</span>
                  <span class='badge badge-secondary'><i class="fab fa-windows"></i> {{$sodousuario}}</span>
                  <span class='badge badge-secondary'><i class="fas fa-window-restore"></i> {{$navegadordousuario}}</span>
                  @if($verif_reg)
                  &nbsp;&nbsp;<span style="color: Grey;"><i class="fas fa-slash"></i>&nbsp;&nbsp;&nbsp;<span style="color: ForestGreen;"><i class="fas fa-exclamation-triangle"></i> Região compatível
                  @else
                  &nbsp;&nbsp;<span style="color: Grey;"><i class="fas fa-slash"></i>&nbsp;&nbsp;&nbsp;<span style="color: Tomato;"><i class="fas fa-exclamation-triangle"></i> Região não compatível
                  <div class="spinner-grow spinner-grow-sm" role="status"></div></span>
                  @endif
                </div>

                @if(!$verif_reg)
                <div class="shadow p-1 mb-1 bg-white rounded"><center>Para região não compatível, a solicitacao do pedido sera colocado em baixa prioridade</center></div>
                @endif

                <div class="card-body">

                  <div class="input-group mb-3">
                     <span class="badge badge-secondary" style="font-size: 0.83em; color: white;">Solicitações de caçambas pendentes: {{$cont_fila_solicitacao[0]['total'] ?? ''}}</span><br>
                  </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if( Request::is('*/edit'))
                    <form action="{{url('usuarios/update')}}/{{$usuarios->id}}" method="post">
                    @csrf

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="usuario_ad">Solicitador: {{$usuarios->usuario_ad}}</label>
                         </div>
                         <input type="text" name='usuario_ad' class="form-control" value="admin" readonly>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="endereco">Endereco</label>
                         </div>
                         <input type="text" name='endereco' class="form-control" value="{{$usuarios->endereco}}" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="hidden" name='coordenada0' class="form-control" value="{{$usuarios->coordenada0}}">
                    </div>

                    <div class="form-group">
                      <input type="hidden" name='coordenada1' class="form-control" value="{{$usuarios->coordenada1}}">
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="nome">Nome</label>
                         </div>
                         <input type="text" name='nome' class="form-control" value="{{$usuarios->nome}}">
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="atividade">Atividade</label>
                         </div>
                       <select class="custom-select" name="atividade">
                         <option selected value='{{$usuarios->atividade}}'>{{$usuarios->atividade}}</option>
                         <option value="limpeza">Limpeza</option>
                         <option value="arvore">Arvore</option>
                         <option value="construção">Construção</option>
                         <option value="terra">Terra</option>
                       </select>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="contato">Contato</label>
                         </div>
                         <input type="text" name='contato' class="form-control" value="{{$usuarios->contato}}">
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="andamento">Andamento</label>
                         </div>
                       <select class="custom-select" name="andamento" onchange="yesnoCheck(this);">
                         <option value='{{$usuarios->andamento}}' selected>{{$usuarios->andamento}}</option>
                         <option value="solicitado">Solicitado</option>
                         <option value="entregue">Entregue</option>
                         <option value="finalizado">Finalizado</option>
                       </select>
                      </div>
                    </div>

                    <!-- Aparecer apenas quando estiver como entregue -->
                    <div class="form-group" id="entrega_data_js" style="display: none;">
                          <div class="input-group mb-3">
                           <div class="input-group-prepend">
                             <label class="input-group-text" for="data_entrega"><span style="color: Tomato;">Data Entrega</span></label>
                           </div>
                           <input type="date" class="form-control" name="data_entrega" value="{{$usuarios->data_entrega}}">
                        </div>
                      </div>
                    <!-- -->

                    <!-- Aparecer apenas quando estiver finalizado -->
                    <div class="form-group" id="finalizado_data_js" style="display: none;">
                          <div class="input-group mb-3">
                           <div class="input-group-prepend">
                             <label class="input-group-text" for="data_finalizado"><span style="color: Tomato;">Data Finalizado</span></label>
                           </div>
                           <input type="date" class="form-control" name="data_finalizado" value="{{$usuarios->data_finalizado}}">
                        </div>
                      </div>
                    <!-- -->

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="data_pedido">Data pedido</label>
                         </div>
                         <input type="date" class="form-control" name="data_pedido" value="{{$usuarios->data_pedido}}" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="observacao">Observação</label>
                         </div>
                         <textarea class="form-control" name="observacao" rows="3">{{$usuarios->observacao}}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="prioridade">Prioridade</label>
                         </div>
                       <select class="custom-select" name="prioridade" onchange="msngPrioridade(this);">
                         <option value='{{$usuarios->prioridade}}' selected>{{$usuarios->prioridade}}</option>
                         <option value="normal">Normal</option>
                         <option value="alta">Alta</option>
                       </select>
                      </div>
                    </div>

                    <button type="submit" class="{{$btn_color}}">{{$btn_form}}</button>

                    </form>

                    @else


                    @if(Session::has('registrado'))
                    <div class="alert alert-success">
                        {{ Session::get('registrado') }} você esta na posição {{$cont_fila_solicitacao[0]['total'] ?? ''}}.ª da fila.<br>
                        Em caso de duvidas, favor entrar em contato com (44)3532-8100.
                        @php
                            Session::forget('registrado');
                        @endphp
                    </div>
                    @endif

                    <form action="{{url('usuarios/add')}}" method="post">
                    @csrf
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="endereco" data-toggle="tooltip" data-placement="top" title="Endereco">Endereco</label>
                         </div>
                         <input type="text" name='endereco' class="form-control" placeholder="Avenida João Theotonio Moreira Sales Neto 600" data-toggle="tooltip" data-placement="top" title="Ex: Avenida João Theotonio Moreira Sales Neto 600">
                      </div>
                      @if ($errors->has('endereco'))
                         <span class="text-danger"><i class="fas fa-arrow-up"></i> {{$errors->first('endereco')}}</span>
                     @endif
                    </div>

                    <div class="form-group">
                      <input type="hidden" name='coordenada0' class="form-control">
                    </div>

                    <div class="form-group">
                      <input type="hidden" name='coordenada1' class="form-control">
                    </div>

                    @guest
                    <div class="form-group">
                      <input type="hidden" name='usuario_ad' class="form-control" value="{{$geoPlugin_array['geoplugin_request']}}">
                    </div>
                    @else
                    <div class="form-group">
                      <input type="hidden" name='usuario_ad' class="form-control" value="admin">
                    </div>
                    @endguest

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="nome">Nome</label>
                         </div>
                         <input type="text" name='nome' class="form-control">
                      </div>
                      @if ($errors->has('nome'))
                         <span class="text-danger">{{$errors->first('nome')}}</span>
                     @endif
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="atividade">Atividade</label>
                         </div>
                       <select class="custom-select" name="atividade" data-toggle="tooltip" data-placement="top" title="Atividade para o uso da caçamba">
                         <option selected disabled>Escolha a opção...</option>
                         <option value="limpeza">Limpeza</option>
                         <option value="arvore">Arvore</option>
                         <option value="construção">Construção</option>
                         <option value="terra">Terra</option>
                       </select>
                      </div>
                      @if ($errors->has('atividade'))
                         <span class="text-danger">{{$errors->first('atividade')}}</span>
                     @endif
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="contato">Contato</label>
                         </div>
                         <input type="tel" name='contato' class="form-control" placeholder="(44)3532-8100">
                      </div>
                    </div>
                    @if ($errors->has('contato'))
                       <span class="text-danger">{{$errors->first('contato')}}</span>
                   @endif

                    @guest
                    @else
                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="andamento">Andamento</label>
                         </div>
                       <select class="custom-select" name="andamento" onchange="yesnoCheck(this);">
                         <option value='solicitado' selected>Solicitado</option>
                         <option value="entregue">Entregue</option>
                         <option value="finalizado">Finalizado</option>
                       </select>
                      </div>
                    </div>
                    @endguest

                    <!-- Aparecer apenas quando estiver entrega -->
                    <div class="form-group" id="entrega_data_js" style="display: none;">
                          <div class="input-group mb-3">
                           <div class="input-group-prepend">
                             <label class="input-group-text" for="data_entrega"><span style="color: Tomato;">Data da Entrega</span></label>
                           </div>
                           <input type="date" class="form-control" name="data_entrega">
                        </div>
                      </div>
                    <!-- -->

                    <!-- Aparecer apenas quando estiver finalizado -->
                    <div class="form-group" id="finalizado_data_js" style="display: none;">
                          <div class="input-group mb-3">
                           <div class="input-group-prepend">
                             <label class="input-group-text" for="data_finalizado"><span style="color: Tomato;">Data Finalizado</span></label>
                           </div>
                           <input type="date" class="form-control" name="data_finalizado">
                        </div>
                      </div>
                    <!-- -->

                    @guest
                    @else
                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="data_pedido">Data pedido</label>
                         </div>
                         <input type="date" class="form-control" name="data_pedido">
                      </div>
                      @if ($errors->has('data_pedido'))
                         <span class="text-danger">{{$errors->first('data_pedido')}}</span>
                     @endif
                    </div>
                    @endguest

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="observacao">Observação</label>
                         </div>
                         <textarea class="form-control" name="observacao" rows="3" data-placement="top" title="Informações adicionais"></textarea>
                      </div>
                    </div>

                    @guest
                    @else
                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="prioridade">Prioridade</label>
                         </div>
                       <select class="custom-select" name="prioridade" onchange="msngPrioridade(this);">
                         <option value="normal" selected>Normal</option>
                         <option value="alta">Alta</option>
                       </select>
                      </div>
                    </div>
                    @endguest
                    {!! NoCaptcha::display() !!}
                    <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>

                    </form>

                    @endif

                </div>
                    <!-- Mensagem de alerta de prioridade -->
                    <div class="alert alert-danger" role="alert" style="display: none;" id="pedido_msg">Pedido com prioridade alta!</div>
            </div>
        </div>
    </div>
</div>
@endsection
