@extends('adminlte::layouts.app')

@section('title','Administrar Diezmos')
@section('content_header','Administrar Diezmos')
@section('content_description','Almacena los diezmos registrados')

@section('main-content')
<div class="container-fluid spark-screen">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
          <!-- Datatable -->            
          <div id="datatable-view" style="opacity: 0;">
            {!! $dataTable->table(['class' => 'table nowrap table-striped table-bordered table-responsive']) !!}
          </div>        
          <!-- End Datatable -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>


  <div id="modal-destroy" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <input type="hidden" name="id" id="id-destroy" value="" />

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Eliminar Diezmo</h4>
        </div>
        <div class="modal-body">
          <p>¿Está seguro de eliminar Diezmo <b><span id="name-destroy"></span></b>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button id="submitDestroy" type="button" class="btn btn-danger">Eliminar</button>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
@endsection


@section('page_scripts')

<script>

  function modalDestroy(event, id, name) {
    // set parameters
    $("#modal-destroy #id-destroy").val(id);
    $("#modal-destroy #name-destroy").html(id);
    // show modal
    $('#modal-destroy').modal('show');
  }

  $('#submitDestroy').click(function(){
    
    ajax_destroy = 'diezmos/destroy';
    id_ingreso = $("#modal-destroy #id-destroy").val();
    //console.log(ajax_destroy);

    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "2500",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

    $.ajax({
      url: ajax_destroy,
      type: 'POST',
      data: {'_token': '{{ csrf_token() }}', '_method': 'DELETE', 'id': id_ingreso},
      success: function (data) {
          //console.log(data)
          if(data.success == 'ok'){
            //console.log('true')
            $('#modal-destroy').modal('hide');
            // reload datatable current paginate
            $('#dataTableBuilder').DataTable().draw(false);
            // refresh datatable        
            //$('#dataTableBuilder').DataTable().ajax.reload();  
            toastr.success('Se ha eliminado el usuario '+data.ingreso);
          }
      }
    });

  });

</script>

<script src="{{ asset('/plugins/datatables/extensions/button-serve-side/buttons.server-side.js') }}" type="text/javascript"></script>

{!! $dataTable->scripts() !!}
            
@endsection
