<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\UserDataTable;
use App\User;
use App\Role;
use Hash;
use Auth;
use Jenssegers\Date\Date;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //public function index()     {           return 'view('adminlte::box.create')';    }
    
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('adminlte::manage.users.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::all();


        return view('adminlte::manage.users.create')->withRoles($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'roles' => 'required'
        ];
        $this->validate($request, $rules);

        # set password
        if(!empty($request->password)){
            $password = trim($request->password);
            $user_password = $password;
        }else{
            $length = 10;
            $keyspace = '239847832974982374982374982739asuiqweuiqwy2189y2';
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i=0; $i < $length; $i++) { 
                $str .= $keyspace[random_int(0, $max)];
            }
            $password = $str;
            $user_password = $password;
        }

        # save user data
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email = $request->userName;
        $user->password = Hash::make($password);

        if($user->save()){     

            # check if change the role
            if(!empty($request->roles)){
                $user->syncRoles(explode(',',$request->roles));
            }else{
                $user->syncRoles($request->roles);
            }

            $alert = array(
                'message' => 'Se ha creado el usuario '.$user->name, 
                'alert-type' => 'success'
            );
            return redirect()->route('users.show', $user->id)->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al crear el usuario', 
                'alert-type' => 'warning'
            );
            return redirect()->route('users.create')->with($alert);
        }  


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        if($user){

            return view('adminlte::manage.users.show')
                    ->withUser($user);

        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        $roles = Role::all();

        if($user){
            return view('adminlte::manage.users.edit')
                    ->withUser($user)
                    ->withRoles($roles);
        }else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        # set validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email = $request->userName;

        # check password option and set password
        if($request->password_options == 'auto') {

            $length = 10;
            $keyspace = '239847832974982374982374982739asuiqweuiqwy2189y2';
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i=0; $i < $length; $i++) { 
                $str .= $keyspace[random_int(0, $max)];
            }
            $user->password = Hash::make($str);

        }else if($request->password_options == 'manual'){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        # check if change the role
        if(!empty($request->roles)){
            $user->syncRoles(explode(',',$request->roles));
        }else{
            $user->syncRoles($request->roles);
        }

        $alert = array(
            'message' => 'Se ha actualizado el usuario '.$user->name, 
            'alert-type' => 'success'
        );
        return redirect()->route('users.show', $user->id)->with($alert);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->first();        
        $user->delete();

        return response()->json(['success' => 'ok', 'user' => $user->name]);
    }



    public function profile(){
        $id = Auth::user()->id; 
        $user = User::where('id', $id)->first();

        $team = null;
        $create_date = ucfirst(Date::parse($user->created_at)->format('d \d\e '));
        $create_date .= ucfirst(Date::parse($user->created_at)->format('F, Y'));
        $user->created_date = $create_date;


        return view('adminlte::setting.profile')->withUser($user)->withTeam($team);
    }
}
