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
                                <p>Последнее обновление: {{ gmdate("d-m-Y H:i", $lastInfo['0']->time) }}</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                @if ($lastInfo['0']->enabled == 1)
                                    <p>Статус: работает</p>
                                @else
                                    <p>Статус: выключен</p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Температура процессора: {{ $lastInfo['0']->temp_proces }} °C</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Загруженность процессора: {{ $lastInfo['0']->load_proces }} %</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Скорость кулера: {{ $lastInfo['0']->speed_cooler }} о/с</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Свободное ОЗУ: {{ round(($lastInfo['0']->ram / 1024),2) }} МБ</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Свободное место на жестком диске: {{ round(($lastInfo['0']->disc_mem / 1024),2) }} МБ</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Температура жесткого диска: {{ $lastInfo['0']->temp_hard }} °C</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <h2>Общая информация</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Средняя температура процессора: {{ $average['avgTemp'] }} °C</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Средняя загруженность процессора: {{ $average['avgLoadProc'] }} %</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Средняя скорость кулера: {{ $average['avgSpeedCool'] }} о/с</p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>Среднее кол-во свободного ОЗУ: {{ $average['avgRam'] }} МБ</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Средняя температура жесткого диска: {{ $average['avgTempHDD'] }} °C</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <h2>Критическая нагрузка</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Температура процессора: {{ $critical['critTempProc']['0']->temp_proces }} °C</p>
                                <p>{{ gmdate("d-m-Y H:i",$critical['critTempProc']['0']->time) }}</p>
                            </div>
                            <div class="col-12 col-sm-6">
                               <p>Температура жесткого диска: {{ $critical['critTempHDD']['0']->temp_hard }} °C </p>
                               <p>{{ gmdate("d-m-Y H:i",$critical['critTempHDD']['0']->time) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Последнее выключение {{ gmdate("d-m-Y H:i",$critical['lastDisable']['0']->time) }}</p>
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