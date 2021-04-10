<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
	use HasFactory;
    use SoftDeletes;

	protected $fillable = [
		'project_id', 'project_name', 'summary', 'description', 'project_created_by'
	];

	protected $attributes = [
		'project_status' => 0
	];

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}

	public function projectCreatedBy()
	{
		return $this->belongsTo(User::class,'project_created_by');
	}

    /**
    *The attributes that should be mutated to dates.
    *
    *@var array
    */
    protected $dates = ['deleted_at'];
}
