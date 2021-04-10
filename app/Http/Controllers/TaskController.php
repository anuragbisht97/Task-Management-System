<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

	public function gettaskdash(Request $request)
	{
		if($request->ajax())
		{
			$outputp = "";
			$outputc = "";
			$tasksp=Task::select('*')->where('task_status', '0')
			->orderBy('id', 'ASC')->get();
			$tasksc=Task::select('*')->where('task_status', '1')
			->orderBy('id', 'ASC')->get();
			foreach($tasksp as $task){
				$outputp.='<li>'.$task->task_name.'<li>';
			}
			foreach($tasksc as $task){
				$outputc.='<li>'.$task->task_name.'<li>';
			}
			$tasks = [$outputp, $outputc];
		}
		return Response($tasks);
	}

	public function index()
	{
		$currentAccountStatus = Auth::user()->user_status;
		if($currentAccountStatus == 0){
			return view('user_status_0');
		}
		else{
			return view('tasks.index');
		}
	}

	public function search(Request $request)
	{
		$currentAccountType = Auth::user()->role;
		$output="";
		if($request->ajax())
		{
			$output="";
			if($request->search == "")
			{
				if($request->btn == 0){
					$tasks = Task::orderBy('id', 'ASC')->get();
				}
				elseif($request->btn == 1){
					$tasks = Task::orderBy('task_name', 'ASC')->get();
				}
				elseif($request->btn == -1){
					$tasks = Task::orderBy('task_name', 'DESC')->get();
				}
			}
			elseif($request->search != "")
			{
				if($request->btn == 0){
					$tasks=Task::select('*')->where('task_name','LIKE','%'.$request->search.'%')
					->orderBy('id', 'ASC')->get();
				}
				elseif($request->btn == 1){
					$tasks=Task::select('*')->where('task_name','LIKE','%'.$request->search.'%')
					->orderBy('task_name', 'ASC')->get();
				}
				elseif($request->btn == -1){
					$tasks=Task::select('*')->where('task_name','LIKE','%'.$request->search.'%')
					->orderBy('task_name', 'DESC')->get();
				}
			}
			foreach ($tasks as $task) {

				$output.='<tr class="border text-center">';

                $output.='<td class="font-black">'.$task->task_id.'</td>'.
				'<td>'.$task->task_name.'</td>';

				if($task->projectId==null){
					$output.='<td><b>NA[DELETED]</b></td>';
				}else{
					$output.='<td>'.$task->projectId->project_name.'</td>';
				}

                if($task->taskCreatedBy==null){
					$output.='<td><b>NA[DELETED]</b></td>';
				}else{
					$output.='<td>'.$task->taskCreatedBy->name.'</td>';
				}

				if($task->assignTo==null){
					$output.='<td><b>NA[DELETED]</b></td>';
				}else{
					$output.='<td>'.$task->assignTo->name.'</td>';
				}

				if($currentAccountType=='admin' || $currentAccountType=='super')
				{

					$output.='<td>'.

					'<div class="flex justify-evenly">'.
					'<a href = "tasks/'.$task->id.'/edit">'.
					'<img src = "images/edit.svg" style="width:35px;height:35px;">'.
					'</a>';

					if($currentAccountType=='super')
					{
						$output.='<span data-url = "tasks/'.$task->id.'" id="del">'.
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
		$projects=Project::all();
		$users=User::all();
		return view('tasks.create', compact('projects','users'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'project_id' => 'required|integer',
			'task_name' => 'required|string|unique:tasks|max:30',
			'task_id' => 'required|string|unique:tasks|max:30',
			'summary' => 'required|string|unique:tasks|max:60',
			'description' => 'max:120',
			'assign_to' => 'required|integer',
			'assign_by' => 'required|integer',
			'task_created_by' => 'required|integer'
			]);

			$statement = DB::select("SHOW TABLE STATUS LIKE 'tasks'");
			$new_id = $statement[0]->Auto_increment;

                    $temp = $request->task_name;
					$datas = explode(" ", $temp);
					$acronym = "";

					foreach ($datas as $d)
					{
						$acronym .=$d[0];
						$temp1 = strtoupper($acronym);
					}

					$temp2 = $new_id;
					$tfinal = "Task_".$temp1."_".$temp2;

					if($tfinal != $request->task_id)
					{
						$temp1 = $request->task_id;
						$temp2 = $new_id;
						$final = $temp1."_".$temp2;
					}
					else
					{
						$final = $request->task_id;
					}

			Task::create([
				'project_id' => $request->project_id,
				'task_name' => $request->task_name,
				'task_id' => $final,
				'summary' => $request->summary,
				'description' => $request->description,
				'assign_to' => $request->assign_to,
				'assign_by' => $request->assign_by,
				'task_created_by' => $request->task_created_by
				]);
				return redirect()->to('/tasks');
			}

			public function edit(Request $request, Task $task)
			{
				$projects=Project::all();
				$users=User::all();
				return view('tasks.edit', compact('task', 'projects', 'users'));
			}

			public function update(Request $request, Task $task)
			{
				$validated = $request->validate([
					'project_id' => 'required|integer',
					'task_name' => 'required|string|max:30',
					'task_id' => 'required|string|max:30',
					'summary' => 'required|string|max:60',
					'description' => 'max:120',
					'assign_to' => 'required|integer',
					'assign_by' => 'required|integer',
					'task_created_by' => 'required|integer',
                    'task_status' => 'required|integer'
					]);

                    $temp = $request->task_name;
					$datas = explode(" ", $temp);
					$acronym = "";

					foreach ($datas as $d)
					{
						$acronym .=$d[0];
						$temp1 = strtoupper($acronym);
					}

					$temp2 = $task->id;
					$tfinal = "Task_".$temp1."_".$temp2;

					if($tfinal != $request->task_id)
					{
						$temp1 = $request->task_id;
						$temp2 = $task->id;
						$final = $temp1."_".$temp2;

						$task->task_id = $final;
					}
					else
					{
						$task->task_id = $request->task_id;
					}

					$task->project_id = $request->project_id;
					$task->task_name = $request->task_name;
					$task->summary = $request->summary;
					$task->description = $request->description;
					$task->assign_by = $request->assign_by;
					$task->assign_to = $request->assign_to;
					$task->task_created_by = $request->task_created_by;
                    $task->task_status = $request->task_status;

					$task->save();

					return redirect()->to('/tasks');
				}

				public function destroy(Task $task, Request $request)
				{
					if($request->ajax())
					{
						$task->delete();
					}
				}
			}
