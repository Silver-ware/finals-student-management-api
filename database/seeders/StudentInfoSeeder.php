<?php

namespace Database\Seeders;

use App\Models\StudentInfo;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentInfo::factory(10)->create();
    }
}
