<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;

use App\Role;
use Illuminate\Http\Request;
use \Session;
use \Redirect;
use Hash;
class UserController extends Controller{
	/**
	 * Variable to model
	 *
	 * @var user
	 */
	protected $model;

	/**
	 * Create instance of controller with Model
	 *
	 * @return void
	 */
	public function __construct(User $model)
	{
		$this->middleware('auth');
		$this->model = $model;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if (Auth::user()->can('settings')) {
			if($request->get('search')){
				$search=\Request::get('search');
				$users = User::where('name','like','%'.$search.'%')->paginate(10);
			}else{
				$users = User::where('active_flag', 1)->orderBy('id', 'desc')->paginate(10);
			};
				$active = User::where('active_flag', 1);
				return view('users.index', compact('users', 'active'));	
		}
		else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::user()->can('settings')) {

		$roles = Role::where('active_flag', 1)->orderBy('name')->pluck('name', 'id');
		return view('users.create',compact('roles'));

		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request, User $user)
	{
		
		if (Auth::user()->can('settings')) {

		$user = new User();
		$user->name = ucfirst($request->input("name"));
		$user->email = $request->input("email");
		$user->password = bcrypt($request->input("password"));
		$user->client_token =$request->input("password");
		$user->active_flag = 1;
		//$user->author_id = $request->user()->id;

		$this->validate($request, [
					'name' => 'required|string|max:255',
		            'email' => 'required|string|email|max:255|unique:users',
		            'password' => 'required|string|min:6|confirmed',
			 ]);

		$user->save();
		$user->attachRole($request->input("roles"));	
		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The User \"<a href='users/$user->slug'>" . $user->name . "</a>\" was Created.");

		return redirect()->route('users.index');


		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(User $user)
	{
		if (Auth::user()->can('settings')) {
		return view('users.show', compact('user'));
		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(User $user)
	{
		if (Auth::user()->can('settings')) {
		//$user = $this->model->findOrFail($id);
		$roles = Role::where('active_flag', 1)->orderBy('name')->pluck('name', 'id');
		return view('users.edit', compact('user','roles'));

		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, User $user, Role $role)
	{
		if (Auth::user()->can('settings')) {
		$user->name = ucfirst($request->input("name"));
		$user->email = $request->input("email");
		$user->client_token =$request->input("password");
		//Hash::check($request->input('old_password'), Auth::user()->password)
		$pw=$request->input('old_password');
		$hashed = Hash::make($pw);
		if (Hash::check($pw,$hashed))
		{ 
			//return "test";
			$password = $user->password = bcrypt($request->input("password"));
			
		}
		else{
			return redirect()->back()->withErrors([
                    'password' => 'Wrong Password',
                ]);
		}
		$user->active_flag = 1;
		//$user->author_id = $request->user()->id;

		$this->validate($request, [
					'name' => 'required|string|max:255',
		            'email' => 'required|string|email|max:255',
			 ]);


		$user->save();
		$user->roles()->sync($request->input("roles"));
		
		Session::flash('message_type', 'warning');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', "The User \"<a href='users/$user->slug'>" . $user->name . "</a>\" was Updated.");

		return redirect()->route('users.index');

		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(User $user)
	{
		if (Auth::user()->can('settings')) {

		$user->active_flag = 0;
		$user->save();
		Session::flash('message_type', 'danger');
		Session::flash('message_icon', 'hide');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The User ' . $user->name . ' was De-Activated.');

		return redirect()->route('users.index');

		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}
	}

	/**
	 * Re-Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reactivate(User $user)
	{
		if (Auth::user()->can('settings')) {

		$user->active_flag = 1;
		$user->save();

		Session::flash('message_type', 'success');
		Session::flash('message_icon', 'checkmark');
		Session::flash('message_header', 'Success');
		Session::flash('message', 'The User ' . $user->name . ' was Re-Activated.');

		return redirect()->route('users.index');
		}else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('home');
		}

	}
	public function passwordgen()
	{

		     $alphabet = "ochremedia0123456789@#$%^*_!&?";
         
             $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            /* $users= User::where('active_flag', 1)
             ->where('email','NOT LIKE', "%ochre-media.com%")->get();*/
              $users= User::where('active_flag', 1)->get();
           
           
             foreach($users as $user){
				    $pass = []; //remember to declare $pass as an array
             	for ($i = 0; $i < 8; $i++) {
             		$n = rand(0, $alphaLength);
             		$pass[] = $alphabet[$n];
             	}
	             $password=implode($pass); //turn the array into a string
	             $hashed=bcrypt($password);
	             $user->client_token = $password;
	             $user->password = $hashed;
	             $user->save();
             }	
              
             return 'Done';
            
            }

            public function usertoken(Request $request)
            {

            if (Auth::user()->can('settings')) {
			if($request->get('search')){
				
				$search=\Request::get('search');
				$users = User::where('name','like','%'.$search.'%')->paginate(35);
			}else{
				$users = User::where('active_flag', 1)->orderBy('id', 'desc')->paginate(35);
			}
				
				 $active = User::where('active_flag', 1);

				return view('users.useinfo', compact('users', 'active'));	
		}
		else{
		Session::flash('message_type', 'danger');
   		Session::flash('message_icon', 'hide');
   		Session::flash('message_header', 'Success');
 
			Session::flash('message', "You do not have User permissions");
			  return redirect('');
		}
            }
}
