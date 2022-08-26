@extends('layouts.panel')

@section('content')

<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Registrar nueva Tutoria individual</h3>
      </div>
      <div class="col text-right">
        <a href="{{ url('patients') }}" class="btn btn-sm btn-default">Cancelar y Volver</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  
    <!-- formulario -->
    <form action="{{ url('appointments') }}" method="post">
        @csrf

        <!-- <div class="form-group">
            <label for="description">Descripción</label>
        <input name="description" value="{{ old('description')}}" id="description" type="text" class="form-control" placeholder="Describe brevemente la consulta" required>
        </div> -->

        
        <div class="form-row">
        <div class="form-group col-md-3">
                <label for="name">Universidad</label>
                <select name="university_id" id="university" class="form-control" required>
                    <option value="">Seleccionar Universidad</option>
                    @foreach ($universitys as $university)
                        <option value="{{ $university->id }} @if(old('university_id') == $university->id) selected @endif">
                            {{ $university->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="name">Carrera</label>
                <select name="careers_id" id="careers" class="form-control" required>
                    <option value="">Seleccionar Carrera</option>
                    @foreach ($careers as $careers)
                        <option value="{{ $careers->id }} @if(old('careers_id') == $careers->id) selected @endif">
                            {{ $careers->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="email">Materia</label>
                <select name="specialty_id" id="specialty" class="form-control" required>
                <option value="">Seleccionar Materia</option>   
                @foreach ($specialties as $specialty)
                        <option value="{{ $specialty->id }} @if(old('specialty_id') == $specialty->id) selected @endif">
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="email">Tutor</label>
                <select name="doctor_id" id="doctor" class="form-control" required>
                <option value="">Seleccionar Tutor</option>   
                @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }} @if(old('doctor_id') == $doctor->id) selected @endif">
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div> 
        </div>
        <div class="form-group">
            <label for="dni">Fecha</label>
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="ni ni-calendar-grid-58"></i>
                    </span>
                </div>
                <input class="form-control datepicker" placeholder="seleccionar fecha"
                    id="date" name="scheduled_date" type="text" 
                    value="{{ old('scheduled_date', date('Y-m-d')) }}" 
                    data-date-format="yyyy-mm-dd" 
                    data-date-start-date="{{ date('Y-m-d') }}" data-date-end-date="+30d">
            </div>
        </div>
        <div class="form-group">
            <label for="address">Hora de atención</label>
            <div id="hours">
                @if ($intervals)
                    @foreach ($intervals['morning'] as $key => $interval)
                        <div class="custom-control custom-radio mb-3">
                            <input name="scheduled_time" value="{{ $interval['start'] }}" 
                            class="custom-control-input" id="intervalMorning{{$key}}" type="radio" required>
                            <label class="custom-control-label" for="intervalMorning{{$key}}">{{ $interval['start']}} - {{ $interval['end']}}</label>
                        </div>
                    @endforeach
                    @foreach ($intervals['afternoon'] as $key => $interval)
                        <div class="custom-control custom-radio mb-3">
                            <input name="scheduled_time" value="{{ $interval['start'] }}" 
                            class="custom-control-input" id="intervalAfternoon{{$key}}" type="radio" required>
                            <label class="custom-control-label" for="intervalAfternoon{{$key}}">{{ $interval['start']}} - {{ $interval['end']}}</label>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info" role="alert">
                        Selecciona un tutor y una fecha, para ver sus horas disponibles.
                    </div>
                @endif
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="phone">Tipo de Tutoria</label>
            <div class="custom-control custom-radio mb-3">
                <input name="type" class="custom-control-input" id="type1" checked type="radio"
                    @if(old('type', 'Consulta') == 'Consulta') checked @endif value="Consulta">
                <label class="custom-control-label" for="type1">Individual</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input name="type" class="custom-control-input" id="type2"  type="radio"
                    @if(old('type') == 'Examen') checked @endif value="Examen">
                <label class="custom-control-label" for="type2">Grupal</label>
            </div>
            <!-- <div class="custom-control custom-radio mb-3">
                <input name="type" class="custom-control-input" id="type3"  type="radio"
                    @if(old('type') == 'Operación') checked @endif value="Operación">
                <label class="custom-control-label" for="type3">Operación</label>
            </div> 
        </div> -->
        
        <button type="submit" class="btn btn-primary btn-lg btn-block">
            Agendar
        </button>
       
    </form>
  </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/appointments/create.js') }}"></script>
@endsection