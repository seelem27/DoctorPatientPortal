<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['id' => 1,  'email' => 'admin@gmail.com', 'password' => '$2y$10$er5358zLagPnjJlmxstLYuWBd.jJzTwE6sVzeXNSm96RQAgqLXoi2', 'role_id' => 1, 'remember_token' => '',],
        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
