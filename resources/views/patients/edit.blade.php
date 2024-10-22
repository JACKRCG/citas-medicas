@extends('layouts.panel')

@section('content')

<div class="card shadow">
	      <div class="card-header border-0">
	        <div class="row align-items-center">
	          <div class="col">
	            <h3 class="mb-0">Editar paciente</h3>
	          </div>
	          <div class="col text-right">
	            <a href="{{ url('patients') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
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
	      	<form action="{{ url('patients/'.$patient->id) }}" method="post">
	      		<!--siempre es exigible usar el token para hacer la peticion tipo POST-->
	      		@csrf
	      		@method('PUT')
	      	<div class="form-group">
	      		<label for="name">Nombre del paciente</label>
	      		<input type="text" name="name" class="form-control" value="{{ old('name', $patient->name) }}" placeholder="Ingrese el nombre del paciente" required>
	      	</div>	
	      	<div class="form-row">
	      		<div class="form-group col-md-7">
		      		<label for="email">E-mail</label>
		      		<input type="text" name="email" class="form-control" value="{{ old('email', $patient->email) }}" placeholder="Ingrese el e-mail del paciente" class="form-control">
		      	</div>	 
		      	<div class="form-group col-md-5">
		      		<label for="dni">DNI</label>
		      		<input type="text" name="dni" class="form-control" value="{{ old('dni', $patient->dni) }}" placeholder="Ingrese el DNI del paciente" class="form-control">
		      	</div>	
	      	</div>
	      	<div class="form-row">
		      	<div class="form-group col-md-7">
		      		<label for="address">Dirección</label>
		      		<input type="text" name="address" class="form-control" value="{{ old('address', $patient->address) }}" placeholder="Ingrese la dirección del paciente" class="form-control">
		      	</div>	
		      	<div class="form-group col-md-5">
		      		<label for="phone">Teléfono / móvil</label>
		      		<input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone) }}" placeholder="Ingrese el teléfono del paciente" class="form-control">
		      	</div>	
	      	</div>
	      	<div class="form-group">
	      		<label for="password">Contraseña</label>
	      		<input type="text" name="password" class="form-control" value="" class="form-control">
	      		<p>Ingrese un valor sólo si desea modificar la contraseña.</p>
	      	</div>	
	      	<div class="text-center">
		      	<button type="submit" class="btn btn-primary">
		      		Guardar
		      	</button>		      	
	            <a href="{{ url('patients') }}" class="btn btn-danger">Cancelar</a>	          	
	      	</div>	
	      </form>
	      </div>
	    </div>

@endsection
