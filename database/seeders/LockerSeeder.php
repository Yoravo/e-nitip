<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locker;

class LockerSeeder extends Seeder
{
    public function run()
    {
        $rows = range('A', 'J');
        $columns = range(1, 10);

        foreach ($rows as $row) {
            foreach ($columns as $col) {
                Locker::create([
                    'locker_code' => "{$row}-{$col}",
                    'is_available' => true, // All lockers available by default
                ]);
            }
        }
    }
}
