@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Resumo</h5></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>Grafico de atividade</h5>
                    <canvas id="myChart" width="400" height="200"></canvas>

                    <?php $result = json_decode($atividades,true);
                    var_dump($atividades);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["{{$result[0]['atividade']}}", "{{$result[1]['atividade']}}", "{{$result[2]['atividade']}}","{{$result[3]['atividade']}}"],
    datasets: [{
      backgroundColor: [
        "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#cc402e"
      ],
      data: ["{{$result[0]['total']}}", "{{$result[1]['total']}}", "{{$result[2]['total']}}","{{$result[3]['total']}}"]
    }]
  }
});

</script>
@endpush
