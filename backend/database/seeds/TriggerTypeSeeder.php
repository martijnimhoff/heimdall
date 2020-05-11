<?php

use App\Models\TriggerType;
use Illuminate\Database\Seeder;

class TriggerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $triggerTypes = [
            [TriggerType::COL_NAME => 'Is'],
            [TriggerType::COL_NAME => 'Is not'],
            [TriggerType::COL_NAME => 'Contains'],
            [TriggerType::COL_NAME => 'Does not contain'],
        ];

        foreach ($triggerTypes as $triggerType) {
            TriggerType::create($triggerType);
        }
    }
}
