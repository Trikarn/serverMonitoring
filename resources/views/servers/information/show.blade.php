@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Информация о сервере') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                        <h3>Информация</h3>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Время: {{ gmdate("d-m-Y H:i", $time) }}</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                @if ($enabled == 1)
                                    <p>Статус: работает</p>
                                @else
                                    <p>Статус: выключен</p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Температура процессора: {{ $temp_proces }} °C</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Загруженность процессора: {{ $load_proces }} %</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Скорость кулера: {{ $speed_cooler }} о/с</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Свободное ОЗУ: {{ round(($ram / 1024),2) }} МБ</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Свободное место на жестком диске: {{ round(($disc_mem / 1024),2) }} МБ</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Температура жесткого диска: {{ $temp_hard }} °C</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
@endsection