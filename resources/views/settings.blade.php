@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Настройки') }}
                </div>

                <div class="card-body">
                    <div class="alert alert-success myAlert" style="display: none" role="alert">
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="comments">
                    </div>

                    <form method="POST" action="{{ url('servers') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h4>Смена пароля</h4>
                        <div class="row mb-3">
                          <label for="inputName1" class="col-sm-2 col-form-label">Текущий пароль</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('oldPass') is-invalid @enderror" value="{{ old('oldPass') }}" id="inputName1" name="oldPassword">
                            @error('oldPass')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputName" class="col-sm-2 col-form-label">Новый пароль</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('newPass') is-invalid @enderror" value="{{ old('newPass') }}" id="inputName" name="newPassword">
                            @error('newPass')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Изменить пароль</button>
                      </form>
                    

                </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>
@endsection