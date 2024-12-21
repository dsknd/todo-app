<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoClosuresTable extends Migration
{
    public function up()
    {
        Schema::create('todo_closures', function (Blueprint $table) {
            $table->unsignedBigInteger('ancestor_id'); // 祖先のID
            $table->unsignedBigInteger('descendant_id'); // 子孫のID
            $table->unsignedInteger('depth'); // 深さ
            $table->primary(['ancestor_id', 'descendant_id']); // 複合主キー
            $table->foreign('ancestor_id')->references('id')->on('todos')->onDelete('cascade');
            $table->foreign('descendant_id')->references('id')->on('todos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_closures');
    }
}
