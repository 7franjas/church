<?php

namespace App\DataTables;

use App\Egreso;
use App\Area;
use App\Subarea;
use App\Brother;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Jenssegers\Date\Date;

class EgresoDataTable extends DataTable
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
            return  '<a href="'.route("egresos.show", $query->id).'" class="label label-success action-show" title="Ver"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route("egresos.edit", $query->id).'" class="label label-warning action-edit" title="Editar"><i class="fa fa-edit"></i></a>'.
                    '<a href="javascript:void(0)" onclick="modalDestroy(event,'.$query->id.')" class="label label-danger action-destroy" title="Eliminar"><i class="fa fa-remove"></i></a>';
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
        ->editColumn('date', function ($query) {
                # set datetime format
                $date_updated =  ucfirst(Date::parse($query->date)->format('d \d\e ')); 
                $date_updated .=  ucfirst(Date::parse($query->date)->format('F, Y')); 
                return $query->date ? $date_updated : '';
        })
        ->editColumn('area_id', function ($query) {

                $areas = Area::where('id',$query->area_id)->first();
                return $areas ? $areas->area : '';
        })
        ->editColumn('subarea_id', function ($query) {

                $subareas = Subarea::where('id',$query->subarea_id)->first();
                return $subareas ? $subareas->subarea : '';
        })
        ->editColumn('brother_id', function ($query) {

                $brothers = Brother::where('id',$query->brother_id)->first();
                return $brothers ? $brothers->name : '';
        })      
        ->editColumn('monto', function ($query) {            
            return number_format($query->monto, 0, ',', '.')  ? number_format($query->monto, 0, ',', '.') : '';
        });


        return datatables($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Egreso $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Egreso $model)
    {
        $ingreso = $model->newQuery()->select();


        return $this->applyScopes($ingreso);
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
            'id' => ['name'=>'id', 'data'=>'id', 'title'=>'Nro Egreso', 'visible'=>true],
            'area_id' => ['name'=>'area_id', 'data'=>'area_id', 'title'=>'Area', 'visible'=>true],
            'subarea_id' => ['name'=>'subarea_id', 'data'=>'subarea_id', 'title'=>'Subarea', 'visible'=>true],
            'brother_id' => ['name'=>'brother_id', 'data'=>'brother_id', 'title'=>'Encargado', 'visible'=>true],
            'monto' => ['name'=>'monto', 'data'=>'monto', 'title'=>'Monto', 'visible'=>true],
            'date' => ['name'=>'date', 'data'=>'date', 'title'=>'Fecha', 'visible'=>true],
            'type' => ['name'=>'type', 'data'=>'type', 'title'=>'Tipo', 'visible'=>false],
            'observation' => ['name'=>'observation', 'data'=>'observation', 'title'=>'Nro Ingreso', 'visible'=>false],
            'created_at' => ['name'=>'created_at', 'data'=>'created_at', 'title'=>'Creado en', 'visible'=>false],
            'updated_at' => ['name'=>'updated_at', 'data'=>'updated_at', 'title'=>'Modificado en', 'visible'=>false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Egreso_' . date('YmdHis');
    }
}
