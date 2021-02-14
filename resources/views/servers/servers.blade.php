@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Сервера') }}
                    <a href="/servers/create" class="btn btn-primary float-right">Добавить</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- <div class='item-list-1 row fw-bold'> --}}
                    {{-- <div class='row'>
                        <div class='col-3'>Название</div>
                        <div class='col-6' >Хост</div>
                        <div class='col-3' >Включен</div>
                    </div>
                    <div class='row'>
                        <div class='col-3'>Test</div>
                        <div class='col-6' >123123123123123</div>
                        <div class='col-3' >Yes</div>
                    </div> --}}
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Хост</th>
                                    <th scope="col">Включен</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Test Name</td>
                                    <td>www.bignameurl1231фывфвффывфывфывы23.com</td>
                                    <td>true</td>
                                    <td><a href="#" class="btn btn-primary btn-sm">Информация</a></td>
                                    <td>
                                        <a class="button-manage" role="button">
                                            <svg class="bi" width="32" height="32" fill="currentColor">
                                                <use xlink:href="bootstrap-icons.svg#gear-fill"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="button-manage" role="button">
                                            <svg class="bi" width="32" height="32" fill="currentColor">
                                                <use xlink:href="bootstrap-icons.svg#heart-fill"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="button-remove" role="button">
                                            <svg class="bi" width="32" height="32" fill="currentColor">
                                                <use xlink:href="bootstrap-icons.svg#trash-fill"/>
                                            </svg>
                                        </a>
                                    </td>
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
@endsection