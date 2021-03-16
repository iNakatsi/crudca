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



</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
              <nav class="navbar navbar-light">
              <a class="navbar-brand" href="{{ url('/') }}">
                <img height="40" src="{{url('img/moreirasaleslogo.png')}}"/>
                CRUDCA
              </a>
              </nav>

              <div class="btn-group" role="group">
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios/new')}}"><i class="fas fa-user-plus"></i> Cadastrar</a></button>
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios')}}"><i class="fas fa-table"></i> Tabela</a></button>
              <button type="button" class="btn btn-light"><a href="{{ url('usuarios/mapa')}}"><i class="fas fa-map-marked-alt"></i> Mapa</a></button>
              </div>

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
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="far fa-address-card"></i>  {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
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

</body>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js'></script>

  <script>
  $(document).ready(function() {
      $('#myTable').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              { extend: 'copy', text: '<span style="font-size: 1em; color: Tomato;"><i class="fas fa-copy"></i></span> Copiar' },
              { extend: 'csv', text: '<span style="font-size: 1em; color: DarkGreen;"><i class="fas fa-file-csv"></i></span> CSV' },
              { extend: 'excel', text: '<span style="font-size: 1em; color: DarkGreen;"><i class="fas fa-file-excel"></i></span> Excel' },
              { extend: 'pdf', text: '<span style="font-size: 1em; color: Crimson;"><i class="fas fa-file-pdf"></i></span> PDF' },
              { extend: 'print', text: '<span style="font-size: 1em; color: DodgerBlue;"><i class="fas fa-print"></i></span> Imprimir' },
              { text: '<span style="font-size: 1em; color: Tomato;"><i class="fas fa-file-alt"></i></span> Relatório Diário', action: function ( e, dt, button, config ) {window.location = '{{ url('usuarios/pendente')}}';}}
                   ]
      });


  });
  </script>


</html>
