<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    ProjectStatus::create(['name' => 'incomplete', 'description' => 'Project is not yet completed']);
    ProjectStatus::create(['name' => 'completed', 'description' => 'Project is completed']);
    ProjectStatus::create(['name' => 'pending', 'description' => 'Project is on hold']);
  }
}
