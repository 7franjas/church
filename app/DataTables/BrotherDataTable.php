<?php

namespace App\DataTables;

use App\Brother;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Jenssegers\Date\Date;

class BrotherDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', function($query){
            return  '<a href="'.route("brothers.show", $query->id).'" class="label label-success action-show" title="Ver"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route("brothers.edit", $query->id).'" class="label label-warning action-edit" title="Editar"><i class="fa fa-edit"></i></a>'.
                    '<a href="javascript:void(0)" onclick="modalDestroy(event,'.$query->id.',\''.$query->name.'\')" class="label label-danger action-destroy" title="Eliminar"><i class="fa fa-remove"></i></a>';
        })
        ->editColumn('created_at', function ($query) {
                # set datetime format
                /*$date_created =  ucfirst(Date::parse($query->created_at)->format('l d \d\e ')); 
                $date_created .=  ucfirst(Date::parse($query->created_at)->format('F \d\e\l Y'));
                */
               
                $date_created =  ucfirst(Date::parse($query->created_at)->format('d \d\e ')); 
                $date_created .=  ucfirst(Date::parse($query->created_at)->format('F, Y')); 
                return $query->created_at ? $date_created : '';
        })
        ->editColumn('updated_at', function ($query) {
                # set datetime format
                $date_updated =  ucfirst(Date::parse($query->updated_at)->format('d \d\e ')); 
                $date_updated .=  ucfirst(Date::parse($query->updated_at)->format('F, Y')); 
                return $query->updated_at ? $date_updated : '';
        })
        ->editColumn('birth', function ($query) {
            # set datetime format
            $date_birth =  ucfirst(Date::parse($query->birth)->format('d \d\e ')); 
            $date_birth .=  ucfirst(Date::parse($query->birth)->format('F, Y')); 
            return $query->birth ? $date_birth : '';
        });


        return datatables($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Brother $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Brother $model)
    {

        $brother = $model->newQuery()->select();


        return $this->applyScopes($brother);

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['title'=>'', 'width'=>'80px', 'orderable'=>false, 'sortable'=>false, 'printable'=>false, 'exportable'=>false, 'searchable'=>false])
                    ->parameters([
                        'dom'     => "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'rt>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                        'order'   => [[0, 'asc']],
                        'responsive' => true,
                        'language' => [ 'url' => route('ajax.datatable_lang') ],
                        'buttons' => [
                            ['extend' => 'create',
                               'text' => '<i class="fa fa-user-plus"></i> Crear',
                               'className' => 'btn-primary button-create-color',
                            ],
                            'export',
                            'print',
                            'reset',
                        ],
                        'initComplete' => 'function(setting, json){ $("#datatable-view").fadeTo( "slow" , 1.0); }'
                        /* Columns Priority for Responsive
                        'columnDefs'=> [
                            [ 'responsivePriority'=> 1, 'targets'=> 0 ],
                            [ 'responsivePriority'=> 2, 'targets'=> -1 ]
                        ],
                        */
                    ]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['name'=>'id', 'data'=>'id', 'title'=>'ID', 'visible'=>true],
            'name' => ['name'=>'name', 'data'=>'name', 'title'=>'Nombre', 'visible'=>true],
            'birth' => ['name'=>'birth', 'data'=>'birth', 'title'=>'Nacimiento', 'visible'=>true],
            'phone' => ['name'=>'phone', 'data'=>'phone', 'title'=>'Telefono', 'visible'=>true],
            'celphone' => ['name'=>'celphone', 'data'=>'celphone', 'title'=>'Celular', 'visible'=>true],
            'address' => ['name'=>'address', 'data'=>'address', 'title'=>'Dirección', 'visible'=>false],
            'observation' => ['name'=>'observation', 'data'=>'observation', 'title'=>'Observación', 'visible'=>false],
            'created_at' => ['name'=>'created_at', 'data'=>'created_at', 'title'=>'Creado en', 'visible'=>false],
            'updated_at' => ['name'=>'updated_at', 'data'=>'updated_at', 'title'=>'Modificado en', 'visible'=>false],
            'created_at' => ['name'=>'created_at', 'data'=>'created_at', 'title'=>'Eliminado en', 'visible'=>false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Brother_' . date('YmdHis');
    }
}
