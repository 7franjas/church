<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Laravel\Dusk\DuskServiceProvider;
use View;
use Auth;
use App\User;
use App\Role;
use Jenssegers\Date\Date;

class GlobalVariableServiceProvider extends ServiceProvider
{
    /**
     * Global variables services.
     *
     * @return void
     */
    public function boot()
    {
        # return to all views global variables
        view()->composer('*',function($view) {
            # check if is auth
            if (Auth::check()){ 
                
                # return variable, prefix [global_]
                $user = User::where('id', Auth::user()->id)->with(['roles' => function($query){
                    return $query->orderBy('name','ASC')->get();
                }])->first();
                //$profile = User::find(Auth::user()->id)->profile;  
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


                # return values on variables
                //$view->with('global_profile', $profile);
                $view->with('global_roles', $user->roles);
                $view->with('global_role_priority', $role_priority);

            }
        });
    }
}
