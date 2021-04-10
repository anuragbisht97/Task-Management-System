<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
	public function getprojectdash(Request $request)
	{
		if($request->ajax())
		{
			$outputp = "";
			$outputc = "";
			$projectsp=Project::select('*')->where('project_status', '0')
			->orderBy('id', 'ASC')->get();
			$projectsc=Project::select('*')->where('project_status', '1')
			->orderBy('id', 'ASC')->get();
			foreach($projectsp as $project){
				$outputp.='<li>'.$project->project_name.'<li>';
			}
			foreach($projectsc as $project){
				$outputc.='<li>'.$project->project_name.'<li>';
			}
			$projects = [$outputp, $outputc];
		}
		return Response($projects);
	}

	public function index()
	{
		$currentAccountStatus = Auth::user()->user_status;
		if($currentAccountStatus == 0){
			return view('user_status_0');
		}
		else{
			return view('projects.index');
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
					$projects = Project::orderBy('id', 'ASC')->get();
				}
				elseif($request->btn == 1){
					$projects = Project::orderBy('project_name', 'ASC')->get();
				}
				elseif($request->btn == -1){
					$projects = Project::orderBy('project_name', 'DESC')->get();
				}
			}
			elseif($request->search != "")
			{
				if($request->btn == 0){
					$projects=Project::select('*')->where('project_name','LIKE','%'.$request->search.'%')
					->orderBy('id', 'ASC')->get();
				}
				elseif($request->btn == 1){
					$projects=Project::select('*')->where('project_name','LIKE','%'.$request->search.'%')
					->orderBy('project_name', 'ASC')->get();
				}
				elseif($request->btn == -1){
					$projects=Project::select('*')->where('project_name','LIKE','%'.$request->search.'%')
					->orderBy('project_name', 'DESC')->get();
				}
			}

			foreach ($projects as $project) {
				$output.='<tr class="border text-center">'.
				'<td class="font-black">'.$project->project_id.'</td>'.
				'<td>'.$project->project_name.'</td>'.
				'<td>'.$project->summary.'</td>';

                if($project->projectCreatedBy==null){
					$output.='<td><b>NA[DELETED]</b></td>';
				}else{
					$output.='<td>'.$project->projectCreatedBy->name.'</td>';
				}

				if($currentAccountType=='admin' || $currentAccountType=='super')
				{
					$output.='<td>'.

					'<div class="flex justify-evenly">'.
					'<a href = "projects/'.$project->id.'/edit">'.
					'<img src = "images/edit.svg" style="width:35px;height:35px;">'.
					'</a>';

					if($currentAccountType=='super')
					{
						$output.='<span data-url = "projects/'.$project->id.'" id="del">'.
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

	public function create()
	{
		return view('projects.create');
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'project_id' => 'required|string|unique:projects|max:30',
			'project_name' => 'required|string|unique:projects|max:30',
			'summary' => 'string|unique:projects|max:60',
			'description' => 'max:120',
			'project_created_by' => 'required|integer'
			]);

			$statement = DB::select("SHOW TABLE STATUS LIKE 'projects'");
			$new_id = $statement[0]->Auto_increment;

            $temp = $request->project_name;
					$datas = explode(" ", $temp);
					$acronym = "";

					foreach ($datas as $d)
					{
						$acronym .=$d[0];
						$temp1 = strtoupper($acronym);
					}

					$temp2 = $new_id;
					$tfinal = "Project_".$temp1."_".$temp2;

					if($tfinal != $request->project_id)
					{
						$temp1 = $request->project_id;
						$temp2 = $new_id;
						$final = $temp1."_".$temp2;
					}
					else
					{
						$final = $request->project_id;
					}

			Project::create([
				'project_id' => $final,
				'project_name' => $request->project_name,
				'summary' => $request->summary,
				'description' => $request->description,
				'project_created_by' => $request->project_created_by
				]);

				return redirect()->to('/projects');
			}

			public function edit(Request $request, Project $project)
			{
				$users=User::all();
				return view('projects.edit', compact('project', 'users'));
			}

			public function update(Request $request, Project $project)
			{
				$validated = $request->validate([
					'project_id' => 'required|string|max:30',
					'project_name' => 'required|string|max:30',
					'summary' => 'string|max:60',
					'description' => 'max:120',
					'project_created_by' => 'required|integer',
                    'project_status' => 'required|integer'
					]);

					$temp = $request->project_name;
					$datas = explode(" ", $temp);
					$acronym = "";

					foreach ($datas as $d)
					{
						$acronym .=$d[0];
						$temp1 = strtoupper($acronym);
					}

					$temp2 = $project->id;
					$tfinal = "Project_".$temp1."_".$temp2;

					if($tfinal != $request->project_id)
					{
						$temp1 = $request->project_id;
						$temp2 = $project->id;
						$final = $temp1."_".$temp2;

						$project->project_id = $final;
					}
					else
					{
						$project->project_id = $request->project_id;
					}

					$project->project_name = $request->project_name;
					$project->summary = $request->summary;
					$project->description = $request->description;
					$project->project_created_by = $request->project_created_by;
                    $project->project_status = $request->project_status;

					$project->save();

					return redirect()->to('/projects');
				}

				public function destroy(Project $project, Request $request)
				{
					if($request->ajax())
					{
						$project->delete();
					}
				}
			}
