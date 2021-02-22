@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Сервера') }}
                    <a href="/servers/create" class="btn btn-primary float-right">Добавить</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- <div class='item-list-1 row fw-bold'> --}}
                    {{-- <div class='row'>
                        <div class='col-3'>Название</div>
                        <div class='col-6' >Хост</div>
                        <div class='col-3' >Включен</div>
                    </div>
                    <div class='row'>
                        <div class='col-3'>Test</div>
                        <div class='col-6' >123123123123123</div>
                        <div class='col-3' >Yes</div>
                    </div> --}}
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Хост</th>
                                    <th scope="col">Включен</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="servers">
                                    {{-- <tr>
                                        <th scope="row">element->id</th>
                                        <th scope="row">element->name</th>
                                        <td>element->host</td>
                                        <td><input style="margin-left: 20px" class="form-check-input" type="checkbox"></td>
                                        <td><a href="#" class="btn btn-primary btn-sm">Информация</a></td>
                                        <td>
                                            <a class="button-manage" role="button">
                                                <svg class="bi" width="32" height="32" fill="currentColor">
                                                    <use xlink:href="bootstrap-icons.svg#gear-fill"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="button-manage" role="button">
                                                <svg class="bi" width="32" height="32" fill="currentColor">
                                                    <use xlink:href="bootstrap-icons.svg#heart-fill"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="button-remove" role="button">
                                                <svg class="bi" width="32" height="32" fill="currentColor">
                                                    <use xlink:href="bootstrap-icons.svg#trash-fill"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Request::url() == 'http://server-monitoring/favorite')
    12313123313
    @endif
</div>

<script>
    function show() {
        $('.servers').html('');
        $.ajax({
            url: '/ajax/servers',
            @if(Request::url() == 'http://server-monitoring/favorite')
            data: {
                'favorite' : '1'
            },
            @endif
            success: function(elements) {
                elements.forEach(function(element) {
                    string = '<tr> <th scope="row">'+element.id+'</th> <th scope="row">'+element.name+'</th> <td>'+element.host+'</td>';
                    if(element.enabled == 1) {
                        string += '<td><input style="margin-left: 20px" class="form-check-input" type="checkbox" onclick="return false;" checked></td>';
                    } else {
                        string += '<td><input style="margin-left: 20px" class="form-check-input" type="checkbox" onclick="return false;"></td>';
                    }
                    string += '<td><a href="#" class="btn btn-primary btn-sm">Информация</a></td> <td> <a href="/servers/'+element.id+'/edit" class="button-manage" role="button"> <svg class="bi" width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#gear-fill"/> </svg></a> </td>';
                    if(element.favorite == 1) {
                        string += '<td> <a class="button-manage" id="favorite" role="button" data-favorite='+element.id+'> <svg class="bi heart" data-id='+element.id+' width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#heart-fill"/> </svg> </a></td>';
                    } else {
                        string += '<td> <a class="button-manage" id="favorite" role="button" data-favorite='+element.id+'> <svg class="bi heart" data-id='+element.id+' width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#heart"/> </svg> </a></td>';
                    }
                    string += '<td><a class="button-remove delete" role="button" data-id='+element.id+'> <svg class="bi" width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#trash-fill"/> </svg> </a> </td> </tr>';

                    $('.servers').append(string);
                });
            },
            error: function() {

            }
        });
    }
    $(document).ready(function() {
        show();
        $(document).on('click', '#favorite',function() {
            let id = $(this).attr('data-favorite');
            let favorite = this;
            $.ajax({
                url: '/servers/'+id+'/favorite',
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(status) {
                    if(status == 1) {
                        $(favorite).html('<svg class="bi heart" data-id='+id+' width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#heart-fill"/> </svg>');
                    } else {
                        $(favorite).html('<svg class="bi heart" data-id='+id+' width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#heart"/> </svg>');
                    }
                },
                error: function() {
                    console.log(123);
                }
            });
        });

        $(document).on('click', '.delete',function() {
            let id = $(this).attr('data-id');
            $.ajax({
                url: '/servers/'+id+'/destroy',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                   console.log(321);
                   show();
                },
                error: function() {
                    console.log(123);
                }
            });
        });
    });
</script>
@endsection