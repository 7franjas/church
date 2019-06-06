@extends('adminlte::layouts.app')

@section('title','Perfil de Familia')
@section('content_header','Familia '.$family->fam_name)
@section('content_description','Muestra la información de la familia')

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
          <strong>Familia</strong>
          <p class="text-muted">
          {{ $family->fam_name }}
          </p>
          <hr class="hr-profile">

          <strong>Observaciones</strong>
          <p class="text-muted">
          {!! $family->fam_observation ? nl2br(e($family->fam_observation)) : 'No tiene observaciones' !!}
          </p> 

          <br \><br \>
          <div class="form-button button-submit-form col-sm-12">
              <a href="{{ route('familys.index') }}" class="btn btn-primary">Salir</a>
          </div>
                
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</div>
@endsection
