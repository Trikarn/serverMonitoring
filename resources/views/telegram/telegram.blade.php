@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Телеграмм-каналы') }}
                    <a href="/telegram/create" class="btn btn-primary float-right">Добавить</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">ID чата</th>
                                    <th scope="col">Токен</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="telegrams">
                            
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
        $('.telegrams').html('');
        $.ajax({
            url: '/ajax/telegram',
            success: function(elements) {
                console.log(elements);
                elements.forEach(function(element) {
                    string = '<tr> <th scope="row">'+element.id+'</th> <th scope="row">'+element.name+'</th> <td>'+element.chat+'</td><td>'+element.token+'</td>';
                    string += '<td> <a href="/telegram/'+element.id+'/edit" class="button-manage" role="button"> <svg class="bi" width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#gear-fill"/> </svg></a> </td>';
                    string += '<td><a class="button-remove delete" role="button" data-id='+element.id+'> <svg class="bi" width="32" height="32" fill="currentColor"> <use xlink:href="bootstrap-icons.svg#trash-fill"/> </svg> </a> </td> </tr>';
                    $('.telegrams').append(string);
                });
            },
            error: function() {

            }
        });
    }
    $(document).ready(function() {
        show();
        
        $(document).on('click', '.delete',function() {
            let id = $(this).attr('data-id');
            $.ajax({
                url: '/telegram/'+id+'/destroy',
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