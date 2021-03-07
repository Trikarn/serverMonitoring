@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Информация') }}
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
                            <option value="1">Включен</option>
                            <option value="0">Выключен</option>
                        </select>
                        <select style="margin-left: 10px" onchange="show()" class="form-select" name="order" aria-label="Default select example">
                            <option value="" checked>Сортировка</option>
                            <option value="temp_proces">Температура процессора</option>
                            <option value="load_proces">Нагрузка процессора</option>
                            <option value="temp_hard">Температура жесткого диска</option>
                            <option value="disc_mem">Место на HDD</option>
                            <option value="ram">RAM</option>
                            <option value="speed_cooler">Скорость кулера</option>
                            <option value="time">Время</option>
                        </select>

                        <div class="date" style="margin-left: 30px; padding-left: 10px;">
                            <label for="dateFrom">От</label>
                            <input onchange="show()" type="datetime-local" name="dateFrom" id="dateFrom">
                            <label for="dateTo">До</label>
                            <input onchange="show()" type="datetime-local" name="dateTo" id="dateTo">
                        </div>
                    </div>


                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Время</th>
                                    <th scope="col">Включен</th>
                                    <th scope="col">Температура процессора, °С</th>
                                    <th scope="col">Нагрузка процессора, %</th>
                                    <th scope="col">Температура HDD, °С</th>
                                    <th scope="col">Место на HDD, МБ</th>
                                    <th scope="col">RAM, МБ</th>
                                    <th scope="col">Скорость кулера, о/с</th>
                                </tr>
                            </thead>
                            <tbody class="info">
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" class="paginationNav" style="display: none">
                            <ul class="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function show(limit = 15, offset = 0) {
        let dateFrom = convertDateToUnix($('input[name="dateFrom"]').val());
        let dateTo = convertDateToUnix($('input[name="dateTo"]').val());

        $.ajax({
            url: '/ajax/servers/{{ $id }}/full-information',
            data: {
                'status' : $('select[name="status"]').val(),
                'sort' : $('select[name="order"]').val(),
                'dateFrom' : dateFrom,
                'dateTo' : dateTo,
                'limit' : limit,
                'offset' : offset,
                'count' : true,
            },
            success: function(result) {
                $('.info').html('');
                $('.pagination').html('');
                // console.log(result);
                let elements = result.information
                if(elements.length == 0) {
                    $('.info').append('<tr><td colspan="4">Ничего не найдено</td></tr>');
                }
                elements.forEach(function(element) {
                    string = '<tr data-href="{{ Request::path() }}/'+element.id+'" style="cursor:pointer"> <th scope="row">'+element.id+'</th> <th scope="row">'+timeConverter(element.time)+'</th>';
                    if(element.enabled == 1) {
                        string += '<td><input style="margin-left: 20px" class="form-check-input" type="checkbox" onclick="return false;" checked></td>';
                    } else {
                        string += '<td><input style="margin-left: 20px" class="form-check-input" type="checkbox" onclick="return false;"></td>';
                    }
                    string += '<td>'+element.temp_proces+'</td><td>'+element.load_proces+'</td>';
                    string += '<td>'+element.temp_hard+'</td><td>'+(element.disc_mem / 1024).toFixed(2)+'</td>';
                    string += '<td>'+(element.ram / 1024).toFixed(2)+'</td><td>'+element.speed_cooler+'</td></tr>';

                    $('.info').append(string);
                });

                let pagination = Math.ceil(result.count / limit);
                if(pagination > 1) {
                    for(let i = 1;i <= pagination; i++) {
                        let currentPage = offset / limit;
                        if((i - parseInt(1)) == currentPage ) {
                            $('.pagination').append('<li class="page-item active"><a class="page-link" href="#" value='+i+'>'+i+'</a></li>')
                        } else {
                            $('.pagination').append('<li class="page-item"><a class="page-link" href="#" value='+i+'>'+i+'</a></li>')
                        }
                    }
                    $('.paginationNav').show();
                    
                    $('.page-link').click(function() {
                        let num = $(this).attr('value');
                        let newOffset = (num * limit) - limit;
                        show(limit, newOffset);
                    });
                }

                $('tr[data-href]').on("click", function() {
                    document.location = '/'+$(this).data('href');
                });

            },
            error: function() {

            }
        });
    }
    $(document).ready(function() {
        show();
    });

    function timeConverter(timestamp){
        var date = new Date(timestamp * 1000);
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        minutes = minutes < 10 ? '0'+minutes : minutes;

        var formattedTime = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes;

        return formattedTime;
    }

    function convertDateToUnix(date) {
        let unixTime = new Date(date).getTime() / 1000
        return unixTime
    }
</script>
@endsection