<?php

namespace Modules\DisciplineManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;

/**
 * Seeds the official Student Discipline Marks Matrix (Levels 1-5).
 * These values come directly from the school's official document —
 * do not alter them without an updated official document to match.
 *
 * Run manually via:
 *   php artisan db:seed --class="Modules\DisciplineManagement\Database\Seeders\DisciplineMisconductLevelSeeder"
 */
class DisciplineMisconductLevelSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                "level_number" => 1,
                "level_name" => "Level 1 - Minor Misconduct",
                "nature_of_offence" => "Minor breach of College rules with limited impact",
                "indicative_deduction_min" => 1,
                "indicative_deduction_max" => 3,
                "examples" => "Late arrival\nIncomplete homework\nImproper uniform\nUnnecessary talking\nFailure to bring books/stationery\nMinor classroom disruption",
                "approval_tier" => 1,
            ],
            [
                "level_number" => 2,
                "level_name" => "Level 2 - Repeated Minor Misconduct",
                "nature_of_offence" => "Repeated minor offences or behaviour continuing after warning",
                "indicative_deduction_min" => 4,
                "indicative_deduction_max" => 7,
                "examples" => "Repeated lateness\nRepeated uniform violations\nRepeated classroom disruption\nMisuse of electronic devices",
                "approval_tier" => 2,
            ],
            [
                "level_number" => 3,
                "level_name" => "Level 3 - Moderate Misconduct",
                "nature_of_offence" => "More significant misconduct affecting discipline, learning or College operations",
                "indicative_deduction_min" => 8,
                "indicative_deduction_max" => 15,
                "examples" => "Disrespect towards staff\nLeaving class without permission\nInappropriate language\nRepeated misconduct\nMinor vandalism",
                "approval_tier" => 3,
            ],
            [
                "level_number" => 4,
                "level_name" => "Level 4 - Serious Misconduct",
                "nature_of_offence" => "Serious breach affecting safety, rights, academic integrity, property or College reputation",
                "indicative_deduction_min" => 16,
                "indicative_deduction_max" => 30,
                "examples" => "Bullying\nCyberbullying\nFighting\nTheft\nExamination malpractice\nForgery\nSerious misuse of social media\nVandalism",
                "approval_tier" => 3,
            ],
            [
                "level_number" => 5,
                "level_name" => "Level 5 - Gross Misconduct",
                "nature_of_offence" => "Extremely serious misconduct involving major safety, legal, ethical or institutional concerns",
                "indicative_deduction_min" => 31,
                "indicative_deduction_max" => 50,
                "examples" => "Weapons\nIllegal drugs\nAlcohol\nSerious assault\nSexual harassment\nCriminal conduct or behaviour seriously endangering others",
                "approval_tier" => 3,
            ],
        ];

        foreach ($rows as $row) {
            DisciplineMisconductLevel::updateOrCreate(
                ["level_number" => $row["level_number"]],
                array_merge($row, ["is_active" => true, "created_by" => 1])
            );
        }
    }
}
