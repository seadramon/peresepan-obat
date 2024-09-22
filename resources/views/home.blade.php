@extends('layouts.app', [
        'class' => '',
        'parentActive' => '',
        'elementActive' => 'home'
])

@section('title', 'Hello, ' . \Auth::user()->name)

@section('content')

<!-- START ALERTS AND CALLOUTS -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Selamat datang di Web Aplikasi Peresepan Obat
                </h3>
            </div>

            <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec suscipit ipsum non quam dictum, eu ornare libero venenatis. Integer porttitor id justo a gravida. Proin congue tortor et sem interdum, sit amet tincidunt velit sodales. Duis est urna, lacinia sed lacinia vel, laoreet eget metus. </p>
            </div>
        </div>
    </div>

</div>
<!-- /.row -->
<!-- /.card -->
@endsection