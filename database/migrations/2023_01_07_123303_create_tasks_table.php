<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamp('due_at')
                ->nullable();
            $table->timestamp('completed_at')
                ->nullable();
            $table->foreignId('assignee_id')
                ->nullable()
                ->constrained('team_user', 'id')
                ->onDelete('SET NULL');
            $table->foreignId('section_id')->constrained('sections', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
