<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\InvitationStatusTranslationEnum;
use App\Enums\InvitationStatusEnum;
use App\Enums\LocaleEnum;

class InvitationStatusTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (InvitationStatusEnum::cases() as $status) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('invitation_status_translations')->insert([
                        'invitation_status_id' => $status->value,
                        'locale_id' => $locale->value,
                        'name' => InvitationStatusTranslationEnum::getName($status, $locale),
                        'description' => InvitationStatusTranslationEnum::getDescription($status, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
