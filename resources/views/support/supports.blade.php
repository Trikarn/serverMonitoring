@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Обращения') }}
                    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Добавить
                    </button>
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
                            <option value="new">Новый</option>
                            <option value="work">В работе</option>
                            <option value="closed">Закрыто</option>
                        </select>
                    </div>
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Дата</th>
                                    <th scope="col">Тип</th>
                                    <th scope="col">Текст</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="supports">
                                <tr>
                                    {{-- <th scope="row">1</th>
                                    <td>02.02.2021</td>
                                    <td>Вопросы</td>
                                    <td>Здравствуйте! Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, animi!</td>
                                    <td>В работе</td>
                                    <td><a href="#" class="btn btn-primary btn-sm">Просмотр</a></td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Создание обращения</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row mb-3">
                    <label for="inputOwner" class="col-sm-2 col-form-label">Тип</label>
                    <div class="col-sm-6">
                        <select style="display: block" class="form-select form-select-lg @error('type') is-invalid @enderror" required value="{{ old('type') }}" aria-label="Default select example" name="type">
                            <option disabled selected>Выберите тему</option>
                            <option value="general_issues">Общие вопросы</option>
                            <option value="wishes">Пожелания</option>
                            <option value="errors">Ошибки</option>
                            <option value="other">Другое</option>
                        </select>
                        @error('type')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                </div>
                <div class="row mb-3">
                  <label for="inputName" class="col-sm-2 col-form-label">Сообщение</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control @error('text') is-invalid @enderror" required value="{{ old('text') }}" id="inputName" name="text">
                    @error('text')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary add">Добавить</button>
        </form>
        </div>
    </div>
    </div>
</div>
<script>
    function show() {
        $('.supports').html('');
        $.ajax({
            url: '/ajax/supports',
            data: {
                'status' : $('select[name="status"]').val(),
            },
            success: function(elements) {
                if(elements.length == 0) {
                    $('.supports').append('<tr><td>Ничего не найдено</td></tr>');
                }
                elements.forEach(function(element) {
                    string = '<tr> <th scope="row">'+element.id+'</th> <th scope="row">'+element.date+'</th> <td>'+element.type+'</td><td>'+element.text.slice(0, 20)+'</td><td>'+element.status+'</td>';
                    string += '<td><a href="/supports/'+element.id+'/show" class="btn btn-primary btn-sm">Просмотр</a></td>';
                    $('.supports').append(string);
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
                    show();
                    $('#exampleModal').modal('hide');
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
</script>
@endsection