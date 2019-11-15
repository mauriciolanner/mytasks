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
                <h1>Criar nova nota</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="inset_task" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="title" class="input-modal" placeholder="Título">
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" class="input-modal" id="exampleInputPassword1" placeholder="Descrição">
                    </div>
                    <button type="submit" class="btn btn-task">Criar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    //função que popula as tasks na view
    function tasksall() {
        $.ajax({
                url: "/selectall",
                async: true,
                type: 'get',
            })
            .done(function(data) {
                document.getElementById("tasks").innerHTML = '';

                data.forEach(montahtml);

                function montahtml(task) {
                    var htmltask = `
                    <div class="panel panel-default pag" id="tasks-itens">
                        <div class="panel-body">
                            <div class="row">
                            <form action="/update"  method="post">
                                <a href="#" onclick="viewAll('minhaDiv` + task.id + `')" class="col-8 col-sm-10">
                                    <input type="text" name="title" class="input-task" value="` + task.title + `">
                                </a>
                                <div class="col-2 col-sm-2">
                                    <input type="checkbox" id="verifica" onclick="alterstatus(` + task.id + `)" class="switch_1">
                                </div>
                                <div class="col-sm-12 tasknone" id="minhaDiv` + task.id + `">
                                    {!! csrf_field() !!}
                                        <div class="col-sm-12" id="minhaDiv">
                                            <div class="col-sm-4">
                                                <textarea type="text" style="width: 100%;" name="description" class="input-task">` + task.description + `</textarea>
                                                <input type="hidden" name="id_task" value="` + task.id + `">
                                            </div>
                                            <div class="col-sm-4"><h4>Criado em` + task.created_at + `</h4></div>
                                            <div class="col-sm-4"><button type="submit" class="btn btn-task">Atualizar informações</button></div>
                                        </div>
                                    </div>
                                <form>
                            </div>
                        </div>
                    </div>`;

                    document.getElementById("tasks").innerHTML += htmltask;

                }

            })
            .fail(function(jqXHR, textStatus, msg) {
                alert("erro");
            });
    }

    //função que popula as tasks na view
    function tasksfinish() {
        $.ajax({
                url: "/selectFinish",
                async: true,
                type: 'get',
            })
            .done(function(data) {
                document.getElementById("tasksFinish").innerHTML = '';

                data.forEach(montahtml);

                function montahtml(task) {
                    var htmltask = `
                    <div class="panelfinish panel-default pag" id="tasks-itens">
                        <div class="panel-body">
                            <div class="row">
                                <a href="#" onclick="viewAll('minhaDiv` + task.id + `')" class="col-8 col-sm-10">
                                    <input type="text" name="title" class="input-task" value="` + task.title + `">
                                </a>
                                <div class="col-2 col-sm-2">
                                    <button id="verifica" href="#" class="deletar" onclick="delet(` + task.id + `)"><i class="fas fa-trash-alt"></i></button>
                                </div>
                                <div class="col-sm-12 tasknone" id="minhaDiv` + task.id + `">
                                    {!! csrf_field() !!}
                                        <div class="col-sm-12" id="minhaDiv">
                                            <div class="col-sm-4">
                                                <textarea type="text" style="width: 100%;" name="description" class="input-task">` + task.description + `</textarea>
                                                <input type="hidden" name="id_task" value="` + task.id + `">
                                            </div>
                                            <div class="col-sm-4"><h4>Criado em` + task.created_at + `</h4></div>
                                            <div class="col-sm-4"><h4>Encerrado em ` + task.done_at + `</h4></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>`;

                    document.getElementById("tasksFinish").innerHTML += htmltask;

                }

            })
            .fail(function(jqXHR, textStatus, msg) {
                alert("erro");
            });
    }

    //chamada da função
    tasksall();
    tasksfinish();

    jQuery(document).ready(function() {

        //função insert
        jQuery('#inset_task').submit(function() {
            var dados = jQuery(this).serialize();

            jQuery.ajax({
                type: "POST",
                url: "/insert",
                data: dados,
                success: function(data) {
                    $('#ModalInsert').modal('hide');
                    tasksall();
                    tasksfinish();
                    document.getElementById('inset_task').reset();
                }
            });

            return false;
        });

        //função update
        jQuery('#update_task').submit(function() {
            var dados = jQuery(this).serialize();

            jQuery.ajax({
                type: "POST",
                url: "/update",
                data: dados,
                success: function(data) {
                    tasksall();
                    tasksfinish();
                }
            });

            return false;
        });
    });

    //função delete
    function delet(id) {
        $.ajax({
            url: "/delet/" + id,
            async: true,
            type: 'get',
        }).done(function(data) {
            tasksall();
            tasksfinish();
        });
    }

    //Alterar o status
    function alterstatus(id) {
        $.ajax({
            url: "/alterstatus/" + id,
            async: true,
            type: 'get',
        }).done(function(data) {
            tasksall();
            tasksfinish();
        });
    }

    //exibir detalhes
    function viewAll(el) {
        var display = document.getElementById(el).style.display;
        if (display == "none")
            document.getElementById(el).style.display = 'block';
        else
            document.getElementById(el).style.display = 'none';
    }
</script>
@endsection