<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Database\Seeder;

class TriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trigger::create([
            Trigger::COL_WATCHER_ID      => 1,
            Trigger::COL_TRIGGER_TYPE_ID => TriggerType::ID_IS_NOT,
            Trigger::COL_VALUE_TO_MATCH  => '19,99€',
            Trigger::COL_IS_ENABLED      => true,
        ]);
        Trigger::create([
            Trigger::COL_WATCHER_ID      => 2,
            Trigger::COL_TRIGGER_TYPE_ID => TriggerType::ID_IS_NOT,
            Trigger::COL_VALUE_TO_MATCH  => '35,239',
            Trigger::COL_IS_ENABLED      => true,
        ]);
    }
}
