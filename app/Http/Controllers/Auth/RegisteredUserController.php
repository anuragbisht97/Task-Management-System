<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
	/**
	* Display the registration view.
	*
	* @return \Illuminate\View\View
	*/
	public function create()
	{
		return view('auth.register');
	}

	/**
	* Handle an incoming registration request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\RedirectResponse
	*
	* @throws \Illuminate\Validation\ValidationException
	*/
	public function store(Request $request)
	{
		$request->validate([
			'user_id' => 'required|string|unique:users|max:30',
			'name' => 'required|string|unique:users|max:30',
			'phone_number' => 'required|integer|unique:users|digits:10',
			'email' => 'required|string|email|unique:users|max:60',
			'address' => 'required|string|unique:users|max:120',
			'designation' => 'required|string|max:30',
			'role' => 'required|string',
			'password' => 'required|string|confirmed|min:8',
			]);

			$statement = DB::select("SHOW TABLE STATUS LIKE 'users'");
			$new_id = $statement[0]->Auto_increment;

                $temp = $request->name;
					$datas = explode(" ", $temp);
					$acronym = "";

					foreach ($datas as $d)
					{
						$acronym .=$d[0];
						$temp1 = strtoupper($acronym);
					}

					$temp2 = $new_id;
					$tfinal = "User_".$temp1."_".$temp2;

					if($tfinal != $request->user_id)
					{
						$temp1 = $request->user_id;
						$temp2 = $new_id;
						$final = $temp1."_".$temp2;
					}
					else
					{
						$final = $request->user_id;
					}

			Auth::login($user = User::create([
				'user_id' => $final,
				'name' => $request->name,
				'phone_number' => $request->phone_number,
				'email' => $request->email,
				'address' => $request->address,
				'designation' => $request->designation,
				'role' => $request->role,
				'password' => Hash::make($request->password),
				]));

				event(new Registered($user));

				return redirect(RouteServiceProvider::HOME);

			}
		}
