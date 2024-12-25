<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMembersTable extends Migration
{
    public function up()
    {
        Schema::create('project_members', function (Blueprint $table) {
            // 外部キーとインデックス
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // 複合主キーを設定
            $table->primary(['project_id', 'user_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_members');
    }
}
