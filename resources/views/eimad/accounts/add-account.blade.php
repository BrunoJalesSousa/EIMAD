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
        <div class="card-title h4 mt-3 mx-3 me-0 mb-o">Registar Conta</div>
        <div class="bx bx-video h4 mt-3 mx-3 me-0 mb-0"></div>
      </div>
      <hr class="mt-0">
      <div style="width: 40%; margin-left: auto; margin-right: auto;">
        <form id="formAuthentication" class="mb-3" action="{{ route('register-account') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-lg-12 mb-12 order-0">
              <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" autofocus>
                @error('name')
                  <div class="alert alert-danger mt-2 mb-0">O valor para o nome é inválido!</div>
                @enderror
              </div>
            </div>
            <div class="col-lg-12 mb-12 order-0">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
                @error('email')
                  <div class="alert alert-danger mt-2 mb-0">O valor para o email é inválido!</div>
                @enderror
              </div>
            </div>
            <div class="col-lg-12 mb-12 order-0">
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                @error('password')
                  <div class="alert alert-danger mt-2 mb-0">O valor para a password é inválido!</div>
                @enderror
              </div>
            </div>
            <div class="col-lg-12 mb-12 order-0">
              <div class="mb-3">
                <label for="repeat-password" class="form-label">Repetir Password</label>
                <input type="password" class="form-control" id="repeat-password" name="repeatPassword" placeholder="Repetir password">
                @error('repeatPassword')
                  <div class="alert alert-danger mt-2 mb-0">As passwords não são iguais!</div>
                @enderror
              </div>
            </div>
            <div class="row" style="position:relative; left: 1rem;">
              <div class="col-lg-6 mb-6">
                <a href="{{ route('users') }}">
                  <button type="submit" class="btn btn-secondary d-grid w-100">
                    Voltar
                  </button>
                </a>
              </div>
              <div class="col-lg-6 mb-6">
                <button type="submit" class="btn btn-primary d-grid w-100">
                  Registar Conta
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection
