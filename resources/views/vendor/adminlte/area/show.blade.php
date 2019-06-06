@extends('adminlte::layouts.app')

@section('title','Perfil del Área')
@section('content_header', $area->area)
@section('content_description','Muestra la información del área')

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
          {{ $area->area }}
          </p>
          <hr class="hr-profile">

          <strong>Descripción</strong>
          <p class="text-muted">
            {!! $area->description ? nl2br(e($area->description)) : 'No tiene descripción' !!}
          </p>
          <hr class="hr-profile">

          <strong>Observaciones</strong>
          <p class="text-muted">
          {!! $area->observation ? nl2br(e($area->observation)) : 'No tiene observaciones' !!}
          </p> 
          <hr class="hr-profile">

          <strong>Subareas</strong>
          <ul>
            @foreach ($subarea as $sub)
              <li>{{ $sub->subarea }}</li>      
            @endforeach
          </ul>
          
          <br \><br \>
          <div class="form-button button-submit-form col-sm-12">
              <a href="{{ route('area.index') }}" class="btn btn-primary">Salir</a>
          </div>
                
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</div>
@endsection
