<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\LocaleEnum;
use App\Enums\InvitationType;
use App\Enums\InvitationTypeTranslationEnum;

class InvitationTypeTranslationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (InvitationType::cases() as $invitationType) {
            foreach (LocaleEnum::cases() as $locale) {
                DB::table('invitation_type_translations')->insert([
                    'invitation_type_id' => $invitationType->value,
                    'locale_id' => $locale->value,
                    'name' => InvitationTypeTranslationEnum::getName($invitationType, $locale),
                    'description' => InvitationTypeTranslationEnum::getDescription($invitationType, $locale),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
