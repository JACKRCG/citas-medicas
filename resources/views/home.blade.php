@extends('layouts.panel')

@section('content')
<div class="row">
  <div class="col-md-12 mb-4">
    <div class="card">
      <div class="card-header">Dashboard</div>
      <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
          @endif

          Bienvenido
      </div>
    </div>
  </div>

  @if (auth()->user()->role == 'admin')
  <div class="col-xl-6 mb-5 mb-xl-0">
    <div class="card shadow">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase ls-1 mb-1">Envío de notificaciones (General)</h6>
            <h2 class="mb-0">Enviar a todos los Usuarios</h2>
          </div>
        </div>
      </div>
      <div class="card-body">
        @if (session('notification'))
          <div class="alert alert-success" role="alert">
            {{ session('notification') }}
          </div>
        @endif

        <form action="{{ url('/fcm/send') }}" method="post">
            @csrf
          <div class="form-group">
            <label for="title">Título</label>
            <input value="{{ config('app.name') }}" type="text" class="form-control" name="title" id="title" required>
          </div>
          <div class="form-group">
            <label for="body">Mensaje</label>
            <textarea name="body" id="body" rows="2" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="imageUrl">Imagen&nbsp;</label><span>(Opcional)</span>
            <input value="https://www.clinicatusalud.pe/img/logo.png" type="text" class="form-control" name="" id="imageUrl" required>
            <div id="previewContainer" style="margin-top: 20px; display: flex; justify-content: center; align-items: center; height: 175px; border: 2px dashed #ccc;">
              <img id="previewImage" src="" alt="Previsualización" style="max-width: 100%; max-height: 100%; display: none;">
            </div>
          </div>
          <button class="btn btn-primary">Enviar Notificación</button>            
        </form>
      </div>
    </div>
  </div>
  <div class="col-xl-6">
    <div class="card shadow">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Total de Citas</h6>
            <h2 class="mb-0">Según el día de la semana</h2>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!-- Chart -->
        <div class="chart">
          <canvas id="chart-orders" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>

@endsection
