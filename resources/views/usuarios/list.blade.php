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

                    <table id="myTable" class="display nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Endereco</th>
                        <th>Nome</th>
                        <th>Atividade</th>
                        <th>Contato</th>
                        <th>Andamento</th>
                        <th>Data Pedido</th>
                        <th>Observação</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach( $usuarios as $u)
                      <tr>
                        <th>{{$u->id}}</th>
                        <td>{{$u->endereco}}</td>
                        <td>{{$u->nome}}</td>
                        <td>{{$u->atividade}}</td>
                        <td>{{$u->contato}}</td>
                        <td>{{$u->andamento}}</td>
                        <td>{{$u->data_pedido}}</td>
                        <td>{{$u->observacao}}</td>
                        <td><a href="usuarios/{{$u->id}}/edit" class="btn btn-light"><i class="far fa-edit"></i></a></td>
                        <td>
                          <form action="usuarios/delete/{{$u->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
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
