@extends('layouts.panel')

@section('content')

<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Editar Carrera</h3>
      </div>
      <div class="col text-right">
        <a href="{{ url('careers') }}" class="btn btn-sm btn-default">Cancelar y Volver</a>
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
    <form action="{{ url('careers/'.$careers->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre de la Carrera</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $careers->name) }}" required>
        </div>
        <div class="form-group">
            <label for="name">Descripción</label>
            <input type="text" name="description" class="form-control"  value="{{ old('description', $careers->description) }}">
        </div>
        <button type="submit" class="btn btn-primary">
            Guardar
        </button>
    </form>
  </div>
</div>

@endsection