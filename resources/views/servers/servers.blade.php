@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Сервера') }}
                    @if (Auth::user()->type != 'admin')
                    <a href="/servers/create" class="btn btn-primary float-right">Добавить</a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row" style="margin: 10px 5px">
                        <select onchange="show()" class="form-select" name="status" aria-label="Default select example">
                            <option value="" checked>Статус</option>
                            <option value="1">Включен</option>
                            <option value="0">Выключен</option>
                        </select>
                    @if (Auth::user()->type == 'admin')
                        <select onchange="show()" style="margin-left: 20px" name="users" class="form-select" name="status" aria-label="Default select example">
                            <option value="" checked>Пользователи</option>
                            @foreach ($allUsers as $allUser)
                                <option value="{{ $allUser->id }}">{{ $allUser->username }}</option> 
                            @endforeach
                        </select>
                    @endif
                    </div>

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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function show() {
        $('.servers').html('');
        $.ajax({
            url: '/ajax/servers',
            @if(Request::url() == 'http://server-monitoring/favorite')
            data: {
                'favorite' : '1',
                'status' : $('select[name="status"]').val(),
                'users' : $('select[name="users"]').val(),
            },
            @else
            data: {
                'status' : $('select[name="status"]').val(),
                'users' : $('select[name="users"]').val(),
            },
            @endif
            success: function(elements) {
                if(elements.length == 0) {
                    $('.servers').append('<tr><td colspan="4">Ничего не найдено</td></tr>');
                }
                elements.forEach(function(element) {
                    string = '<tr> <th scope="row">'+element.id+'</th> <th scope="row">'+element.name+'</th> <td>'+element.host+'</td>';
                    if(element.enabled == 1) {
                        string += '<td><input style="margin-left: 20px" class="form-check-input" type="checkbox" onclick="return false;" checked></td>';
                    } else {
                        string += '<td><input style="margin-left: 20px" class="form-check-input" type="checkbox" onclick="return false;"></td>';
                    }
                    string += '<td><a href="/servers/'+element.id+'/info" class="btn btn-primary btn-sm">Информация</a></td> <td> <a href="/servers/'+element.id+'/edit" class="button-manage" role="button"> <svg class="bi" width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#gear-fill"/> </svg></a> </td>';
                    @if (Auth::user()->type != 'admin')
                        if(element.favorite == 1) {
                            string += '<td> <a class="button-manage" id="favorite" role="button" data-favorite='+element.id+'> <svg class="bi heart" data-id='+element.id+' width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#heart-fill"/> </svg> </a></td>';
                        } else {
                            string += '<td> <a class="button-manage" id="favorite" role="button" data-favorite='+element.id+'> <svg class="bi heart" data-id='+element.id+' width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#heart"/> </svg> </a></td>';
                        }
                    @endif
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
                   show();
                },
                error: function() {
                }
            });
        });
    });
</script>
@endsection