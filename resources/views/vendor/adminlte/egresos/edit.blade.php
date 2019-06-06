@extends('adminlte::layouts.app')

@section('title','Modificar Egreso')
@section('content_header','Modificar Egreso Nº'.$egreso->id)
@section('content_description','Modificar la información del egreso')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Modificar Información | Egreso</h3>
        </div>

        <div class="box-body">
          <div class="form-container">

            <form action="{{ route('egresos.update', $egreso->id) }}" method="POST">
                 
                {{ method_field('PUT') }}

              {{ csrf_field() }}
          
              <div class="field {{ $errors->has('area') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="area_name" name="area" type="text" class="form-control form-data" placeholder="Área" value="{{ $egreso->area->area }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('area'))<span class="help-block">{{ $errors->first('area') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('subarea') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="subarea_name" name="subarea" type="text" class="form-control form-data" placeholder="Subarea" value="{{ $egreso->subarea->subarea }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('subarea'))<span class="help-block">{{ $errors->first('subarea') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('brother') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="brother_name" name="brother" type="text" class="form-control form-data" placeholder="Encargado" value="{{ $egreso->brother->name}}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('brother'))<span class="help-block">{{ $errors->first('brother') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('monto') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input id="monto" name="monto" type="number" min="0" class="form-control form-data" placeholder="Monto" value="{{ $egreso->monto }}">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                  </div>
                  @if($errors->has('monto'))<span class="help-block">{{ $errors->first('monto') }}</span>@endif
                </div>

              <div class="field {{ $errors->has('date') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="datepicker"  id="date" name="date" type="text" class="form-control form-data" placeholder="Fecha" value="{{ $egreso->date}}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('date'))<span class="help-block">{{ $errors->first('date') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('type') ? 'has-error' : '' }}">
                <div class="input-group">
                  <select id="type" name="type" class="form-control form-data select-form">
                    <option value="0">Seleccione</option>
                    <option {{ $egreso->type =='Pasivo' ? 'selected' : '' }} value="Pasivo">Pasivo</option>
                    <option {{ $egreso->type =='Activo' ? 'selected' : '' }} value="Activo">Activo</option>
                  </select>                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('type'))<span class="help-block">{{ $errors->first('type') }}</span>@endif
              </div>
            
              <div class="field {{ $errors->has('observation') ? 'has-error' : '' }}">
                <div class="input-group">
                  <textarea id="observation" name="observation" type="text" class="form-control form-data" placeholder="Observaciones" value="{{ $egreso->observation }}">{{ $egreso->observation }}</textarea>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                </div>
                @if($errors->has('observation'))<span class="help-block">{{ $errors->first('observation') }}</span>@endif
              </div>

              <input id="area_id" name="area_id" type="hidden" value="{{ $egreso->area_id }}">
              <input id="subarea_id" name="subarea_id" type="hidden" value="{{ $egreso->subarea_id }}">
              <input id="brother_id" name="brother_id" type="hidden" value="{{ $egreso->brother_id }}">


              <div class="form-button">
                <button type="submit" class="btn btn-primary">Modificar Egreso</button>
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


@section('page_styles')

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