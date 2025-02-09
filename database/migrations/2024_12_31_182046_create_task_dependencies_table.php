<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

use App\Enums\DependencyTypes;

/**
 * タスクの依存関係を管理するためのマイグレーションクラス
 *
 * このテーブルは以下の依存関係を管理します：
 * - dependent_task_id: 依存する側のタスク（子タスク）
 * - dependency_task_id: 依存される側のタスク（親タスク）
 * - dependency_type: 依存関係の種類
 *   - FS (Finish to Start): 先行タスク完了後に開始（デフォルト）
 *   - SS (Start to Start): 先行タスクと同時に開始
 *   - FF (Finish to Finish): 先行タスクと同時に完了
 *   - SF (Start to Finish): 先行タスク開始後に完了
 * - lag_days: 遅延日数（正の値）またはリード日数（負の値）
 *
 * 例：タスクAがタスクBの完了3日後に開始する場合
 * - dependent_task_id: タスクAのID
 * - dependency_task_id: タスクBのID
 * - dependency_type: 'FS'
 * - lag_days: 3
 *
 * 注意：
 * - 循環参照のチェックはアプリケーションレベルで実装する必要があります
 * - lag_daysは依存タイプに応じて解釈が変わります
 */
return new class extends Migration
{
    /**
     * タスクの依存関係テーブルを作成
     *
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('task_dependencies', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number'); // タスク番号
            $table->unsignedBigInteger('depends_on_task_number');   // 依存されるタスク番号
            $table->enum('dependency_type', array_column(DependencyTypes::cases(), 'value'))
                ->default(DependencyTypes::FINISH_TO_START->value)
                ->comment('依存関係の種類（FS: 終了後開始, SS: 同時開始, FF: 同時終了, SF: 開始後終了）');
                
            $table->integer('lag_minutes')
                ->default(0)
                ->comment('遅延（正）またはリード（負）時間（分単位）。例：60=1時間後、-30=30分前');
            $table->timestamps();

            // 外部キー制約
            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign(['project_id', 'depends_on_task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            // インデックス
            $table->index('dependency_type');

            // 主キー制約
            $table->primary(['project_id', 'task_number', 'depends_on_task_number']);
        });
    }

    /**
     * タスクの依存関係テーブルを削除
     *
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('task_dependencies');
    }
};
