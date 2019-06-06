@extends('adminlte::layouts.app')

@section('title','Perfil del Egreso')
@section('content_header', 'Egreso Nº'.$egreso->id)
@section('content_description','Muestra la información del egreso')

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
          <strong>Área</strong>
          <p class="text-muted">
          {{ $egreso->area->area }}
          </p>
          <hr class="hr-profile">

          <strong>Subarea</strong>
          <p class="text-muted">
          {{ $egreso->subarea->subarea }}
          </p>
          <hr class="hr-profile">

          <strong>Encargado</strong>
          <p class="text-muted">
          {{ $egreso->brother->name }}
          </p>
          <hr class="hr-profile">

          <strong>Monto</strong>
          <p class="text-muted">
          {!! number_format($egreso->monto, 0, ',', '.') ? nl2br(e(number_format($egreso->monto, 0, ',', '.'))) : 'No tiene monto' !!}
          </p>
          <hr class="hr-profile">

          <strong>Fecha</strong>
          <p class="text-muted">
          {{ $date }}
          </p>
          <hr class="hr-profile">

          <strong>Tipo</strong>
          <p class="text-muted">
          {{ $egreso->type }}
          </p>
          <hr class="hr-profile">

          <strong>Observaciones</strong>
          <p class="text-muted">
          {!! $egreso->observation ? nl2br(e($egreso->observation)) : 'No tiene observaciones' !!}
          </p> 
          <hr class="hr-profile">

          <br \><br \>
          <div class="form-button button-submit-form col-sm-12">
              <a href="{{ route('egresos.index') }}" class="btn btn-primary">Salir</a>
          </div>
                
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</div>
@endsection
