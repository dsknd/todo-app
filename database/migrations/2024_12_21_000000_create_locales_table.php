<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table) {
            // 基本カラム定義
            $table->unsignedBigInteger('id');
            $table->string('language_code', 10)->comment('言語コード (ISO 639-1, e.g. "ja", "en")');
            $table->string('region_code', 10)->nullable()->comment('地域コード (ISO 3166-1, e.g. "JP", "US")');
            $table->string('script_code', 10)->nullable()->comment('スクリプトコード (ISO 15924, e.g. "Latn", "Jpan")');
            $table->string('format_bcp47', 20)->comment('BCP47形式 (e.g. "ja-JP", "en-US")');
            $table->string('format_cldr', 20)->comment('CLDR形式 (e.g. "ja_JP", "en_US")');
            $table->string('format_posix', 30)->comment('POSIX形式 (e.g. "ja_JP.UTF-8", "en_US.UTF-8")');
            $table->string('name')->comment('ロケール名 (e.g. "日本語（日本）", "English (United States)")');
            $table->string('native_name')->comment('ネイティブ表記のロケール名 (e.g. "日本語（日本）", "English (United States)")');
            
            // 日時フォーマット関連カラム
            $table->string('date_format_short', 30)->comment('短い日付形式 (e.g. "Y/m/d", "n/j/Y")');
            $table->string('date_format_medium', 30)->comment('中程度の日付形式 (e.g. "Y年n月j日", "M j, Y")');
            $table->string('date_format_long', 50)->comment('長い日付形式 (e.g. "Y年n月j日(D)", "l, F j, Y")');
            $table->string('time_format_short', 20)->comment('短い時間形式 (e.g. "H:i", "g:i a")');
            $table->string('time_format_medium', 30)->comment('中程度の時間形式 (e.g. "H:i:s", "g:i:s a")');
            $table->string('datetime_format_short', 50)->comment('短い日時形式 (e.g. "Y/m/d H:i", "n/j/Y, g:i a")');
            $table->string('first_day_of_week', 10)->comment('週の最初の曜日 (e.g. "monday", "sunday")');
            $table->boolean('is_24hour_format')->default(true)->comment('24時間形式を使用するか');
            $table->string('default_timezone', 50)->comment('デフォルトのタイムゾーン (e.g. "Asia/Tokyo", "America/New_York")');
            
            // その他のカラム
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // ユニーク制約
            $table->unique(['language_code', 'region_code', 'script_code']);
            $table->unique('format_bcp47');
            
            // インデックス
            $table->index('is_active');
            $table->index('language_code');
            $table->index('region_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
}; 