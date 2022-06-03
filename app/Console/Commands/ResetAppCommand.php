<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use RedisDB;

class ResetAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset app state';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->task('Reset DB', fn() => Artisan::call('migrate:fresh --seed'));
        $this->task('Reset Redis', fn() => RedisDB::client()->flushAll());
        return 0;
    }
}
