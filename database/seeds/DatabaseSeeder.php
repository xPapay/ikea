<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => 'Lukas Papay', 'email' => 'papay.lukas@gmail.com', 'password' => bcrypt('heslo')]);
        $user2 = User::create(['name' => 'Jan Novak', 'email' => 'novak@gmail.com', 'password' => bcrypt('heslo')]);
        $user3 = User::create(['name' => 'Peter Slovak', 'email' => 'slovak@gmail.com', 'password' => bcrypt('heslo')]);
        $task = Task::create(['name' => 'Uloha ' . time(), 'description' => 'Some desc...', 'deadline' => '19. 08. 2016']);
        $user->orderTask($task, [$user2->id, $user3->id],[]);
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
