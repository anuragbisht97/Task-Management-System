<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function type(Request $request)
	{
		$currentAccountType = Auth::user()->role;
		if($request->ajax())
		{
			return Response($currentAccountType);
		}
	}

	public function name(Request $request)
	{
		$currentAccountId = Auth::user()->id;
		$result = $currentAccountId;
		if($request->ajax())
		{
			return Response($result);
		}
	}

	public function index()
	{
        $currentAccountStatus = Auth::user()->user_status;
        if($currentAccountStatus == 0){
            return view('user_status_0');
        }
        else{
		return view('users.index');
        }
	}

	public function search(Request $request)
	{
		$currentAccountType = Auth::user()->role;
		$output="";
		if($request->ajax())
		{
			if($request->search == "")
			{
				if($request->btn == 0){
					$users = User::orderBy('id', 'ASC')->get();
				}
				elseif($request->btn == 1){
					$users = User::orderBy('name', 'ASC')->get();
				}
				elseif($request->btn == -1){
					$users = User::orderBy('name', 'DESC')->get();
				}
			}
			elseif($request->search != "")
			{
				if($request->btn == 0){
					$users=User::select('*')->where('name','LIKE','%'.$request->search.'%')
					->orderBy('id', 'ASC')->get();
				}
				elseif($request->btn == 1){
					$users=User::select('*')->where('name','LIKE','%'.$request->search.'%')
					->orderBy('name', 'ASC')->get();
				}
				elseif($request->btn == -1){
					$users=User::select('*')->where('name','LIKE','%'.$request->search.'%')
					->orderBy('name', 'DESC')->get();
				}
			}
			foreach ($users as $user) {
				$output.='<tr class="border text-center">'.
				'<td class="font-black">'.$user->user_id.'</td>'.
				'<td>'.$user->name.'</td>'.
				'<td>'.$user->phone_number.'</td>'.
				'<td>'.$user->email.'</td>'.
				'<td>'.$user->designation.'</td>'.
				'<td>' .$user->role. '</td>';

				if($currentAccountType=='admin' || $currentAccountType=='super')
				{
					$output.='<td>'.

					'<div class="flex justify-evenly">'.
					'<a href = "users/'.$user->id.'/edit">'.
					'<img src = "images/edit.svg" style="width:35px;height:35px;">'.
					'</a>';

					if($currentAccountType=='super')
					{
						$output.='<span data-url = "users/'.$user->id.'" id="del">'.
						'<img src = "images/delete.svg" style="width:35px;height:35px;" class="cursor-pointer">'.
						'</span>'.

						'</div>'.

						'</td>';
					}
				}
				$output.='</tr>';
			}
			return Response($output);
		}
	}

	public function edit(Request $request, User $user)
	{
		return view('users.edit', compact('user'));
	}

	public function update(Request $request, User $user)
	{
		$validated = $request->validate([
			'user_id' => 'required|string|max:30',
			'name' => 'required|string|max:30',
			'phone_number' => 'required|integer|digits:10',
			'email' => 'required|string|email|max:60',
			'address' => 'required|string|max:120',
			'designation' => 'required|string|max:30',
			'role' => 'required|string',
            'user_status' => 'required|integer'
			]);

			$temp = $request->name;
			$datas = explode(" ", $temp);
			$acronym = "";

			foreach ($datas as $d)
			{
				$acronym .=$d[0];
				$temp1 = strtoupper($acronym);
			}

			$temp2 = $user->id;
			$tfinal = "User_".$temp1."_".$temp2;

			if($tfinal != $request->user_id)
			{
				$temp1 = $request->user_id;
				$temp2 = $user->id;
				$final = $temp1."_".$temp2;

				$user->user_id = $final;
			}
			else
			{
				$user->user_id = $request->user_id;
			}

			$user->name = $request->name;
			$user->phone_number = $request->phone_number;
			$user->email = $request->email;
			$user->address = $request->address;
			$user->designation = $request->designation;
			$user->role = $request->role;
            $user->user_status = $request->user_status;
			$user->save();

			return redirect()->to('/users');
		}

        public function changePassForm(){
            return view('changePassForm');
        }

        public function changePassword(Request $request){

            $validated = $request->validate([
                'password' => 'string|min:8'
                ]);

                $temp1 = Auth::user()->id;
                $temp2 = Hash::make($request->new_pass);

                DB::table('users')->where('id', $temp1)->update(['password' => $temp2]);
                return redirect()->to('/dashboard');

        }

		public function destroy(User $user, Request $request)
		{
			if($request->ajax())
			{
				$user->delete();
			}
		}

	}
