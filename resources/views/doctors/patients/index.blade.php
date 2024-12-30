@extends('layouts.panel')

@section('content')

<div class="card shadow">
			<div class="card-header border-0">
				<div class="row align-items-center">
				  <div class="col">
						<h3 class="mb-0">Mis pacientes</h3>
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
	        <!-- Doctores -->
	        <table class="table align-items-center table-flush">
	          <thead class="thead-light">
	            <tr>
	              <th scope="col">Nombre</th>
	              <th scope="col">E-mail</th>
	              <th scope="col">DNI</th>
	              <th scope="col">Teléfono</th>       
	            </tr>
	          </thead>
	          <tbody>
	          	@foreach ($patients as $patient)
	            <tr>
	              <th scope="row">
	                {{ $patient->name }}
	              </th>
	              <td>
	                {{ $patient->email }}
	              </td>
	              <td>
	                {{ $patient->dni }}
	              </td>	 
	              <td>
	                {{ $patient->phone }}
	              </td>		              
	            </tr>
	            @endforeach
	          </tbody>
	        </table>
	      </div>
	      <!--para generar la paginación con laravel-->
	      <div class="card-body">	 
	      	{{ $patients->links() }}
	      </div>	      
	    </div>
@endsection
