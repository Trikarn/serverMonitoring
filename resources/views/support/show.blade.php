@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Обращение') }}
                </div>

                <div class="card-body">
                    <div class="alert alert-success myAlert" style="display: none" role="alert">
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->type == 'admin')
                    <div class="row" style="margin: 10px 5px">
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option value="" disabled selected>Выберите статус</option>
                            @if ($status == 'new')
                                <option value="new" selected>Новый</option>
                            @else
                                <option value="new">Новый</option>
                            @endif
                            @if ($status == 'work')
                                <option value="work" selected>В работе</option>
                            @else
                            <option value="work">В работе</option>
                            @endif
                            @if ($status == 'closed')
                                <option value="closed" selected>Закрыто</option>                            
                            @else
                            <option value="closed">Закрыто</option>
                            @endif
                        </select>
                    </div>
                    @endif
                    <div class="group-rom"> 
                        <div class="row">
                            <div class="first-part odd col-4">
                                {{ $author }}
                                <div style="font-size: 10px">
                                    {{ gmdate("d-m-Y H:i", $date) }}
                                </div> 
                            </div> 
                            <div class="second-part col-8">
                                {{ $text }}
                            </div> 
                        </div> 
                    </div>

                    <div class="comments">
                    </div>
                    @if ($status != 'closed')
                    <form action="{{ "/supports/$id" }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label style="margin-top: 20px" for="exampleFormControlTextarea1" class="form-label">Новый комментарий</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1"rows="3" name="message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Новый комментарий</button>
                    </form>
                    @endif
                    

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function show() {
        $('.comments').html('');
        $.ajax({
            url: '{{ "/ajax/supports/$id/comments" }}',
            success: function(elements) {
                elements.forEach(function(element) {
                    string = '<div class="group-rom"> <div class="row">' 
                    +'<div class="first-part odd col-4">'+element.username
                    +'<div style="font-size: 10px"> '+element.date+' </div> </div>' 
                    +'<div class="second-part col-8">'+element.message+'</div> </div> </div>';
                    $('.comments').append(string);
                });
            },
            error: function() {

            }
        });
    }
    $(document).ready(function() {
        show();
        
        $(document).on('click', '.add',function() {
            $.ajax({
                url: '/supports',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'type' : $("select[name='type']").val(),
                    'text' : $("input[name='text']").val(),
                },
                success: function() {
                },
                error: function(err) {
                    if (err.status == 422) { // when status code is 422, it's a validation issue
                        $('.error').remove();                       
                        // you can loop through the errors object and show it to the user
                        // display errors on each form field
                        $.each(err.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="'+i+'"]');
                            el.after($('<span class="error" style="color: red;">'+error[0]+'</span>'));
                        });
                    }
                }
            });
        });
    });

    $('select[name="status"]').change(function() {
        $.ajax({
            url: '{{ "/ajax/supports/$id/change-status" }}',
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'status' : $("select[name='status']").val(),
            },
            success: function() {
                $('.myAlert').html('');
                $('.myAlert').html('Статус изменен').show(0).delay(3000).hide(0);
            },
            error: function() {
                
            }
        });
    });
</script>
@endsection