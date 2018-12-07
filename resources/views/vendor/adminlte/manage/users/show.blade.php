@extends('adminlte::layouts.app')

@section('title','Perfil de Usuario')
@section('content_header','Perfil de '.$user->name)
@section('content_description','Muestra la información del usuario')

@section('main-content')
<div class="container-fluid spark-screen">

  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary">

        <div class="box-body box-profile">
          <img id="profile-user-img" onError="this.onerror=null;this.src='/img/avatar/default.png';" class="profile-user-img img-responsive img-circle" src="/img/avatar/{{$user->avatar}}" alt="User profile picture">
          <h3 class="profile-username text-center">{{ $user->name }}</h3>
          <p class="text-muted text-center">{{ $user->email }}</p>
          <div class="group-roles">
            <ul class="list-group">
              <li class="list-group-item active"><b>Roles</b></li>
              @if($user->roles->count() == 0)
                <li class="list-group-item">No tiene roles asignados</li>
              @endif
              @foreach($user->roles as $role)
                <li class="list-group-item">{{ $role->display_name }}</li>
              @endforeach              
            </ul>            
          </div>         
          @role('superadministrador')
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block"><b>Editar</b></a>
          @endrole
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Información</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
          </div>
        </div><!-- /.box-body -->

        <div class="box-body">
              <div class="col-md-6">

                <strong>Nombre</strong>
                <p class="text-muted">
                {{ $user->name }}
                </p>
                <hr class="hr-profile">

                <strong>ID</strong>
                <p class="text-muted">
                {{ $user->name }}
                </p> 
                <hr class="hr-profile">

                <strong>Especialidad</strong>
                <p class="text-muted">
                {{ $user->name }}
                </p>  
                <hr class="hr-profile">

                <strong>Número de Registro Médico (ICM)</strong>
                <p class="text-muted">
                {{ $user->name }}
                </p>   
                <hr class="hr-profile">

                <strong>Correo</strong>
                <p class="text-muted">
                {{ $user->email }}
                </p> 
                <hr class="hr-profile">

                <strong>Lugar de Atención</strong>
                <p class="text-muted">
                {{  $user->name   }}
                </p>  
                <hr class="hr-profile">

                <strong>Fecha de Ingreso</strong>
                <p class="text-muted">
                {{ $user->created_date }}
                </p>    
                <hr class="hr-profile">
                
              </div>

              <div class="col-md-6">
              
                <strong><i class="fa fa-book margin-r-5"></i> Información Académica</strong>
                <p class="text-muted">
                  No tiene información
                </p>  
                <hr class="hr-profile">

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Acerca de mí</strong>
                <p class="text-muted">
                  No tiene información
                </p> 

              </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</div>
@endsection
