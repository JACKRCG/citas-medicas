@extends('layouts.panel')

@section('content')

<div class="card shadow">
			<div class="card-header border-0">
				<div class="row align-items-center">
				  <div class="col">
				    <h3 class="mb-0">Especialidades</h3>
				  </div>
				  <div class="col text-right">
				    <a href="{{ url('specialties/create') }}" class="btn btn-sm btn-success">Nueva Especialidad</a>
				  </div>
				</div>
			</div>
			@if(session('notification'))
			<div class="card-body">
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					<span class="alert-icon"><i class="ni ni-like-2"></i></span>
	    			<span>{{ session('notification') }}</span>
	    			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				        <span aria-hidden="true">&times;</span>
				    </button>
				</div>
			</div>	
			@endif   	
	      <div class="table-responsive">
	        <!-- Especialidades -->
	        <table class="table align-items-center table-flush">
	          <thead class="thead-light">
	            <tr>
	              <th scope="col">Nombre</th>
	              <th scope="col">Descripcion</th>
	              <th scope="col">Opciones</th>
	            </tr>
	          </thead>
	          <tbody>
	          	@foreach ($specialties as $specialty)
	            <tr>
	              <th scope="row">
	                {{ $specialty->name }}
	              </th>
	              <td>
	                {{ $specialty->description }}
	              </td>
	              <td>
	                
	                <form action="{{ url('/specialties/'.$specialty->id) }}" method="POST">
	                	@csrf
	                	@method('DELETE')
	                	<a href="{{ url('/specialties/'.$specialty->id.'/edit') }}" class="btn btn-sm btn-primary">Editar</a>
						<button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
	                </form>
	              </td>
	            </tr>
	            @endforeach
	          </tbody>
	        </table>
	      </div>
	    </div>

@endsection
