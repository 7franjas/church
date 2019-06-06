@extends('adminlte::layouts.app')

@section('title','Crear Nueva Área')
@section('content_header','Crear Nueva Área')
@section('content_description','Registra la información del Área')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Registrar Información | Área</h3>
        </div>

        <div class="box-body">
          <div class="form-container">

            <form action="{{ route('area.store') }}" method="POST">

              {{ csrf_field() }}

              <div class="field {{ $errors->has('area') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="area" name="area" type="text" class="form-control form-data" placeholder="Área" value="{{ old('area') }}" autofocus="autofocus">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('area'))<span class="help-block">{{ $errors->first('area') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('description') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="description" name="description" type="description" class="form-control form-data" placeholder="Descripción" value="{{ old('description') }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('description'))<span class="help-block">{{ $errors->first('description') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('observation') ? 'has-error' : '' }}">
                <div class="input-group">
                  <textarea id="observation" name="observation" type="text" class="form-control form-data" placeholder="Observaciones" value="{{ old('observation') }}"></textarea>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                </div>
                @if($errors->has('observation'))<span class="help-block">{{ $errors->first('observation') }}</span>@endif
              </div>

              <div class="form-button">
                <button type="submit" class="btn btn-primary">Crear Área</button>
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

     $("#family_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('ajax.autocomplete.family') }}",
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
            $('#family_id').val(ui.item.id);
            $('#family_name').val(ui.item.value);
          }
          return false;
        },
        change: function( event, ui ) {
            //alert('change');
            if(!ui.item) {
                $('#family_id').val('');
            }else{
                if(!ui.item.value=='error'){
                  $('#family_id').val(ui.item.id);
                  $('#family_name').val(ui.item.value);
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