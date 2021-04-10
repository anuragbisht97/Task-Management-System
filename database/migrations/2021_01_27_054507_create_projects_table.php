<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
	public function up()
	{
		Schema::create('projects', function (Blueprint $table) {
			$table->id();
			$table->string('project_id')->unique();
			$table->string('project_name')->unique();
			$table->string('summary')->unique();
			$table->string('description')->nullable();
			$table->integer('project_status');
			$table->foreignId('project_created_by');
            $table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('projects');
	}
}
