@extends('adminlte::layouts.app')

@section('title','Crear Nuevo Usuario')
@section('content_header','Crear Nuevo Usuario')
@section('content_description','Registra la información del usuario')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Registrar Información | Usuario</h3>
        </div>

        <div class="box-body">
          <div class="form-container">

            <form action="{{ route('users.store') }}" method="POST">

              {{ csrf_field() }}

              <div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="name" name="name" type="text" class="form-control form-data" placeholder="Nombre" value="{{ old('name') }}" autofocus="autofocus">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('userName') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="userName" name="userName" type="text" class="form-control form-data" placeholder="Usuario" value="{{ old('userName') }}" autofocus="autofocus">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('userName'))<span class="help-block">{{ $errors->first('userName') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="email" name="email" type="email" class="form-control form-data" placeholder="Correo" value="{{ old('email') }}">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                </div>
                @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('password') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="password" name="password" type="text" class="form-control form-data" placeholder="Contraseña ( Manual )" :disabled="auto_password">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                </div>
                @if($errors->has('password'))<span class="help-block">{{ $errors->first('password') }}</span>@endif
              </div>

              <div class="field checkbox-field">
                <div class="input-group checkbox icheck unselectable">
                  <label>
                      <input id="auto_password" name="auto_generate" type="checkbox" class="square-blue" :checked="true" v-model="auto_password">Generar Contraseña Automatica
                  </label>
                </div>
              </div>
              
              <input type="hidden" :value="rolesSelected" name="roles">

              <div class="form-button">
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
              </div>

            </form>

          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div><!-- end col 9 -->

    <div class="col-md-3">
     <!-- Profile Image -->
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Roles</h3>

        </div>       
        <div class="box-body">

              <div class="group-roles {{ $errors->has('roles') ? 'has-error' : '' }}">
                  @foreach($roles as $role)

                   <div class="field checkbox-field-role">
                    <div class="input-group checkbox icheck unselectable">
                      <label>
                      <input id="check-all" type="checkbox" class="check square-blue" v-model="rolesSelected" value="{{$role->id}}">{{ $role->display_name }}
                      </label>
                    </div>
                  </div>  

                  @endforeach
                  @if($errors->has('roles'))<span class="help-block">{{ $errors->first('roles') }}</span>@endif
              </div>

        </div>
      </div>
    </div><!-- end col 3 -->

  </div>

</div>
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

@section('page_scripts')


<script type="text/javascript">

  var app = new Vue({
    el: '#app',
    data: {
          auto_password: true,
          rolesSelected: [{!! old('roles') !!}]
    },
    mounted: function(){
      
      jQuery('input[type="checkbox"].square-blue').iCheck({
        checkboxClass: 'icheckbox_square-blue'
      });
    
      jQuery('#auto_password').on('ifChecked', function(e){
        app.$data.auto_password = true;
        jQuery('#password').val('');
      });
  
      jQuery('#auto_password').on('ifUnchecked', function(e){
        app.$data.auto_password = false;
      });
  
      jQuery('.check').on('ifChecked',function(e){
         app.$data.rolesSelected.push(parseInt($(this).val()));      
        if($(this).parent().parent().parent().parent().parent().hasClass('has-error')){
          console.log('errorrrr')
          $(this).parent().parent().parent().parent().parent().find('.help-block').fadeOut(850, function() { $(this).remove(); });
          $(this).parent().parent().parent().parent().parent().removeClass('has-error');
        }  
      });
     
      jQuery('.check').on('ifUnchecked',function(e){
        let index = app.$data.rolesSelected.indexOf(parseInt($(this).val()));
        if (index > -1) {
           app.$data.rolesSelected.splice(index, 1);
        }
      });
  
    }
  });
  
    // Error Validation
    $('.form-control.form-data').on('keydown', function(e){
      if($(this).parent().parent().hasClass('has-error')){
        $(this).parent().parent().find('.help-block').fadeOut(850, function() { $(this).remove(); });
        $(this).parent().parent().removeClass('has-error');
      }
    });
  
  
  
  
  
  
  </script>
  

@endsection