@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Изменение сервера') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="PUT" action="{{ url('servers/') }}">
                        <div class="row mb-3">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Название</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputPassword3" class="col-sm-2 col-form-label">Хост</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputPassword3">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputPassword3" class="col-sm-2 col-form-label">HTTP Порт</label>
                          <div class="col-sm-2">
                            <input type="number" class="form-control" id="inputPassword3">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputPassword3" class="col-sm-2 col-form-label">HTTPS Порт</label>
                          <div class="col-sm-2">
                            <input type="number" class="form-control" id="inputPassword3">
                          </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Владелец</label>
                            <div class="col-sm-6">
                                <select class="form-select form-select-lg" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                              </div>
                           
                        </div>
                        <div class="row mb-3">
                            <label class="form-check-label col-sm-2" for="flexCheckDefault">
                                Включен
                            </label>
                            <div class="col-sm-10">
                                <input class="form-check-input" style="margin-left: 0" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-5">Изменить</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection