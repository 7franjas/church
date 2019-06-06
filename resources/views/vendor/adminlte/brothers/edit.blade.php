@extends('adminlte::layouts.app')

@section('title','Modificar Hermano(a)')
@section('content_header','Modificar Hermano(a)')
@section('content_description','Modificar la información del hermano(a)')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Modificar Información | Hermano(a)</h3>
        </div>

        <div class="box-body">
          <div class="form-container">

            <form action="{{ route('brothers.update', $brother->id) }}" method="POST">
                 
                {{ method_field('PUT') }}

              {{ csrf_field() }}

              <div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="name" name="name" type="text" class="form-control form-data" placeholder="Nombre" value="{{ $brother->name }}" autofocus="autofocus">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('sexo') ? 'has-error' : '' }}">
                <div class="input-group">
                  <select id="type" name="sexo" class="form-control form-data select-form">
                    <option value="0">Seleccione sexo</option>
                    <option {{ $brother->sexo =='Masculino' ? 'selected' : '' }} value="Masculino">Masculino</option>
                    <option {{ $brother->sexo =='Femenino' ? 'selected' : '' }} value="Femenino">Femenino</option>
                  </select>                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('sexo'))<span class="help-block">{{ $errors->first('sexo') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="email" name="email" type="email" class="form-control form-data" placeholder="Correo" value="{{ $brother->email }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('phone') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="phone" name="phone" type="phone" class="form-control form-data" placeholder="Teléfono" value="{{ $brother->phone }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('phone'))<span class="help-block">{{ $errors->first('phone') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('celphone') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="celphone" name="celphone" type="celphone" class="form-control form-data" placeholder="Celular" value="{{ $brother->celphone }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('celphone'))<span class="help-block">{{ $errors->first('celphone') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('birth') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="datepicker" name="birth" type="birth" class="form-control form-data" placeholder="Fecha Nacimiento" value="{{ $brother->birth }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('birth'))<span class="help-block">{{ $errors->first('birth') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('address') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input id="address" name="address" type="address" class="form-control form-data" placeholder="Dirección" value="{{ $brother->address }}">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                  </div>
                  @if($errors->has('address'))<span class="help-block">{{ $errors->first('address') }}</span>@endif
                </div>

              <div class="field {{ $errors->has('observation') ? 'has-error' : '' }}">
                <div class="input-group">
                  <textarea id="observation" name="observation" type="text" class="form-control form-data" placeholder="Observaciones" value="{{ $brother->observation }}">{{ $brother->observation }}</textarea>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                </div>
                @if($errors->has('observation'))<span class="help-block">{{ $errors->first('observation') }}</span>@endif
              </div>

              <div class="form-button">
                <button type="submit" class="btn btn-primary">Modificar Hermano(a)</button>
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

     $("#fam_name").autocomplete({
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
            $('#fam_name').val(ui.item.value);
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
                  $('#fam_name').val(ui.item.value);
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