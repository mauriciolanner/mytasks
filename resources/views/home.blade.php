@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 refresh text-center">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
        </div>
        <div class="col-md-12" id="tasks">

            <!--div class="panel panel-default" id="tasks-itens">
                <div class="panel-body">
                    <div class="row">
                        <a href="#" onclick="Mudarestado('minhaDiv')" class="col-8 col-sm-10">
                            <h3>titulo</h3>
                        </a>
                        <div class="col-2 col-sm-2"><input type="checkbox" class="switch_1"></div>
                        <div class="col-sm-12" id="minhaDiv">
                            <div class="col-sm-4">s</div>
                            <div class="col-sm-4">s</div>
                            <div class="col-sm-4">atualizar</div>
                        </div>
                    </div>
                </div>
            </div-->

        </div>
        <a id="scroll-top" href="#top-bar-menu" data-toggle="modal" data-target="#ModalInsert">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>
    </div>
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





                    <div class="panel panel-default" id="tasks-itens">
                        <div class="panel-body">
                            <div class="row">
                            <form action="/update"  method="post">
                                <a href="#" onclick="Mudarestado('minhaDiv` + task.id + `')" class="col-8 col-sm-10">
                                    <input type="text" name="title" class="input-task" value="` + task.title + `">
                                </a>
                                <div class="col-2 col-sm-2">
                                    <input type="checkbox" id="verifica" onclick="verifyRadio(` + task.id + `)" class="switch_1">
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

    //chamada da função
    tasksall();

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
                }
            });

            return false;
        });
    });

    //função delete
    function verifyRadio(id) {
        $.ajax({
            url: "/delet/" + id,
            async: true,
            type: 'get',
        }).done(function(data) {
            tasksall();
        });
    }

    //exibir detalhes
    function Mudarestado(el) {
        var display = document.getElementById(el).style.display;
        if (display == "none")
            document.getElementById(el).style.display = 'block';
        else
            document.getElementById(el).style.display = 'none';
    }
</script>
@endsection