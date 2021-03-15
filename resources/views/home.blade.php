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

                    <h1>Bem vindo</h1>
                    <a href="{{ url('usuarios') }}"> Lista usuarios </a>

                    <i class="fas fa-user"></i> <!-- uses solid style -->
                    <i class="fab fa-github-square"></i> <!-- uses brand style -->


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
