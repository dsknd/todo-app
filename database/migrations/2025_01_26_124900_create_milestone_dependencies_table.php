<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\MilestoneDependencyTypeEnum;
/**
 * マイルストーンの依存関係を管理するマイグレーション
 */
return new class extends Migration
{
    /**
     * マイルストーンの依存関係テーブルを作成
     */
    public function up(): void
    {
        Schema::create('milestone_dependencies', function (Blueprint $table) {
            $table->unsignedBigInteger('milestone_id');    // 後続のマイルストーン
            $table->unsignedBigInteger('depends_on_milestone_id');   // 先行のマイルストーン
            $table->enum('dependency_type', array_column(MilestoneDependencyTypeEnum::cases(), 'value'))
                ->default(MilestoneDependencyTypeEnum::REQUIRED->value)
                ->comment('依存の種類（例: REQUIRED, OPTIONAL）');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('milestone_id')
                ->references('id')
                ->on('milestones')
                ->cascadeOnDelete();

            $table->foreign('depends_on_milestone_id')
                ->references('id')
                ->on('milestones')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['milestone_id', 'depends_on_milestone_id']);
        });
    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('milestone_dependencies');
    }
};
