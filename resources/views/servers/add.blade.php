@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Добавление сервера') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('servers') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                          <label for="inputName" class="col-sm-2 col-form-label">Название</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="inputName" name="name">
                            @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <label for="inputHost" class="col-sm-2 col-form-label">Хост</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control @error('host') is-invalid @enderror" value="{{ old('host') }}" id="inputHost" name="host">
                            @error('host')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputHTTP" class="col-sm-2 col-form-label">HTTP Порт</label>
                          <div class="col-sm-2">
                            <input type="number" class="form-control @error('http_port') is-invalid @enderror" id="inputHTTP" value="{{ old('http_port') }}" name="http_port">
                            @error('http_port')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputHTTPS" class="col-sm-2 col-form-label">HTTPS Порт</label>
                          <div class="col-sm-2">
                            <input type="number" class="form-control @error('https_port') is-invalid @enderror" id="inputHTTPS" value="{{ old('https_port') }}" name="https_port">
                            @error('https_port')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputOwner" class="col-sm-2 col-form-label">Владелец</label>
                            <div class="col-sm-6">
                                <select class="form-select form-select-lg @error('owner') is-invalid @enderror" value="{{ old('owner') }}" aria-label="Default select example" name="owner">
                                    <option selected>Open this select menu</option>
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
                        <div class="row mb-3">
                            <label class="form-check-label col-sm-2" for="enabled">
                                Включен
                            </label>
                            <div class="col-sm-10">
                              <input class="checkEnabled form-check-input @error('enabled') is-invalid @enderror" style="margin-left: 0" type="checkbox" value="{{ old('enabled') }}" id="enabled" name="enabled">
                              @error('enabled')
                                <span class="invalid-feedback p-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-5">Добавить</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(".checkEnabled").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', 'true');
    } else {
      $(this).attr('value', 'false');
    }
  });
</script>
@endsection