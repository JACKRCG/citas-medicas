@extends('layouts.panel')

@section('content')

<div class="card shadow">
	      <div class="card-header border-0">
	        <div class="row align-items-center">
	          <div class="col">
	            <h3 class="mb-0">Nueva Especialidad</h3>
	          </div>
	          <div class="col text-right">
	            <a href="{{ url('specialties') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
	          </div>
	        </div>
	      </div>
	      <div class="card-body">
	      	@if($errors->any())
	      		 <div class="alert alert-danger" role="alert">
	      		 	<ul>
	      			@foreach ($errors->all() as $error)
	      			<li>{{ $error }}</li>
	      			@endforeach
	      			</ul>
	      		</div>
	      	@endif

	      	<!--Para ejecutar el envio de datos con el comando "route('...')" este se va a resolver por el método "url" del controlador pero con la petición "post"-->
	      	<form action="{{ url('specialties') }}" method="post">
	      		<!--siempre es exigible usar el token para hacer la peticion tipo POST-->
	      		@csrf
	      	<div class="form-group">
	      		<label for="name">Nombre de la Especialidad</label>
	      		<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ingrese el nombre de la Especialidad" required>
	      	</div>	
	      	<div class="form-group">
	      		<label for="description">Descripción</label>
	      		<input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Ingrese una descripción para la especialidad (Opcional)" class="form-control">
	      	</div>	      
	      	<div class="text-center">
		      	<button type="submit" class="btn btn-primary">
		      		Guardar
		      	</button>		      	
	            <a href="{{ url('specialties') }}" class="btn btn-danger">Cancelar</a>	          	
	      	</div>
	      </form>
	      </div>
	    </div>

@endsection
