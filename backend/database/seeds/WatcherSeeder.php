<?php

use App\Models\Watcher;
use Illuminate\Database\Seeder;

class WatcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Watcher::create([
            Watcher::COL_USER_ID      => 1,
            Watcher::COL_NAME         => 'Age of empires II - price',
            Watcher::COL_URL          => 'https://store.steampowered.com/app/221380/Age_of_Empires_II_2013/',
            Watcher::COL_CSS_SELECTOR => '#game_area_purchase .game_area_purchase_game_wrapper:first-child .game_purchase_price.price',
        ]);
        Watcher::create([
            Watcher::COL_USER_ID      => 1,
            Watcher::COL_NAME         => 'Age of empires II - comments',
            Watcher::COL_URL          => 'https://store.steampowered.com/app/221380/Age_of_Empires_II_2013/',
            Watcher::COL_CSS_SELECTOR => '#user_reviews_filter_score div span b',
        ]);
    }
}
