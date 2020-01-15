@extends('layouts.app')

@section('content')
<div class="container">
    <div id="myCarousel" data-interval="false" class="carousel slide" data-ride="carousel">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <ul class="nav nav-pills nav-justified">
            <li data-target="#myCarousel" data-slide-to="0"><a href="#">Tasks em aberto</a></li>
            <li data-target="#myCarousel" data-slide-to="1"><a href="#">Tasks encerrados</a></li>
        </ul>
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <div class="col-md-12 refresh text-center">
                        <div>Tasks em aberto</div>
                    </div>
                    <div class="col-md-12" id="tasks">
                    </div>
                </div>
            </div>

            <div class="item">
                <div class="row">
                    <div class="col-md-12 refresh text-center">
                        <div>Tasks encerrados</div>
                    </div>
                    <div class="col-md-12" id="tasksFinish">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a id="scroll-top" href="#top-bar-menu" data-toggle="modal" data-target="#ModalInsert">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</div>

<div class="col-md-12 refresh text-center">
    Desenvolvido por Mauricio Lanner | Desafio MobApps 2019
</div>
<!-- Modal insert -->
<div class="modal fade" id="ModalInsert" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Cacular IMC</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/inseririmc" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="nome" class="input-modal" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <input type="text" name="made" class="input-modal" placeholder="Made">
                    </div>
                    <div class="form-group">
                        <input type="text" name="altura" class="input-modal" placeholder="Altura">
                    </div>
                    <div class="form-group">
                        <input type="text" name="peso" class="input-modal" placeholder="Peso">
                    </div>
                    <button type="submit" class="btn btn-task">Criar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection