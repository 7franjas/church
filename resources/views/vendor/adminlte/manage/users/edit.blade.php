@extends('adminlte::layouts.app')

@section('title','Modificar Usuario')
@section('content_header','Modificar Usuario')
@section('content_description','Modifica la información del usuario')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">
        
        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Modificar Información | Usuario</h3>  
        </div><!-- /.box-header -->

        <div class="box-body">

          <div class="form-container">
             <form action="{{ route('users.update', $user->id) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

              <div class="group-password">

                <div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input id="name" name="name" type="text" class="form-control form-data" placeholder="Nombre" value="{{ $user->name }}" autofocus="autofocus">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>  
                  </div>
                  @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                </div>
  
                <div class="field {{ $errors->has('userName') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input id="userName" name="userName" type="text" class="form-control form-data" placeholder="Usuario" value="{{ $user->userName }}" autofocus="autofocus">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>  
                  </div>
                  @if($errors->has('userName'))<span class="help-block">{{ $errors->first('userName') }}</span>@endif
                </div>

                <div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input id="email" name="email" type="email" class="form-control form-data" placeholder="Correo" value="{{ $user->email }}">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>  
                  </div>
                  @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
                </div>                
              
                <div class="field radio-field">
                  <div class="input-group checkbox icheck unselectable">
                    <label>
                        <input v-model="password_options" name="password_options" value="keep" type="radio" class="square-blue" checked>Mantener Contraseña
                    </label>
                  </div>
                </div>
        
                <div class="field radio-field">
                  <div class="input-group checkbox icheck unselectable">                  
                    <label>
                      <input v-model="password_options" name="password_options" value="auto" type="radio" class="square-blue">Generar Contraseña Automatica
                    </label>
                  </div>
                </div>

                <div class="field radio-field">
                  <div class="input-group checkbox icheck unselectable">
                    <label>
                      <input v-model="password_options" name="password_options" value="manual" type="radio" class="square-blue">Introducir Manualmente la contraseña
                    </label>
                  </div>
                </div>
  
                <div class="field" v-if="password_options=='manual'">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" name="password" type="text" class="form-control" placeholder="Contraseña de forma manual" value="">                    
                  </div>
                </div>
                
              </div>
  
              <input type="hidden" :value="rolesSelected" name="roles">
  
              <div class="form-button">
                <button type="submit" class="btn btn-primary">Modificar</button>
              </div>
                  
            </form>

          </div>
        </div><!-- /.box-body -->

      </div><!-- /.box -->
    </div><!-- /.col -->


    <div class="col-md-3">
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

@section('page_scripts')

<script type="text/javascript">

  var app = new Vue({
    el: '#app',
    data: {
        password_options: 'keep',
        rolesSelected: {!! $user->roles->pluck('id') !!}
    },
    mounted: function(){
      
      jQuery('.square-blue, .check').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
      });
  
      jQuery('input[type="radio"].square-blue').on('ifChecked', function(e){
      
        if(jQuery('input[type="radio"].square-blue:checked').val() == 'manual'){
          app.$data.password_options = 'manual';  
          // console.log('manual');
        }else if(jQuery('input[type="radio"].square-blue:checked').val() == 'auto'){
          app.$data.password_options = 'auto'; 
          jQuery('#password').val('');
  
        }else if(jQuery('input[type="radio"].square-blue:checked').val() == 'keep'){
          app.$data.password_options = 'keep'; 
          jQuery('#password').val('');
        }
  
      });
  
  
     jQuery('.check').on('ifChecked',function(e){
         app.$data.rolesSelected.push(parseInt($(this).val()));
  
         //console.log($(this).val());
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
  
        //console.log(app.$data.rolesSelected);
  
        if($(this).parent().parent().parent().parent().parent().hasClass('has-error')){
          console.log('errorrrr')
          $(this).parent().parent().parent().parent().parent().find('.help-block').fadeOut(850, function() { $(this).remove(); });
          $(this).parent().parent().parent().parent().parent().removeClass('has-error');
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