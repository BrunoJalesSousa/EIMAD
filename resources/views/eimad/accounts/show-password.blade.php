@extends('layouts/contentNavbarLayout')

@section('title', 'Media - Videos')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection


@section('content')

    <div class="card">
      <div class="flex-row d-flex">
        <div class="card-title h4 mt-3 mx-3 me-0 mb-o">Conta criada com sucesso!</div>
        <div class="bx bx-video h4 mt-3 mx-3 me-0 mb-0"></div>
      </div>
      <hr class="mt-0">
      <div style="width: 75%; margin-left: auto; margin-right: auto;">
        <h5>Esta é a password gerada</h5><br>
        <h5><u>Não voltará a ter acesso a esta password!</u></h5><br>
        <h5>Password: {{ $password }}</h5>
        <a href="{{ Route('users') }}">
          <button class="btn btn-primary d-grid w-100">Voltar</button>
        </a>
      </div>
    </div>
@endsection
