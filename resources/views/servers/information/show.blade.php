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
                        <h3>{{ gmdate("d-m-Y H:i", $time) }}</h3>
                        <h3>
                            @if ($enabled == 1)
                                <p>Статус: работает</p>
                            @else
                                <p>Статус: выключен</p>
                            @endif
                        </h3>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-4">
                                <canvas id="myChartTemp" width="300" height="300"></canvas>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <canvas id="myChartLoadProc" width="300" height="300"></canvas>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <canvas id="myChartFanSpeed" width="300" height="300"></canvas>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <canvas id="myChartRam" width="300" height="300"></canvas>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <canvas id="myChartHDD" width="300" height="300"></canvas>
                            </div>
                        </div>

                        <script>
                        // ТЕМПЕРАТУРА ПРОЦЕССОРА

                        var ctx = document.getElementById('myChartTemp');
                        ctx.width = 300;
                        ctx.height = 300;

                        const data = {
                            labels: ['Температура'],
                            datasets: [
                                {
                                    label: 'Температура Процессора',
                                    data: [{{ $temp_proces }}],
                                    backgroundColor: [
                                        'rgba(0, 255, 47, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(0, 255, 47, 1)'
                                    ],
                                    borderWidth: 1,
                                    barThickness: 30
                                },
                                {
                                    label: 'Температура HDD',
                                    data: [{{ $temp_hard }}],
                                    backgroundColor: [
                                        'rgba(0, 111, 255, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgb(0, 111, 255)'
                                    ],
                                    borderWidth: 1,
                                    barThickness: 30
                                }
                            ]
                            };
                        
                        var myChartTemp = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            options: {
                                scales: {
                                    y: {
                                        type: 'linear',
                                        min: 0,
                                        max: 100
                                    }
                                },
                                plugins: {
                                    autocolors: false,
                                    annotation: {
                                    annotations: {
                                        line1: {
                                        type: 'line',
                                        yMin: 85,
                                        yMax: 85,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        }
                                    }
                                    }
                                }
                            }
                        });

                        // ЗАГРУЖЕННОСТЬ ПРОЦЕССОРА 

                        var ctxLoadProc = document.getElementById('myChartLoadProc');
                        ctxLoadProc.width = 300;
                        ctxLoadProc.height = 300;

                        const dataLoadProc = {
                            labels: ['Загруженность процессора'],
                            datasets: [
                                {
                                    label: 'Загруженность Процессора',
                                    data: [{{ $load_proces }}],
                                    backgroundColor: [
                                        'rgba(213, 0, 255, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(213, 0, 255, 1)'
                                    ],
                                    borderWidth: 1,
                                    barThickness: 30
                                }
                            ]
                            };
                        
                        var myChartLoadProc = new Chart(ctxLoadProc, {
                            type: 'bar',
                            data: dataLoadProc,
                            options: {
                                scales: {
                                    y: {
                                        type: 'linear',
                                        min: 0,
                                        max: 100
                                    }
                                },
                                plugins: {
                                    autocolors: false,
                                    annotation: {
                                    annotations: {
                                        line1: {
                                        type: 'line',
                                        yMin: 95,
                                        yMax: 95,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        }
                                    }
                                    }
                                }
                            }
                        });

                        // Скорость Кулера

                        var ctxFanSpeed = document.getElementById('myChartFanSpeed');
                        ctxFanSpeed.width = 300;
                        ctxFanSpeed.height = 300;

                        const dataFanSpeed = {
                            labels: ['Скорость кулера(RPM)'],
                            datasets: [
                                {
                                    label: 'Скорость кулера(RPM)',
                                    data: [{{ $speed_cooler }}],
                                    backgroundColor: [
                                        'rgba(0, 247, 255, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(0, 247, 255, 1)'
                                    ],
                                    borderWidth: 1,
                                    barThickness: 30
                                }
                            ]
                            };
                        
                        var myChartFanSpeed = new Chart(ctxFanSpeed, {
                            type: 'bar',
                            data: dataFanSpeed,
                            options: {
                                scales: {
                                    y: {
                                        type: 'linear',
                                        min: 0,
                                        max: 4500
                                    }
                                },
                                plugins: {
                                    autocolors: false,
                                    annotation: {
                                    annotations: {
                                        line1: {
                                        type: 'line',
                                        yMin: 2000,
                                        yMax: 2000,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        }
                                    }
                                    }
                                }
                            }
                        });

                        // Оперативная память

                        var ctxRam = document.getElementById('myChartRam');
                        ctxRam.width = 300;
                        ctxRam.height = 300;

                        const dataRam = {
                            labels: ['Свободной ОЗУ (МБ)'],
                            datasets: [
                                {
                                    label: 'Свободной ОЗУ(МБ)',
                                    data: [{{round(($ram / 1024),2)}}],
                                    backgroundColor: [
                                        'rgba(255, 136, 0, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 136, 0, 1)'
                                    ],
                                    borderWidth: 1,
                                    barThickness: 30
                                }
                            ]
                            };
                        
                        var myChartRam = new Chart(ctxRam, {
                            type: 'bar',
                            data: dataRam,
                            options: {
                                scales: {
                                    y: {
                                        type: 'linear',
                                        min: 0,
                                        max: 3000
                                    }
                                },
                                plugins: {
                                    autocolors: false,
                                    annotation: {
                                    annotations: {
                                        line1: {
                                        type: 'line',
                                        yMin: 500,
                                        yMax: 500,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        }
                                    }
                                    }
                                }
                            }
                        });

                        // Память ЖД

                        var ctxHDD = document.getElementById('myChartHDD');
                        ctxHDD.width = 300;
                        ctxHDD.height = 300;

                        const dataHDD = {
                            labels: ['Свободного места на ЖД(МБ)'],
                            datasets: [
                                {
                                    label: 'Свободного места на ЖД(МБ)',
                                    data: [{{round(($disc_mem / 1024),2)}}],
                                    backgroundColor: [
                                        'rgba(0, 0, 0, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(0, 0, 0, 1)'
                                    ],
                                    borderWidth: 1,
                                    barThickness: 30
                                }
                            ]
                            };
                        
                        var myChartHDD = new Chart(ctxHDD, {
                            type: 'bar',
                            data: dataHDD,
                            options: {
                                scales: {
                                    y: {
                                        type: 'linear',
                                        min: 0,
                                        max: 6000
                                    }
                                },
                                plugins: {
                                    autocolors: false,
                                    annotation: {
                                    annotations: {
                                        line1: {
                                        type: 'line',
                                        yMin: 1024,
                                        yMax: 1024,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        }
                                    }
                                    }
                                }
                            }
                        });
                    </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
@endsection