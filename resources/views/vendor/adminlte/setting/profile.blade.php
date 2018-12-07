@extends('adminlte::layouts.app')

@section('title','Mi Perfil')
@section('content_header','Mi Perfil')
@section('content_description','')

@section('main-content')

	<div class="container-fluid spark-screen">
		<div class="row">
		
	        <div class="col-md-3">

	          <!-- Profile Image -->
	          <div class="box box-primary">
	            <div class="box-body box-profile">
	              <img id="profile-user-img" onError="this.onerror=null;this.src='/img/avatar/default.png';" class="profile-user-img img-responsive img-circle" src="/img/avatar/{{ $user->avatar }}" alt="User profile picture">

		            <h3 class="profile-username text-center">{{ $user->name }}</h3>

		            <p class="text-muted text-center"></p>

					<hr>

					<strong><i class="fa fa-book margin-r-5"></i> Información Académica</strong>
		            <p class="text-muted">
		            No tiene información académica
		            </p>  

	              	<hr>

	                <strong><i class="fa fa-file-text-o margin-r-5"></i> Acerca de mí</strong>
		            <p class="text-muted">
		            No tiene información
		            </p>        

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	        <!-- /.col -->
	        <div class="col-md-9">
	          <div class="nav-tabs-custom">
	            <ul class="nav nav-tabs">
	              <li class="{{ count($errors) ? '' : 'active' }}"><a href="#profile-info" data-toggle="tab">Información</a></li>
	              <li class="{{ count($errors) ? 'active' : '' }}"><a href="#configuracion" data-toggle="tab">Configuración</a></li>
	            </ul>
	            <div class="tab-content">


	              <div class="{{ count($errors) ? '' : 'active' }} tab-pane" id="profile-info">
					
					<div class="row">
						<div class="box-body">
						<div class="col-md-6">
							

					    <strong>Nombre</strong>
			            <p class="text-muted">
						{{ $user->name }}
			            </p>
			            
			            <hr class="hr-profile">

			            <strong>Correo</strong>
			            <p class="text-muted">
			            {{ $user->email }}
			            </p>        
			    
        				<hr class="hr-profile">

			            <strong>Fecha de ingreso</strong>
			            <p class="text-muted">
			            {{ $user->created_date }}
			            </p>   

						<hr class="hr-profile">
			            
			            <strong>Equipo Médico</strong>
			            <p class="text-muted">
			            {{ $team ? $team : 'No tiene equipo médico' }}
			            </p>        

        				<hr class="hr-profile">
			            
						</div>

						<div class="col-md-6">
			            
			            <strong>Apariencia</strong>
			            <p class="text-muted">
										<small class="label label-danger">Desactivado</small>
					        </p>        

			            <hr class="hr-profile">
			            


			            <strong>Barra Lateral (Colapsada)</strong>
			            <p class="text-muted">
										<small class="label label-danger">Desactivado</small>
			            </p>        

			            <hr class="hr-profile">

			            <strong>Barra Lateral (Expander barra)</strong>
			            <p class="text-muted">
										<small class="label label-danger">Desactivado</small>			            
									</p>        

			            <hr class="hr-profile">

			            <strong>Diseño</strong>
			            <p class="text-muted">
										<small class="label label-danger">Desactivado</small>
						      </p>        

			            <hr class="hr-profile">
			            
						</div>
					</div>
					</div>
	              </div>
	              <!-- /.tab-pane -->


	              <div class="{{ count($errors) ? 'active' : '' }} tab-pane" id="configuracion">
					
					<div class="row">
						<div class="box-body">



					  		<div class="col-md-6 text-center">
								<div id="croppie-img"></div>
					  		</div>

					  		<div class="col-md-6" style="padding-top:30px;">
								
								<div class="form-group">
				                  <label for="upload">Cargar Imagen</label>
				                  <input type="file" id="upload" accept="image/x-png,image/jpeg,image/jpg">
								  <span id="file-help-block" class="help-block" style="display: none; color: #a94442;">Extensión no válida, intenta con extensiones png | jpg | jpeg</span>
								  </br>
				                  <!--p class="help-block">Example block-level help text here.</p-->
				                  <button class="btn btn-success upload-result">Actualizar Avatar</button>

				                </div>

					  		</div>

					  		<!--div class="col-md-4">
								<div id="profile-img" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:30px"></div>
					  		</div-->

							



							<div class="col-md-12">
							
								<div class="form-container">
									


							  <form action="{{ route('updateprofile', $user->id) }}" method="POST">
							    
							    {{ method_field('PUT') }}
							    
							    {{ csrf_field() }}


								<div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
							        <div class="input-group" style="width: 100%;">
							          <label>Nombre</label>
							          <input id="name" name="name" type="text" class="form-control form-data" placeholder="Nombre" value="{{ $user->name }}" autofocus="autofocus">
							        </div>
							        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
							      </div>
								

								<div class="field {{ $errors->has('studies') ? 'has-error' : '' }}">
							        <div class="input-group" style="width: 100%;">
							        	<label>Información Académica</label>
										<textarea id="studies" name="studies" class="form-control form-data" rows="3" placeholder="Información Académica"></textarea>

							        </div>
							        @if($errors->has('studies'))<span class="help-block">{{ $errors->first('studies') }}</span>@endif
							      </div>

							      <div class="field {{ $errors->has('description') ? 'has-error' : '' }}">
							        <div class="input-group" style="width: 100%;">
							        	<label>Acerca de mí</label>
										<textarea id="description" name="description" class="form-control form-data" rows="3" placeholder="Descripción"></textarea>

							        </div>
							        @if($errors->has('description'))<span class="help-block">{{ $errors->first('description') }}</span>@endif
							      </div>



								<div class="field {{ $errors->has('password') ? 'has-error' : '' }}">

									<label>Nueva Contraseña</label>

									<div class="input-group" style="width: 100%;">
						                <input id="password" type="password" name="password" class="form-control form-data" placeholder="Ingrese su nueva contraseña" value="">
						           		<span id="password-visible" class="input-group-addon" style="cursor: pointer;"><i class="fa fa-eye-slash"></i></span>
					                </div>

							        @if($errors->has('password'))<span class="help-block">{{ $errors->first('password') }}</span>@endif
							    </div>


								<br>

							    <div class="form-button">
							      <button type="submit" class="btn btn-primary">Actualizar</button>
							    </div>

							</form>

								</div>

							</div>














					</div>




					  	








				  	</div>








					



	              </div>
	              <!-- /.tab-pane -->
	            </div>
	            <!-- /.tab-content -->
	          </div>
	          <!-- /.nav-tabs-custom -->
	        </div>
	        <!-- /.col -->

		</div>
	</div>

