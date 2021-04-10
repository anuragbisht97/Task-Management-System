<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
	use HasFactory;
    use SoftDeletes;

	protected $fillable = [
		'project_id', 'task_name', 'task_id', 'summary', 'description', 'assign_to', 'assign_by', 'task_created_by'
	];

	protected $attributes = [
		'task_status' => 0
	];

	public function projectId()
	{
		return $this->belongsTo(Project::class,'project_id');
	}

	public function assignBy()
	{
		return $this->belongsTo(User::class,'assign_by');
	}

	public function assignTo()
	{
		return $this->belongsTo(User::class,'assign_to');
	}

    public function taskCreatedBy()
	{
		return $this->belongsTo(User::class,'task_created_by');
	}

    /**
    *The attributes that should be mutated to dates.
    *
    *@var array
    */
    protected $dates = ['deleted_at'];
}
