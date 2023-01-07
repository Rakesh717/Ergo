<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Laravel\Jetstream\Contracts\CreatesTeams;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Rakesh Thapa',
                'email' => 'vc76it23@vedascollege.edu.np',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'Sambit Rimal',
                'email' => 'vc76it31@vedascollege.edu.np',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'Utsav Karki',
                'email' => 'vc76it41@vedascollege.edu.np',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
            ],
        ];

        foreach ($users as $user) {
            $user = User::query()->updateOrCreate(
                Arr::only($user, 'email'),
                Arr::except($user, 'email'),
            );

            if ($user->current_team_id) {
                continue;
            }

            app(CreatesTeams::class)->create($user, ['name' => $user->name . '\'s Team']);
        }
    }
}
