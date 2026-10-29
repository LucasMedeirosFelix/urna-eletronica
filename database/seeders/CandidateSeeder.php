<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        Candidate::firstOrCreate(
            ['number' => '10'],
            ['name' => 'Ana Silva', 'party' => 'Partido A']
        );

        Candidate::firstOrCreate(
            ['number' => '20'],
            ['name' => 'Bruno Souza', 'party' => 'Partido B']
        );

        Candidate::firstOrCreate(
            ['number' => '30'],
            ['name' => 'Carla Santos', 'party' => 'Partido C']
        );
    }
}