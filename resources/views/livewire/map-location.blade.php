@extends('layouts.app')

<style>

.map-responsive{
    overflow:hidden;
    padding-bottom:42%;
    position:relative;
    height:0;
}

#fit {
position: relative;
margin: 0px auto;
width: 100%;
height: 40px;
padding: 10px;
border: none;
border-radius: 1px;
font-size: 12px;
text-align: center;
color: #fff;
background: #ee8a65;
}
</style>

<!-- app.css para estilizacao da pagina -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@section('content')

<div class="container-fluid">

  <button id="fit"><i class="fas fa-arrows-alt"></i></button>
  <div id='map' class="map-responsive"></div>

</div>

@endsection
@push('scripts')
<script>
/*----------------------------------------------- Script para acesso ao mapbox -----------------------------------------------*/
  mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-53.0102,-24.0509],
    zoom: 15,
    interactive: true
  });

  //********** Pop up inicial **********
  var popup = new mapboxgl.Popup({ closeOnClick: false })
        .setLngLat([-53.0102,-24.0509])
        .setHTML('<i class="fas fa-circle" style="color:#ff4d4d;"></i> - Ponto indicador de pedidos entregues/abertos<br>')
        .addTo(map);


  /*----------------------------------------------- Script para icone animado -----------------------------------------------*/
  var size = 140;

  // implementation of CustomLayerInterface to draw a pulsing dot icon on the map
  // see https://docs.mapbox.com/mapbox-gl-js/api/#customlayerinterface for more info
  var pulsingDot = {
  width: size,
  height: size,
  data: new Uint8Array(size * size * 4),

  // get rendering context for the map canvas when layer is added to the map
  onAdd: function () {
  var canvas = document.createElement('canvas');
  canvas.width = this.width;
  canvas.height = this.height;
  this.context = canvas.getContext('2d');
  },

  // called once before every frame where the icon will be used
  render: function () {
  var duration = 1000;
  var t = (performance.now() % duration) / duration;

  var radius = (size / 2) * 0.3;
  var outerRadius = (size / 2) * 0.7 * t + radius;
  var context = this.context;

  // draw outer circle
  context.clearRect(0, 0, this.width, this.height);
  context.beginPath();
  context.arc(
  this.width / 2,
  this.height / 2,
  outerRadius,
  0,
  Math.PI * 2
  );
  context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
  context.fill();

  // draw inner circle
  context.beginPath();
  context.arc(
  this.width / 2,
  this.height / 2,
  radius,
  0,
  Math.PI * 2
  );
  context.fillStyle = 'rgba(255, 100, 100, 1)';
  context.strokeStyle = 'white';
  context.lineWidth = 2 + 4 * (1 - t);
  context.fill();
  context.stroke();

  // update this image's data with data from the canvas
  this.data = context.getImageData(
  0,
  0,
  this.width,
  this.height
  ).data;

  // continuously repaint the map, resulting in the smooth animation of the dot
  map.triggerRepaint();

  // return `true` to let the map know that the image was updated
  return true;
  }
  };


// ********** Campo de pesquisa interna do mapa **********
  map.addControl(
    new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    })
);

// ********** Botao para centralizar na cidade **********
document.getElementById('fit').addEventListener('click', function () {
    map.fitBounds([
        //-53.0102,-24.0509
        [-53.0199,-24.0639],
        [-53.0000,-24.0400]
    ]);
});


/* ----------------------------------------------- Pontos no mapa ----------------------------------------------- */

map.on('load', function () {

    //Icone pulsante
    map.addImage('pulsing-dot', pulsingDot, { pixelRatio: 4 });

    //Adicao de pontos de cacamba no mapa com base em coordenadas
    map.addSource('points', {
    'type': 'geojson',
    'data': {
    'type': 'FeatureCollection',
    'features': [
      @foreach( $usuarios as $u)
      {
      'type': 'Feature',
      'geometry': {
      'type': 'Point',
      'coordinates': [{{$u->coordenada0}}, {{$u->coordenada1}}]
                  },
                                'properties': {
                                    'title': '{{$u->id}}',
                                    'description':
                                    '<strong>Data Solicitada:{{$u->created_at}}</strong><br>Atividade:{{$u->atividade}}<br>Nome:{{$u->nome}}'
                                }
      },
      @endforeach
                ]
              }
      });

      //********** Adicao de genero do ponteiro **********
    map.addLayer({
    'id': 'points',
    'type': 'symbol',
    'source': 'points',
    'layout': {
        'icon-image': 'pulsing-dot',
        // get the title name from the source's "title" property
                  'text-field': ['format',
                                  ['upcase', ['get', 'title']],
                                  { 'font-scale': 0.7 }],
                  'text-font': [
                      'Open Sans Semibold',
                      'Arial Unicode MS Bold'
                  ],
                  'text-offset': [0, 0.15],
                  'text-anchor': 'top',
                  'icon-allow-overlap': true
              }
      });

    //Adicao de imagem fixa no mapa
    map.loadImage(
    'http://sistema.atendemunicipio.com.br/arquivos/9d892e3c0b0420b46de899c88869f52f/layout/moreirasales,1909131427F01.png',
    function (error, image) {
        if (error) throw error;
        map.addImage('cat', image);
        map.addSource('catpoint', {
            'type': 'geojson',
            'data': {
                'type': 'FeatureCollection',
                'features': [
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [-53.0100,-24.0500]
                        }
                    }
                ]
            }
        });
        map.addLayer({
            'id': 'catpoint',
            'type': 'symbol',
            'source': 'catpoint',
            'layout': {
                'icon-image': 'cat',
                'icon-size': 0.03
                      }
                  });
              }
          );



          //********** Adicao de popup ao passar mouse **********

          // Create a popup, but don't add it to the map yet.
          var popup = new mapboxgl.Popup({
            closeButton: false,
            closeOnClick: false
          });

          map.on('mouseenter', 'points', function(e) {
            // Change the cursor style as a UI indicator.
            map.getCanvas().style.cursor = 'pointer';

            var coordinates = e.features[0].geometry.coordinates.slice();
            var description = e.features[0].properties.description;

            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
              coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            // Populate the popup and set its coordinates
            // based on the feature found.
            popup.setLngLat(coordinates).setHTML(description).addTo(map);
          });

          map.on('mouseleave', 'points', function() {
            map.getCanvas().style.cursor = '';
            popup.remove();
          });


});



</script>
@endpush
