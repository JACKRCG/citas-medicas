@extends('layouts.panel')

@section('content')

<div class="card shadow">

	<div class="card-header border-0">
		<div class="row align-items-center">
		  <div class="col">
		    <h3 class="mb-0">Cancelar cita</h3>
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

	<div class="card-body">

		@if ($role == 'patient')
			<p>Estás a punto de cancelar tu cita reservada 
				con el médico "{{ $appointment->doctor->name }}"
				(especialidad {{ $appointment->specialty->name }}) 
				para el día {{ $appointment->scheduled_date }}:
			</p>
		@elseif ($role == 'doctor')
			<p>Estás a punto de cancelar tu cita  
				con el paciente "{{ $appointment->patient->name }}"
				(especialidad {{ $appointment->specialty->name }}) 
				para el día {{ $appointment->scheduled_date }}
				(hora {{ $appointment->scheduled_time_12 }}):
			</p>
		@else
			<p>Estás a punto de cancelar la cita reservada 
				por el paciente "{{ $appointment->patient->name }}" 
				para ser atendido por el médico "{{ $appointment->doctor->name }}" 
				(especialidad {{ $appointment->specialty->name }}) 
				el día {{ $appointment->scheduled_date }}
				(hora {{ $appointment->scheduled_time_12 }}):
			</p>
		@endif
		
		<form action="{{ url('/appointments/'.$appointment->id.'/cancel') }}" method="POST">
			@csrf

			<div class="form-group">
				<label for="justification">Por favor cuéntanos el motivo de la cancelación:</label>
				<textarea required id="justification" name="justification" rows="4" class="form-control"></textarea>
			</div>			

			<button class="btn btn-danger" type="submit">Cancelar cita</button>
			<a href="{{ url('/appointments') }}" class="btn btn-primary">Volver sin cancelar</a>
		</form>

	</div>

            
</div>
@endsection
