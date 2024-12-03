<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (integer)
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['opened', 'in_progress', 'completed' , 'closed'])->default('opened');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // Add priority column
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('created_by'); // FK to users
            $table->unsignedBigInteger('assigned_to')->nullable(); // FK to users
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
