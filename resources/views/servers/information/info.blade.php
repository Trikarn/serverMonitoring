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
                        <div class="row">
                            <div class="col-6">
                                <a href="/servers/{{ $serverId }}/full-information" role="button" style="margin-bottom: 10px" class="btn btn-info">Полная информация</a>
                            </div>
                        </div>
                        <h3>Последняя информация</h3>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Последнее обновление: 02.03.2021 17:46</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Статус: работает</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Температура процессора: 80</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Загруженность процессора: 42%</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Скорость кулера: 1800 о/с</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Свободное ОЗУ: 28396/480540</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Свободное место на жестком диске: 1.7G/25G</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Температура жесткого диска: 65</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <h2>Общая информация</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Средняя температура процессора: 80</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Средняя загруженность процессора: 42%</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Средняя скорость кулера: 1800 о/с</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Среднее кол-во свободного ОЗУ: 28396/480540</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Средняя температура жесткого диска: 65</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <h2>Критическая нагрузка</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Температура процессора: 85°C</p>
                                <p>01.01.2021 15:45</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Температура жесткого диска: 90°C </p>
                               <p>01.01.2021 17:54</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Последнее выключение 01.01.2021 15:51</p>
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