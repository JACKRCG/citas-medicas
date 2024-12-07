@extends('layouts.panel')

@section('content')
<form action="{{ url('/schedule') }}" method="POST">
  @csrf
  <div class="card shadow">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Gestionar Horario</h3>
          </div>
          <div class="col text-right">
            <button type="submit" class="btn btn-sm btn-success">
              Guardar cambios
            </button>
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
      @if(session('errors'))
      <div class="card-body">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-icon"><i class="ni ni-like-2"></i></span>
            <span>
              Los cambios se han guardado, pero tener en cuenta:
                <ul>
                  @foreach (session('errors') as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
            </span>
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
                <th scope="col">Día</th>
                <th scope="col">Activo</th>
                <th scope="col">Turno mañana</th>
                <th scope="col">Turno tarde</th>
              </tr>
            </thead>
            <tbody>
              <!--workDays contiene la informacion de la base de datos-->
              @foreach ($workDays as $key => $workDay)
              <tr>
                <!--en función de la posición de $key muestra los días-->
                <th>{{ $days[$key] }}</th>
                <td>
                  <label class="custom-toggle">
                    <input type="checkbox" name="active[]" value="{{ $key }}"
                    @if($workDay->active) checked @endif>
                    <span class="custom-toggle-slider rounded-circle"></span>
                  </label>
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-control" name="morning_start[]">
                        @for ($i=5; $i<=11; $i++)
                        <!--el for ira pasando los valores con $i y el if evalua si la hora que se ha pasado es igual
                         a la hora que trae la base de datos con 'morning_start' si es así la selecciona-->
                        <!--se pregunta si i<0 para poder concatenar un cero y poder comparar en el controller
                          los valores-->
                        <option value="{{ ($i<10 ? '0' : '') . $i }}:00" 
                          @if($i.':00 AM' == $workDay->morning_start) selected @endif>
                          {{ $i }}:00 AM
                        </option>
                        <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                          @if($i.':30 AM' == $workDay->morning_start) selected @endif>
                          {{ $i }}:30 AM
                        </option>
                        @endfor
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="morning_end[]">
                        @for ($i=5; $i<=11; $i++)
                        <option value="{{ ($i<10 ? '0' : '') . $i }}:00"
                        @if($i.':00 AM' == $workDay->morning_end) selected @endif>
                          {{ $i }}:00 AM</option>
                        <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                        @if($i.':30 AM' == $workDay->morning_end) selected @endif>
                          {{ $i }}:30 AM</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-control" name="afternoon_start[]">
                        @for ($i=1; $i<=11; $i++)
                        <option value="{{ $i+12 }}:00"
                          @if($i.':00 PM' == $workDay->afternoon_start) selected @endif>
                          {{ $i }}:00 PM</option>
                        <option value="{{ $i+12 }}:30"
                          @if($i.':30 PM' == $workDay->afternoon_start) selected @endif>
                          {{ $i }}:30 PM</option>
                        @endfor
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="afternoon_end[]">
                        @for ($i=1; $i<=11; $i++)
                        <option value="{{ $i+12 }}:00"
                          @if($i.':00 PM' == $workDay->afternoon_end) selected @endif>
                          {{ $i }}:00 PM</option>
                        <option value="{{ $i+12 }}:30"
                          @if($i.':30 PM' == $workDay->afternoon_end) selected @endif>
                          {{ $i }}:30 PM</option>
                        @endfor
                      </select>
                    </div>
                  </div>                  
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
</form>
@endsection