<?php

namespace App\Console\Commands;

use App\Models\Trigger;
use App\Models\User;
use App\Models\Watcher;
use App\Notifications\HitNotify;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class WatcherWatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watcher:watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a scan and then check all enabled trigger of all watchers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Collection|Watcher[] $watchers */
        $watchers = Watcher::with([
            Watcher::REL_TRIGGERS . '.' . Trigger::REL_TRIGGER_TYPE,
            Watcher::REL_USER,
        ])
            ->where(Watcher::COL_IS_SCANNING, true)
            ->get();

        foreach ($watchers as $watcher) {
            $scan = $watcher->makeScan();

            $hits = $watcher->checkTriggers($scan);

            foreach ($hits as $hit) {
                /** @var User $user */
                $user = $watcher->{Watcher::REL_USER};

                $user->notify(new HitNotify($hit));
            }
        }
    }
}
