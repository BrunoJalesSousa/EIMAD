@extends('layouts/contentNavbarLayout')

@section('title', 'Contas')

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
<div class="row">
  <div class="col-lg-12 mb-12 order-0">
    <div class="card">
      <div class="flex-row d-flex">
        <div class="card-title h4 mt-3 mx-3 me-0 mb-o">Contas</div>
        <div class="bx bx-video h4 mt-3 mx-3 me-0 mb-0"></div>
      </div>
      <hr class="mt-0">
      <div class="card-body">
        <div class="d-flex flex-row-reverse">
          <a href="{{ Route('add-account') }}">
            <button id="add-btn" type="button" class="btn btn-primary">
              Adicionar
            </button>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
            <tr>
              <th>NOME</th>
              <th>EMAIL</th>
              <th>AÇÕES</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($users as $item)
            <tr>
              <td>{{ $item['name']  }}</td>
              <td>{{ $item['email']  }}</td>
              <td>
                @if($item->email == Auth::user()->email)

                @else
                  <button type="button" class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delAccount{{ str_replace(' ', '', $item->name) }}">
                    <span class="tf-icons bx bx-trash"></span>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="delAccount{{str_replace(' ', '', $item->name)}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalCenterTitle">Apagar a conta do email {{$item->email}}?</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Voltar"></button>
                        </div>
                        <form action="{{ route('del-account', $item->name) }}" method="get">
                          @csrf
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                            <button type="submit" class="btn btn-danger">Apagar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endif
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="position-absolute" style="right: 1rem; top: 100px; z-index: 1000;">
  @if (Session::has('message'))
    <div class="bs-toast toast fade show bg-{{ Session::get('style') }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
      <div class="toast-header">
        <i class='bx bx-check me-2'></i>
        <div class="me-auto fw-medium">{{ Session::get('title') }}</div>
        <small>Agora</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ Session::get('message') }}
      </div>
    </div>
  @endif
</div>
@endsection
