@extends('layouts.panel')

@section('content')

<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Nueva Encuesta</h3>
      </div>
      <!-- <div class="col text-right">
        <a href="{{ url('specialties') }}" class="btn btn-sm btn-default">Cancelar y Volver</a>
      </div> -->
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
    <form action="{{ url('polls') }}" method="post">
        @csrf

       

        <div class="form-group">
        <div class="form-check">
  <input class="form-check-input" type="radio" name="answer" id="answer" value="Exelente">
  <label class="form-check-label" for="answer">
    Exelente
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="answer" id="answer" value="Bueno" >
  <label class="form-check-label" for="answer">
    Bueno
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="answer" id="answer" value="Mediocre">
  <label class="form-check-label" for="answer">
    Mediocre
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="answer" id="answer" value="Malo" >
  <label class="form-check-label" for="answer">
    Malo
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="answer" id="answer" value="Pesimo">
  <label class="form-check-label" for="answer">
    Pesimo
  </label>
</div>
        </div>
        <div class="form-group">
            <label for="name">Dejanos tu mensaje</label>
            <textarea type="text" name="message" class="form-control" value="{{ old('message') }}" ></textarea> 
        </div>
        <div class="form-group invisible">
            <label for="name">id</label>
            <input type="text" name="user_id" class="form-control" value="{{ Auth::user()->id }}" >
        </div>
        <button type="submit" class="btn btn-primary">
            Guardar
        </button>
    </form>
  </div>
</div>

@endsection