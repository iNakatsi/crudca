<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CRUDCA</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">


    <!-- Map box link and reference -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">
    @livewireStyles

    <!-- Chat JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
          <span style="font-size: 0.5em; color: Grey;">N<i class="fas fa-terminal"></i></span>
            <div class="container">
              <nav class="navbar navbar-light">
              <a class="navbar-brand" href="{{ url('/') }}">
                <img height="40" src="{{url('img/moreirasaleslogo.png')}}"/>
                CRUDCA
              </a>
              </nav>

              @guest
              <div class="btn-group" role="group">
              <button type="button" class="btn btn-light dropdown-item"><a href="{{ url('usuarios/new')}}"><i class="fas fa-plus-square"></i> Solicitar Caçamba</a></button>
              </div>
              @else
              <div class="btn-group" role="group">
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios/grafPieAtividade')}}"><i class="fas fa-home"></i> Início</a></button>
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios/new')}}"><i class="fas fa-user-plus"></i> Cadastrar</a></button>
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios')}}"><i class="fas fa-table"></i> Pedidos</a></button>
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios/mapa')}}"><i class="fas fa-map-marked-alt"></i> Mapa</a></button>
              </div>
              @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <!-- Pagina para convidados -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link"><span style="font-size: 1em; color: RoyalBlue;"><i class="fas fa-user-cog"></i>USO</span></a>
                        </li>
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            <!-- no register
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            -->
                            
                        @else
                            <!-- Pagina para administradores -->

                            <li class="nav-item">
                                <a class="nav-link"><span style="font-size: 1em; color: Tomato;"><i class="fas fa-user-cog"></i>ADM</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link">
                                    <i class="far fa-address-card"></i>  {{ Auth::user()->name }}
                                </a>
                              </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')

            {{ isset($slot) ? $slot : null }}
        </main>
    </div>

    <!-- Map box Script -->
    @livewireStyles
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
    @stack('scripts')

    {!! NoCaptcha::renderJs('pt-BR') !!}

</body>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js'></script>
  <script src="https://cdn.datatables.net/select/1.0.1/js/dataTables.select.min.js"></script>

  <script>
  //Data Table Script
$(document).ready(function() {
    $('#myTable').DataTable( {
        order: [ 9, "desc" ],
        dom: 'Bfrtip',
        buttons: [
          { extend: 'copy', text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-copy"></i></span> Copiar' },
          { extend: 'csv', text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-file-csv"></i></span> CSV' },
          { extend: 'excel', text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-file-excel"></i></span> Excel' },
          { extend: 'pdf', text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-file-pdf"></i></span> PDF' },
          { extend: 'print', text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-print"></i></span> Imprimir',
                exportOptions: {
                  rows: function ( idx, data, node ) {
                    var dt = new $.fn.dataTable.Api('#myTable' );
                    var selected = dt.rows( { selected: true } ).indexes().toArray();

                    if( selected.length === 0 || $.inArray(idx, selected) !== -1)
                      return true;


                    return false;
                                                      }
                              },
                customize: function ( win ) {
                $(win.document.body)
                    .css( 'font-size', '10pt' )
                    .prepend(
                        '<img src="http://sistema.atendemunicipio.com.br/arquivos/9d892e3c0b0420b46de899c88869f52f/layout/moreirasales,1909131427F01.png" style="position:absolute; top:0; left:550;" width="40" height="40"/>'
                            );

                $(win.document.body).find( 'table' )
                    .addClass( 'compact' )
                    .css( 'font-size', 'inherit' );
                                            }
          },
          { text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-database"></i></span> Todos', action: function ( e, dt, button, config ) {window.location = '{{ url('usuarios')}}';}},
          { text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-calendar-day"></i></span> Relatório Hoje', action: function ( e, dt, button, config ) {window.location = '{{ url('usuarios/relatorioHoje')}}';}},
          { text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-file-alt"></i></span> Relatório Diário', action: function ( e, dt, button, config ) {window.location = '{{ url('usuarios/relatorioDiario')}}';}},
          { text: '<span style="font-size: 1em; color: Grey;"><i class="fas fa-clock"></i></span> Pendentes Entrega', action: function ( e, dt, button, config ) {window.location = '{{ url('usuarios/pendente')}}';}},
          { text: '<span style="font-size: 1em; color: Crimson;"><i class="fas fa-clock"></i></span> Pendentes solicitacao usuario', action: function ( e, dt, button, config ) {window.location = '{{ url('usuarios/pendenteSolUser')}}';}}
        ],
        select: true
    });
});


  //Form opcao para Finalizado
  function yesnoCheck(that) {
      if (that.value == "finalizado") {
          alert("Selecione a data de finalizacao");
          document.getElementById("finalizado_data_js").style.display = "block";
          document.getElementById("entrega_data_js").style.display = "none"
      }
      else if (that.value == "entregue") {
          alert("Selecione a data da entrega");
          document.getElementById("entrega_data_js").style.display = "block";
          document.getElementById("finalizado_data_js").style.display = "none"
      }
      else
      {
          document.getElementById("entrega_data_js").style.display = "none";
          document.getElementById("finalizado_data_js").style.display = "none";
      }
  }

  //Alerta de prioridade
  function msngPrioridade(that) {
      if (that.value == "alta") {
          document.getElementById("pedido_msg").style.display = "block"
      }
      else {
          document.getElementById("pedido_msg").style.display = "none";
      }

  }


  </script>

</html>
