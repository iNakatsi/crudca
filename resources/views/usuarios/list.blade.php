@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header text-center"><h5><i class="fas fa-table"></i> Tabela Caçamba</h5></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover table-sm" id="usuarios_tabela">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Endereco</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Atividade</th>
                        <th scope="col">Contato</th>
                        <th scope="col">Andamento</th>
                        <th scope="col">Data Pedido</th>
                        <th scope="col">Observação</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach( $usuarios as $u)
                      <tr>
                        <th scope="row">{{$u->id}}</th>
                        <td>{{$u->endereco}}</td>
                        <td>{{$u->nome}}</td>
                        <td>{{$u->atividade}}</td>
                        <td>{{$u->contato}}</td>
                        <td>{{$u->andamento}}</td>
                        <td>{{$u->data_pedido}}</td>
                        <td>{{$u->observacao}}</td>
                        <td><a href="usuarios/{{$u->id}}/edit" class="btn btn-primary"><i class="far fa-edit"></i></a></td>
                        <td>
                          <form action="usuarios/delete/{{$u->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
