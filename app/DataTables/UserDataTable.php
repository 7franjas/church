<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Auth;

class UserDataTable extends DataTable
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
             
          $user = User::where('id', $query->id)->with('Roles')->first();
          $role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
              # get global role for name ASC and order ASC
              if(count($user->roles)==1){
                $role_priority = $user->roles[0];
              }else{
                  foreach ($user->roles as $key => $role) {
                      if($key === 0){
                          $temp = $role;
                      }else{
                          if($temp->order <= $role->order){
                              $role_priority = $temp;
                          }else{
                              $role_priority = $role;
                              $temp = $role;
                          }
                      }

                  }
              }

            if( $query->id == Auth::user()->id || $role_priority->name == 'superadministrador' ){
              $destroy = '';
            }else{
              $destroy = '<a href="javascript:void(0)" onclick="modalDestroy(event,'.$query->id.',\''.$query->name.'\')" class="label label-danger action-destroy" title="Eliminar"><i class="fa fa-remove"></i></a>';
            }

            $user_auth = Auth::user();
            $role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
            # get global role for name ASC and order ASC
            if(count($user_auth->roles)==1){
              $role_priority = $user_auth->roles[0];
            }else{
                foreach ($user_auth->roles as $key => $role) {
                    if($key === 0){
                        $temp = $role;
                    }else{
                        if($temp->order <= $role->order){
                            $role_priority = $temp;
                        }else{
                            $role_priority = $role;
                            $temp = $role;
                        }
                    }

                }
            }

            if($role_priority->name == 'superadministrador'){
                return  '<a href="'.route("users.show", $query->id).'" class="label label-success action-show" title="Ver"><i class="fa fa-eye"></i></a>'.
                        '<a href="'.route("users.edit", $query->id).'" class="label label-warning action-edit" title="Editar"><i class="fa fa-edit"></i></a>'.$destroy;
            }else if($query->id == $user_auth->id){
                return  '<a href="'.route("profile").'" class="label label-success action-show" title="Ver"><i class="fa fa-eye"></i></a>';
            }else{
                return  '<a href="'.route("users.show", $query->id).'" class="label label-success action-show" title="Ver"><i class="fa fa-eye"></i></a>';           
            }
            

            return  '<a href="'.route("users.show", $query->id).'" class="label label-success action-show" title="Ver"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route("users.edit", $query->id).'" class="label label-warning action-edit" title="Editar"><i class="fa fa-edit"></i></a>';                    
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
        ->editColumn('role', function($query){ 
                  # return variable, prefix [global_]
                 $user = User::where('id', $query->id)->with(['roles' => function($query){
                     return $query->orderBy('name','ASC')->get();
                 }])->first();
 
                 $role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
                 # get global role for name ASC and order ASC
                 if(count($user->roles)==1){
                   $role_priority = $user->roles[0];
                 }else{
                     foreach ($user->roles as $key => $role) {
                         if($key === 0){
                             $temp = $role;
                         }else{
                             if($temp->order <= $role->order){
                                 $role_priority = $temp;
                             }else{
                                 $role_priority = $role;
                                 $temp = $role;
                             }
                         }
 
                     }
                 }
 
                 return $role_priority->display_name;
 
        });


        return datatables($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $user = $model->newQuery()->select();
        return $this->applyScopes($user);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $user_auth = Auth::user();
        $role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
        # get global role for name ASC and order ASC
        if(count($user_auth->roles)==1){
          $role_priority = $user_auth->roles[0];
        }else{
            foreach ($user_auth->roles as $key => $role) {
                if($key === 0){
                    $temp = $role;
                }else{
                    if($temp->order <= $role->order){
                        $role_priority = $temp;
                    }else{
                        $role_priority = $role;
                        $temp = $role;
                    }
                }
            }
        }

        if($role_priority->name == 'superadministrador'){
        $create = [
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
                'reload',
            ],
            'initComplete' => 'function(setting, json){ $("#datatable-view").fadeTo( "slow" , 1.0); }'
        ];

        }else{
            $create = [
                'dom'     => "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'rt>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                'order'   => [[0, 'asc']],
                'responsive' => true,
                'language' => [ 'url' => route('ajax.datatable_lang') ],
                'buttons' => [
                    'export',
                    'print',
                    'reset',
                    'reload',
                ],
                'initComplete' => 'function(setting, json){ $("#datatable-view").fadeTo( "slow" , 1.0); }'
            ];
        }

        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['title'=>'', 'width'=>'80px', 'orderable'=>false, 'sortable'=>false, 'printable'=>false, 'exportable'=>false, 'searchable'=>false])
                    ->parameters($create);
                    
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['name'=>'id', 'data'=>'id', 'title'=>'Nro Ingreso', 'visible'=>true],
            'name' => ['name'=>'name', 'data'=>'name', 'title'=>'Nombre', 'visible'=>true],
            'userName' => ['name'=>'userName', 'data'=>'userName', 'title'=>'Usuario', 'visible'=>true],
            'role' => ['name'=>'role', 'title'=>'Rol', 'searchable' => false, 'orderable'=>false, 'sortable'=>false ],
            'created_at' => ['name'=>'created_at', 'data'=>'created_at', 'title'=>'Creado en', 'visible'=>true],
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
        return 'us_export_' . date('YmdHis');
    }
}
