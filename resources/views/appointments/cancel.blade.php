@extends('layouts.panel')

@section('content')

<div class="card shadow">

  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Cancelar tutoria</h3>
      </div>
    </div>
  </div>

  <div class="card-body">
    @if(session('notification'))
      <div class="alert alert-success" role="alert">
        {{ session('notification') }}
      </div>
    @endif

    @if($role == 'patient')
      <p>
        Estas apunto de cancelar tu tutoria reservada con el Tutor: {{  $appointment->doctor->name }}
          (Materia {{ $appointment->specialty->name}})
          para el día {{ $appointment->scheduled_date }}
      </p>
    @elseif($role == 'doctor')
      <p>
        Estas apunto de cancelar tu Tutoria con el Estudiante: {{  $appointment->patient->name }}
          (Materia {{ $appointment->specialty->name}})
          para el día {{ $appointment->scheduled_date }}
          (hora {{ $appointment->scheduled_time_12 }})
      </p>
    @else
      <p>
        Estas apunto de cancelar la tutoria reservada por el Estudiante: {{  $appointment->patient->name }}
         para ser atendida por el tutor {{  $appointment->doctor->name }}
          (Materia {{ $appointment->specialty->name}})
          para el día {{ $appointment->scheduled_date }}
          (hora {{ $appointment->scheduled_time_12 }})
      </p>
    @endif

    <form action="{{ url('/appointments/'.$appointment->id.'/cancel') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="justification">Por favor cuéntanos el motivo de la cancelación:</label>
            <textarea required id="justification" name="justification" rows="3" class="form-control">
            </textarea>
        </div>

        <button class="btn btn-danger" type="submit">Cancelar tutoria</button>
        <a href="{{ url('/appointments') }}" class="btn btn-default">
            Volver al listado de Tutorias sin cancelar
        </a>
    </form>

  </div>

</div>

@endsection