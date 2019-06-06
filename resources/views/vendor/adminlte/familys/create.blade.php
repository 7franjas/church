@extends('adminlte::layouts.app')

@section('title','Crear Nueva Familia')
@section('content_header','Crear Nueva Familia')
@section('content_description','Registra la información de la familia')

@section('main-content')
<div class="container-fluid spark-screen">
  <div class="row">

    <div class="col-md-9">
      <div class="box box-primary">

        <div class="box-header with-border box-header-color">
          <h3 class="box-title">Registrar Información | Familia</h3>
        </div>

        <div class="box-body">
          <div class="form-container">

            <form action="{{ route('familys.store') }}" method="POST">

              {{ csrf_field() }}

              <div class="field {{ $errors->has('fam_name') ? 'has-error' : '' }}">
                <div class="input-group">
                  <input id="fam_name" name="fam_name" type="text" class="form-control form-data" placeholder="Familia" value="{{ old('fam_name') }}" autofocus="autofocus">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                @if($errors->has('fam_name'))<span class="help-block">{{ $errors->first('fam_name') }}</span>@endif
              </div>

              <div class="field {{ $errors->has('fam_observation') ? 'has-error' : '' }}">
                <div class="input-group">
                  <textarea id="fam_observation" name="fam_observation" type="text" class="form-control form-data" placeholder="Observaciones" value="{{ old('fam_observation') }}"></textarea>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                </div>
                @if($errors->has('fam_observation'))<span class="help-block">{{ $errors->first('fam_observation') }}</span>@endif
              </div>

              <div class="form-button">
                <button type="submit" class="btn btn-primary">Crear Familia</button>
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