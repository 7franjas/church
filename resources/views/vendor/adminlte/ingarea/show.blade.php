@extends('adminlte::layouts.app')

@section('title','Perfil del Ingreso')
@section('content_header', 'Ingreso Nº'.$ingarea->id)
@section('content_description','Muestra la información del ingreso')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Información | Ingreso por Area</h3>
        </div>

        

        <div class="box-body">
          <strong>Área</strong>
          <p class="text-muted">
          {{ $ingarea->area->area }}
          </p>
          <hr class="hr-profile">

          <strong>Hermano</strong>
          <p class="text-muted">
          {{ $ingarea->brother->name }}
          </p>
          <hr class="hr-profile">

          <strong>Monto</strong>
          <p class="text-muted">
          {!! number_format($ingarea->monto, 0, ',', '.') ? nl2br(e(number_format($ingarea->monto, 0, ',', '.'))) : 'No tiene monto' !!}
          </p>
          <hr class="hr-profile">

          <strong>Fecha</strong>
          <p class="text-muted">
          {{ $date }}
          </p>
          <hr class="hr-profile">

          <strong>Tipo</strong>
          <p class="text-muted">
          {{ $ingarea->type }}
          </p>
          <hr class="hr-profile">

          <strong>Observaciones</strong>
          <p class="text-muted">
          {!! $ingarea->observation ? nl2br(e($ingarea->observation)) : 'No tiene observaciones' !!}
          </p> 
          <hr class="hr-profile">

          <br \><br \>
          <div class="form-button button-submit-form col-sm-12">
              <a href="{{ route('ingarea.index') }}" class="btn btn-primary">Salir</a>
          </div>
                
        </div><!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div><!-- end col 9 -->

  </div>

</div>
@endsection


@section('page_scripts')

<script>

$(document).ready(function() {
    
    $.ajaxSetup({
      headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

     $("#area_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('ajax.autocomplete.area') }}",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN, term : request.term
                },
                success: function(data) {               
                  response( data );  
                },
                error: function(){
                }
            });
        },
        select: function (event, ui) {        
          //alert(ui.item.id);
          if(ui.item.value=='error'){
          }else{
            $('#area_id').val(ui.item.id);
            $('#area_name').val(ui.item.value);
          }
          return false;
        },
        change: function( event, ui ) {
            //alert('change');
            if(!ui.item) {
                $('#area_id').val('');
            }else{
                if(!ui.item.value=='error'){
                  $('#area_id').val(ui.item.id);
                  $('#area_name').val(ui.item.value);
                }
            }
            return false;
        },
        minLength: 1,       
    }).autocomplete('instance')._renderItem = function(ul, item) {
            if(item.value==="error"){
              ul.empty();
              return $("<li class='each'>")
                 .append("<div class='acItem'><span class='name'>Error en la búsqueda</span><span class='desc'>No se encontró ninguna coincidencia.</span></div>")
                  .appendTo(ul)
            }else{
              return $("<li class='each'>")
                  .append("<div class='acItem'><span class='name'>" +
                      item.value + "</span></div>")
                  .appendTo(ul);
            }
    };


    $("#brother_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('ajax.autocomplete.brother') }}",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN, term : request.term
                },
                success: function(data) {               
                  response( data );  
                },
                error: function(){
                }
            });
        },
        select: function (event, ui) {        
          //alert(ui.item.id);
          if(ui.item.value=='error'){
          }else{
            $('#brother_id').val(ui.item.id);
            $('#brother_name').val(ui.item.value);
          }
          return false;
        },
        change: function( event, ui ) {
            //alert('change');
            if(!ui.item) {
                $('#area_id').val('');
            }else{
                if(!ui.item.value=='error'){
                  $('#brother_id').val(ui.item.id);
                  $('#brother_name').val(ui.item.value);
                }
            }
            return false;
        },
        minLength: 1,       
    }).autocomplete('instance')._renderItem = function(ul, item) {
            if(item.value==="error"){
              ul.empty();
              return $("<li class='each'>")
                 .append("<div class='acItem'><span class='name'>Error en la búsqueda</span><span class='desc'>No se encontró ninguna coincidencia.</span></div>")
                  .appendTo(ul)
            }else{
              return $("<li class='each'>")
                  .append("<div class='acItem'><span class='name'>" +
                      item.value + "</span></div>")
                  .appendTo(ul);
            }
    };

  });



  $('#datepicker').datepicker({
    language: "es",
    autoclose: true,
    //format: 'dd/mm/yyyy',
    format: 'yyyy-mm-dd',
    startView: 'years'
  });

  if($('#datepicker').val()==''){
    $('#datepicker').datepicker("setDate", hoy);
  }


</script>


  

@endsection



@section('page_styles')

<style type="text/css">
    
  .ui-corner-all
  {
      -moz-border-radius: 4px 4px 4px 4px;
  }

  .ui-widget
  {
      font-family: Verdana,Arial,sans-serif;
      font-size: 15px;
  }
  .ui-menu
  {
      display: block;
      float: left;
      list-style: none outside none;
      margin: 0;
      padding: 2px;
  }
  .ui-autocomplete
  {
      overflow-x: hidden;
      max-height: 200px;
      width:1px;
      position: absolute;
      top: 100%;
      left: 0;
      z-index: 1000;
      float: left;
      display: none;
      min-width: 160px;
      _width: 160px;
      padding: 4px 0;
      margin: 2px 0 0 0;
      list-style: none;
      background-color: #fff;
      border-color: #ccc;
      border-color: rgba(0, 0, 0, 0.2);
      border-style: solid;
      border-width: 1px;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      -webkit-background-clip: padding-box;
      -moz-background-clip: padding;
      background-clip: padding-box;
      *border-right-width: 2px;
      *border-bottom-width: 2px;
  }
  .ui-menu .ui-menu-item
  {
      clear: left;
      float: left;
      margin: 0;
      padding: 0;
      width: 100%;
  }
  .ui-menu .ui-menu-item a
  {
      display: block;
      padding: 3px 3px 3px 3px;
      text-decoration: none;
      cursor: pointer;
      background-color: #ffffff;
  }
  .ui-menu .ui-menu-item a:hover
  {
      display: block;
      padding: 3px 3px 3px 3px;
      text-decoration: none;
      color: White;
      cursor: pointer;
      background-color: #006699;
  }
  .ui-widget-content a
  {
      color: #222222;
  }
</style>
@endsection