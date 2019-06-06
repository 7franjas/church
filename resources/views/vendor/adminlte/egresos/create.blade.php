@extends('adminlte::layouts.app')

@section('title','Crear Nuevo Egreso')
@section('content_header','Crear Nuevo Egreso')
@section('content_description','Registra la información del egreso')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Registrar Información | Egreso</h3>
        </div>

        <div class="box-body">
          <div class="form-container">

            <form action="{{ route('egresos.store') }}" method="POST">

              {{ csrf_field() }}

              <div class="field {{ $errors->has('area') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="area_name" name="area" type="text" class="form-control form-data" placeholder="Área" value="{{ old('area') }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('area'))<span class="help-block">{{ $errors->first('area') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('subarea') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="subarea_name" name="subarea" type="text" class="form-control form-data" placeholder="Subarea" value="{{ old('subarea') }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('subarea'))<span class="help-block">{{ $errors->first('subarea') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('brother') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="brother_name" name="brother" type="text" class="form-control form-data" placeholder="Encargado" value="{{ old('brother') }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('brother'))<span class="help-block">{{ $errors->first('brother') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('monto') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input id="monto" name="monto" type="number" min="0" class="form-control form-data" placeholder="Monto" value="{{ old('monto') }}">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                  </div>
                  @if($errors->has('monto'))<span class="help-block">{{ $errors->first('monto') }}</span>@endif
                </div>

              <div class="field {{ $errors->has('date') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="datepicker"  id="date" name="date" type="text" class="form-control form-data" placeholder="Fecha" value="{{ old('date') }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('date'))<span class="help-block">{{ $errors->first('date') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('type') ? 'has-error' : '' }}">
                <div class="input-group">
                  <select id="type" name="type" class="form-control form-data select-form">
                    <option value="0">Seleccione</option>
                    <option {{ old('type')=='Pasivo' ? 'selected' : '' }} value="Pasivo">Pasivo</option>
                    <option {{ old('type')=='Activo' ? 'selected' : '' }} value="Activo">Activo</option>
                  </select>                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('type'))<span class="help-block">{{ $errors->first('type') }}</span>@endif
              </div>
            
              <div class="field {{ $errors->has('observation') ? 'has-error' : '' }}">
                <div class="input-group">
                  <textarea id="observation" name="observation" type="text" class="form-control form-data" placeholder="Observaciones" value="{{ old('observation') }}"></textarea>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                </div>
                @if($errors->has('observation'))<span class="help-block">{{ $errors->first('observation') }}</span>@endif
              </div>

              <input id="area_id" name="area_id" type="hidden" value="{{ old('area_id') }}">
              <input id="subarea_id" name="subarea_id" type="hidden" value="{{ old('subarea_id') }}">
              <input id="brother_id" name="brother_id" type="hidden" value="{{ old('brother_id') }}">

              <div class="form-button">
                <button type="submit" class="btn btn-primary">Crear Egreso</button>
              </div>

            </form>

          </div>
        </div>
        <!-- /.box-body -->
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
            $('#subarea_id').val('');
            $('#subarea_name').val('');
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
                  $('#subarea_id').val('');
                  $('#subarea_name').val('');
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
                $('#brother_id').val('');
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


    $("#subarea_name").autocomplete({
        source: function(request, response) {
          area_id =  $('#area_id').val();
            $.ajax({
                url: "{{ route('ajax.autocomplete.subarea') }}",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN, term : request.term, area_id : area_id
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
          }if(ui.item.value=='error_area'){
          }else{
            $('#subarea_id').val(ui.item.id);
            $('#subarea_name').val(ui.item.value);
          }
          return false;
        },
        change: function( event, ui ) {
            //alert('change');
            if(!ui.item) {
                $('#subarea_id').val('');
            }else{
                if(!ui.item.value=='error'){
                  $('#subarea_id').val(ui.item.id);
                  $('#subarea_name').val(ui.item.value);
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
            }if(item.value==="error_area"){
              ul.empty();
              return $("<li class='each'>")
                 .append("<div class='acItem'><span class='name'>Debe seleccionar área</span></div>")
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