<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boards = [
            [
                'name' => 'Course - SAD',
                'owner' => 'vc76it23@vedascollege.edu.np',
            ],
            [
                'name' => 'Course - Cryptography',
                'owner' => 'vc76it23@vedascollege.edu.np',
            ],
            [
                'name' => 'Course - DAA',
                'owner' => 'vc76it31@vedascollege.edu.np',
            ],
            [
                'name' => 'Course - Simulation',
                'owner' => 'vc76it41@vedascollege.edu.np',
            ],
        ];

        foreach ($boards as $board) {
            $team = User::query()->where('email', $board['owner'])
                ->firstOr(fn () => User::factory()->create(['email' => $board['owner']]))
                ->currentTeam;

            $board = Board::query()->updateOrCreate([
                'name' => $board['name'],
                'team_id' => $team->id,
            ]);

            $board->sections()->createMany([
                [
                    'name' => 'Todo',
                ],
                [
                    'name' => 'In Progress',
                ],
                [
                    'name' => 'Complete',
                ],
            ]);
        }
    }
}
