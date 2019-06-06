@extends('adminlte::layouts.app')

@section('title','Perfil de Hermano(a)')
@section('content_header', $brother->name)
@section('content_description','Muestra la información del(la) hermano(a)')

@section('main-content')
<div class="container-fluid spark-screen">

  <div class="row">
    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Información</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
          </div>
        </div><!-- /.box-body -->

        <div class="box-body">
          <strong>Nombre</strong>
          <p class="text-muted">
          {{ $brother->name }}
          </p>
          <hr class="hr-profile">

          <strong>Sexo</strong>
          <p class="text-muted">
            {!! $brother->sexo ? nl2br(e($brother->sexo)) : 'No se establecio sexo' !!}
          </p>
          <hr class="hr-profile">

          <strong>Email</strong>
          <p class="text-muted">
            {!! $brother->email ? nl2br(e($brother->email)) : 'No tiene email' !!}
          </p>
          <hr class="hr-profile">

          <strong>Teléfono</strong>
          <p class="text-muted">
            {!! $brother->phone ? nl2br(e($brother->phone)) : 'No tiene teléfono' !!}
          </p>
          <hr class="hr-profile">

          <strong>Celular</strong>
          <p class="text-muted">
            {!! $brother->celphone ? nl2br(e($brother->celphone)) : 'No tiene celular' !!}
          </p>
          <hr class="hr-profile">

          <strong>Fecha Nacimiento</strong>
          <p class="text-muted">
            {!! $brother->birth ? nl2br(e($brother->birth)) : 'No tiene fecha de nacimiento' !!}
          </p>
          <hr class="hr-profile">

          <strong>Dirección</strong>
          <p class="text-muted">
            {!! $brother->address ? nl2br(e($brother->address)) : 'No tiene dirección' !!}
          </p>
          <hr class="hr-profile">

          <strong>Observaciones</strong>
          <p class="text-muted">
          {!! $brother->observation ? nl2br(e($brother->observation)) : 'No tiene observaciones' !!}
          </p> 

          <br \><br \>
          <div class="form-button button-submit-form col-sm-12">
              <a href="{{ route('brothers.index') }}" class="btn btn-primary">Salir</a>
          </div>
                
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</div>
@endsection
