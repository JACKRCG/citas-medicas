@extends('layouts.panel')

@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="card shadow">
	      <div class="card-header border-0">
	        <div class="row align-items-center">
	          <div class="col">
	            <h3 class="mb-0">Nuevo médico</h3>
	          </div>
	          <div class="col text-right">
	            <a href="{{ url('doctors') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
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
	      	<form action="{{ url('doctors') }}" method="post">
	      		<!--siempre es exigible usar el token para hacer la peticion tipo POST-->
	      		@csrf
	      	<div class="form-group">
	      		<label for="name">Nombre del médico</label>
	      		<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ingrese el nombre del médico" required>
	      	</div>	
	      	<div class="form-row">
	      		<div class="form-group col-md-4">
		      		<label for="email">E-mail</label>
		      		<input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ingrese el e-mail del doctor" class="form-control">
		      	</div>	 
		      	<div class="form-group col-md-4">
		      		<label for="dni">DNI</label>
		      		<input type="text" name="dni" class="form-control" value="{{ old('dni') }}" placeholder="Ingrese el DNI del doctor" class="form-control">
		      	</div>	
		      	<div class="form-group col-md-4">
		      		<label for="specialties">Especialidades</label>
		      		<select name="specialties[]" id="specialties" class="form-control selectpicker" data-style="btn-primary" multiple title="Seleccione una o varias">
		      			@foreach ($specialties as $specialty)
		      				<option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
		      			@endforeach
		      		</select>
		      	</div>	
	      	</div>
	      	<div class="form-row">
		      	<div class="form-group col-md-7">
		      		<label for="address">Dirección</label>
		      		<input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Ingrese la dirección del doctor" class="form-control">
		      	</div>	
		      	<div class="form-group col-md-5">
		      		<label for="phone">Teléfono / móvil</label>
		      		<input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Ingrese el teléfono del doctor" class="form-control">
		      	</div>	
	      	</div>
	      	<div class="form-group">
	      		<label for="password">Contraseña</label>
	      		<input type="text" name="password" class="form-control" value="{{ str_random(6) }}" placeholder="Ingrese el teléfono del doctor" class="form-control">
	      	</div>	
	      	<div class="text-center">
		      	<button type="submit" class="btn btn-primary">
		      		Guardar
		      	</button>		      	
	            <a href="{{ url('doctors') }}" class="btn btn-danger">Cancelar</a>	          	
	      	</div>	
	      </form>
	      </div>
	    </div>
@endsection

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection