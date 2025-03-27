<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory()->create([
      'name' => 'System User',
      'email' => 'tribesquare@gmail.com',
      'password' => Hash::make('password'),
      'uuid' => Str::uuid()
    ]);
    $this->call([
      CategorySeeder::class,
    ]);
  }
}
