<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */

  use WithoutModelEvents;

  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    \App\Models\User::factory()->create([
      'first_name' => 'super',
      'last_name' => 'admin',
      'email' => 'super@gmail.com',
      'email_verified_at' => now(),
      'role' => 'superadmin',
      'password' => bcrypt(123456),
    ]);
  }
}
