<?php

namespace Database\Seeders;

use App\Enums\LocaleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (LocaleEnum::cases() as $locale) {
                DB::table('locales')->insert([
                    'id' => $locale->value,
                    'language_code' => LocaleEnum::getLanguageCode($locale),
                    'region_code' => LocaleEnum::getRegionCode($locale),
                    'script_code' => LocaleEnum::getScriptCode($locale),
                    'format_bcp47' => LocaleEnum::getFormatBcp47($locale),
                    'format_cldr' => LocaleEnum::getFormatCldr($locale),
                    'format_posix' => LocaleEnum::getFormatPosix($locale),
                    'name' => LocaleEnum::getName($locale),
                    'native_name' => LocaleEnum::getNativeName($locale),
                    'date_format_short' => LocaleEnum::getDateFormatShort($locale),
                    'date_format_medium' => LocaleEnum::getDateFormatMedium($locale),
                    'date_format_long' => LocaleEnum::getDateFormatLong($locale),
                    'time_format_short' => LocaleEnum::getTimeFormatShort($locale),
                    'time_format_medium' => LocaleEnum::getTimeFormatMedium($locale),
                    'datetime_format_short' => LocaleEnum::getDatetimeFormatShort($locale),
                    'first_day_of_week' => LocaleEnum::getFirstDayOfWeek($locale),
                    'is_24hour_format' => LocaleEnum::is24HourFormat($locale),
                    'default_timezone' => LocaleEnum::getDefaultTimezone($locale),
                    'is_active' => LocaleEnum::isActive($locale),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 