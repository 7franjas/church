@extends('adminlte::layouts.app')

@section('title','Perfil de la Subarea')
@section('content_header', $subarea->subarea)
@section('content_description','Muestra la información de la subarea')

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
          <strong>Subarea</strong>
          <p class="text-muted">
          {{ $subarea->subarea }}
          </p>
          <hr class="hr-profile">

          <strong>Descripción</strong>
          <p class="text-muted">
            {!! $subarea->description ? nl2br(e($subarea->description)) : 'No tiene descripción' !!}
          </p>
          <hr class="hr-profile">

          <strong>Área</strong>
          <p class="text-muted">
          {{ $subarea->area->area }}
          </p>
          <hr class="hr-profile">

          <strong>Observaciones</strong>
          <p class="text-muted">
          {!! $subarea->observation ? nl2br(e($subarea->observation)) : 'No tiene observaciones' !!}
          </p> 
          <hr class="hr-profile">

          <br \><br \>
          <div class="form-button button-submit-form col-sm-12">
              <a href="{{ route('subarea.index') }}" class="btn btn-primary">Salir</a>
          </div>
                
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</div>
@endsection
