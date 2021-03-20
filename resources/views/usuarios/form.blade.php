@extends('layouts.app')

<?php
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
?>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h5><i class="fas fa-user-plus"></i> {{$h5_titulo}}</h5></div>

                <div class="card-body">
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


                    <form action="{{url('usuarios/add')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="endereco">Endereco</label>
                         </div>
                         <input type="text" name='endereco' class="form-control" placeholder="Avenida Otto Macedo 629">
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="hidden" name='coordenada0' class="form-control">
                    </div>

                    <div class="form-group">
                      <input type="hidden" name='coordenada1' class="form-control">
                    </div>

                    @guest
                    <div class="form-group">
                      <input type="hidden" name='usuario_ad' class="form-control" value="{{Request::ip()}}">
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
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="atividade">Atividade</label>
                         </div>
                       <select class="custom-select" name="atividade">
                         <option selected disabled>Escolha a opção...</option>
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
                         <input type="tel" name='contato' class="form-control" placeholder="(44)3532-8100" value="(44)">
                      </div>
                    </div>

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
                    </div>
                    @endguest

                    <div class="form-group">
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <label class="input-group-text" for="observacao">Observação</label>
                         </div>
                         <textarea class="form-control" name="observacao" rows="3"></textarea>
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