@endsection

@section('page_scripts')
<script type="text/javascript">

// toggle password


function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
     	$('#password-visible i').removeClass('fa-eye-slash');
     	$('#password-visible i').addClass('fa-eye');
    } else {
        x.type = "password";
        $('#password-visible i').removeClass('fa-eye');
     	$('#password-visible i').addClass('fa-eye-slash');

    }
}

$('#password-visible').on('click', function(){
	myFunction();
});


// get csrf token
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

// vatiables croppie
$img_preview = $('#croppie-img');
$img_result = $('#profile-img');
$img_select = $('.upload-result');
$img_button = $('#upload');
$img_user_profile = $('#profile-user-img');
$img_sidebar_user_profile = $('#sidebar-profile-user-img');
$img_menu_user_profile = $('#menu-profile-user-img');
$img_dropmenu_user_profile = $('#dropmenu-profile-user-img');



$ajax_avatar = '/ajax/avatar';


// init instance croppie
initCroppie();

$img_button.on('change', function () { 

	var ext = $(this).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
	    //alert('invalid extension!');
	    $('#file-help-block').show();
	    $(this).val('');
	}else{
		$('#file-help-block').fadeOut(850, function() { $(this).hide(); });

	}

	// reset croppie instance
	resetCroppie();
	// read file upload
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    }
    // print image url
    reader.readAsDataURL(this.files[0]);
});

// select image
$img_select.on('click', function (ev) {
	if($img_button.val()!=''){
		// print image result if ajax request is success 
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport',
			format: 'png'
		}).then(function (resp) {
			$.ajax({
				url: $ajax_avatar,
				type: 'POST',
				data: {'image': resp},
				success: function (data) {
					html = '<img src="' + resp + '" />';
					$img_user_profile.attr('src', resp);
					$img_sidebar_user_profile.attr('src', resp);
					$img_menu_user_profile.attr('src', resp);
					$img_dropmenu_user_profile.attr('src', resp);
					$img_result.html(html);
				}
			});
		});
	}
});

// function for croppie instance, fix image size issue
function resetCroppie() { destroyCroppie(); initCroppie(); }

function destroyCroppie() { $uploadCrop.croppie('destroy'); }

function initCroppie() { 
	$uploadCrop = $img_preview.croppie({
	    viewport: {
	        width: 200,
	        height: 200,
	        type: 'square'
	    },
	    boundary: {
	        width: 250,
	        height: 250
	    }
	}); 
}


// Error Validation
$('.form-control.form-data').on('keydown', function(e){
  if($(this).parent().parent().hasClass('has-error')){
    $(this).parent().parent().find('.help-block').fadeOut(850, function() { $(this).remove(); });
    $(this).parent().parent().removeClass('has-error');
  }
});
  $('.calendar-color').colorpicker();



</script>
@endsection
