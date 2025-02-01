<?php

namespace Database\Seeders;

use App\Enums\LocaleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\LanguageCodeStandardEnum;
class LocaleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (LocaleEnum::cases() as $locale) {
                DB::table('locales')->insert([
                    'id' => $locale->value,
                    'code_iso_639_1' => $locale->getCode($locale, LanguageCodeStandardEnum::ISO_639_1),
                    'code_ietf_bcp_47' => $locale->getCode($locale, LanguageCodeStandardEnum::IETF_BCP_47),
                    'name' => $locale->getName($locale),
                    'is_active' => $locale->isActive($locale),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 