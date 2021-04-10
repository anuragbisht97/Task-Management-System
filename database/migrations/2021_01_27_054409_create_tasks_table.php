<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
	public function up()
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id');
			$table->string('task_name')->unique();
			$table->string('task_id')->unique();
			$table->string('summary')->unique();
			$table->string('description')->nullable();
			$table->integer('task_status');
			$table->foreignId('task_created_by');
			$table->foreignId('assign_to');
			$table->foreignId('assign_by');
            $table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('tasks');
	}
}
