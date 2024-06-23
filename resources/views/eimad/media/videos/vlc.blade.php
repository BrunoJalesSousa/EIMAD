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

<script>
    document.addEventListener('DOMContentLoaded', function () {
      let btn;
      @if(Session::has('edit-modal'))
        btn = document.getElementById('edit-btn{{ Session::get('edit-modal') }}');
        btn.click();
      @elseif(Session::has('add-modal'))
        btn = document.getElementById('add-btn');
        btn.click();
      @endif
    });

</script>

@section('content')
<div class="row">
  <div class="col-lg-12 mb-12 order-0">
    <div class="card">
      <div class="flex-row d-flex">
        <div class="card-title h4 mt-3 mx-3 me-0 mb-o">VLC</div>
        <div class="bx bx-video h4 mt-3 mx-3 me-0 mb-0"></div>
      </div>
      <hr class="mt-0">
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Ações
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('loop-video-vlc')}}">Passar todos</a></li>
                <li><a class="dropdown-item" href="{{route('pause-video-vlc')}}">Pausar/Continuar</a></li>
                <li><a class="dropdown-item" href="{{route('clear-queue-vlc')}}">Limpar fila</a></li>
                <li><a class="dropdown-item" href="{{route('loop-video-vlc')}}">Ligar loop</a></li>
                <li><a class="dropdown-item" href="{{route('stop-video-vlc')}}">Parar</a></li>
                <li><a class="dropdown-item" href="{{route('fullscreen-video-vlc')}}">Fullscreen</a></li>
                <li><a class="dropdown-item" href="{{route('media-sync')}}">Sincronizar com pasta</a></li>
                <li><a class="dropdown-item" href="{{route('open-vlc')}}">Tentar abrir VLC...</a></li>
              </ul>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex justify-content-end flex-wrap">
              <button id="add-btn" type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#addMedia">
                Adicionar
              </button>
              <button id="del-all-btn" type="button" class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#delAllMedia">
                Apagar Todos
              </button>
              <!-- Modal -->
              <div class="modal fade" id="addMedia" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Novo video</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Voltar"></button>
                    </div>
                    <form action="{{route('video_stream.store')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="mb-4">
                            <label for="video" class="form-label">Video</label>
                            <input type="file" id="video" name="video" class="form-control" placeholder="Video">
                            @error('video')
                            <div class="alert alert-danger mt-2 mb-0">O valor para o vídeo é inválido!</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="delAllMedia" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Apagar TODOS os videos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Voltar"></button>
              </div>
              <form action="{{ route('media-delAllVideos') }}" method="post">
                @csrf
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                  <button type="submit" class="btn btn-danger">Apagar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
            <tr>
              <th>Posição</th>
              <th></th>
              <th>DESCRIÇÃO</th>
              <th>AÇÕES</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($videos as $item)
            <tr>
              <td>
                <div class="align-content-center" style="line-height: 2.5rem;">
                  {{ $item['order'] }}
                </div>
              </td>
              <td>
                <div class="row">
                  <div class="col-12">
                    <div class="inline-block">
                      <a href="{{ Route('media-order-up', $item->slug) }}">
                        <button type="button" id="order-up-btn{{$item->slug}}" class="btn btn-xs btn-icon btn-outline-primary">
                          <span class="tf-icons bx bx-up-arrow"></span>
                        </button>
                      </a>
                      <br>
                      <a href="{{ Route('media-order-down', $item->slug) }}">
                        <button type="button" id="order-down-btn{{$item->slug}}" class="btn btn-xs btn-icon btn-outline-primary">
                          <span class="tf-icons bx bx-down-arrow"></span>
                        </button>
                      </a>
                    </div>

                  </div>
                </div>
              </td>
              <td>{{ $item['description']  }}</td>
              <td>
                <a href="{{ Route('play-video-vlc', $item->slug) }}">
                  <button type="button" id="play-btn{{$item->slug}}" class="btn btn-icon btn-outline-primary">
                    <span class="tf-icons bx bx-play"></span>
                  </button>
                </a>
                <a href="{{ Route('queue-video-vlc', $item->slug) }}">
                  <button type="button" id="queue-btn{{$item->slug}}" class="btn btn-icon btn-outline-primary">
                    <span class="tf-icons bx bx-add-to-queue"></span>
                  </button>
                </a>
                <button type="button" id="edit-btn{{$item->slug}}" class="btn btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->slug }}">
                  <span class="tf-icons bx bx-edit"></span>
                </button>
                <!-- Edit Media -->
                <div class="modal fade" id="edit-modal{{ $item->slug }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Atualizar video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Voltar"></button>
                      </div>
                      <form action="{{route('video_stream.update', $item->slug)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                          <div class="row">
                            <div class="mb-4">
                              <label for="description" class="form-label">Descrição</label>
                              <input value="{{ $item->description }}" type="text" id="description" name="description" class="form-control" placeholder="Descrição">
                              @error('descriptionUpdate')
                                <div class="alert alert-danger mt-2 mb-0">O valor para a descrição é inválido!</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                          <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-modal{{ $item->slug }}">
                  <span class="tf-icons bx bx-trash"></span>
                </button>
                <!-- Delete Media -->
                <div class="modal fade" id="delete-modal{{ $item->slug }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Apagar video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Voltar"></button>
                      </div>
                      <form action="{{route('media-delvideo', ['slug' => $item->slug])}}" method="post">
                        @csrf
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                          <button type="submit" class="btn btn-danger">Apagar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
          @if(count($videos) == 0)
            <br>
            <span class="m-3 disabled">Não há videos...</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="position-absolute" style="right: 1rem; top: 100px; z-index: 1000;">
  @if (Session::has('message'))
    <div class="bs-toast toast fade show bg-{{ Session::get('style') }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" data-bs-autohide="true">
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
