<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('ChangeMe!123456'),
                'email_verified_at' => now(),
            ],
        );

        $team = Team::firstOrCreate([
            'name' => 'Default',
            'personal_team' => false,
        ], ['user_id' => $admin->id]);

        $admin->forceFill(['current_team_id' => $team->id])->save();
        $admin->teams()->syncWithoutDetaching([$team->id]);
    }
}
