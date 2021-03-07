@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Изменение телеграмм-канала') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ '/telegram/'.$id }}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="row mb-3">
                          <label for="inputName" class="col-sm-2 col-form-label">Название</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $name }}" id="inputName" name="name">
                            @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <label for="inputHost" class="col-sm-2 col-form-label">Chat ID</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('chat') is-invalid @enderror" value="{{ $chat }}" id="inputHost" name="chat">
                            @error('chat')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputHost" class="col-sm-2 col-form-label">Token</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('token') is-invalid @enderror" value="{{ $token }}" id="inputHost" name="token">
                            @error('token')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        @if (Auth::user()->isAdmin())
                          <div class="row mb-3">
                            <label for="inputOwner" class="col-sm-2 col-form-label">Владелец</label>
                            <div class="col-sm-6">
                                <select class="form-select form-select-lg @error('owner') is-invalid @enderror" value="{{ old('owner') }}" aria-label="Default select example" name="owner">
                                    <option selected>Выберите владельца</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                @error('owner')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                          </div>
                        @else
                            <input type="hidden" name="owner" value="{{ $owner }}">
                        @endif
                        <button type="submit" class="btn btn-success mt-5">Изменить</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection