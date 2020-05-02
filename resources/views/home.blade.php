@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                
                <hr>
                
                <div class="">
                    Acciones de admin:
                </div>

                <div class="">
                    <a href="/especialidades">Listado Especialidades</a>
                </div>

                <div class="">
                    <a href="/obrasSociales">Listado Obras Sociales</a>
                </div>
                
                <div class="">
                    <a href="/usuarios">Administrar Usuarios</a>
                </div>
                

                <div class="">
                    <a href="/fechas">Administrar Fechas</a>
                </div>




                <hr>
                <div class="">
                    Acciones de usuario normal:
                </div>

                <div class="">
                    <a href="/cuenta">Cuenta de Usuario</a>
                </div>

                <div class="">
                    <a href="/turnosUsuario/{{auth()->user()->id}}">Ver turnos</a>
                </div>

                @foreach( $especialidades as $especialidad)
   
                    <a href="pedirTurno/{{$especialidad->id}}">
                        {{ $especialidad->name }}
                    </a>

                @endforeach

                <hr>
                <div class="">
                    Acciones de profesional
                </div>

                <div class="">
                    <a href="/turnosProfesional/{{auth()->user()->id}}">Mis turnos</a>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
