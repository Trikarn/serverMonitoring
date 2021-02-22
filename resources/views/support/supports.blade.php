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
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>02.02.2021</td>
                                    <td>Вопросы</td>
                                    <td>Здравствуйте! Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, animi!</td>
                                    <td>В работе</td>
                                    <td><a href="#" class="btn btn-primary btn-sm">Просмотр</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                
                    {{ __('You are logged in!') }}
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
            <form method="POST" action="{{ url('servers') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row mb-3">
                    <label for="inputOwner" class="col-sm-2 col-form-label">Тип</label>
                    <div class="col-sm-6">
                        <select class="form-select form-select-lg @error('owner') is-invalid @enderror" value="{{ old('owner') }}" aria-label="Default select example" name="owner">
                            <option selected>Open this select menu</option>
                            <option value="1">Общие вопросы</option>
                            <option value="2">Пожелания</option>
                            <option value="3">Ошибки</option>
                            <option value="3">Другое</option>
                        </select>
                        @error('owner')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                </div>
                <div class="row mb-3">
                  <label for="inputName" class="col-sm-2 col-form-label">Сообщение</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="inputName" name="name">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary">Добавить</button>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection