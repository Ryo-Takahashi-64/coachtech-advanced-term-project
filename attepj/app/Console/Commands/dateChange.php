<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dateChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dateChange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '日付変更時に勤怠情報を更新';

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
     * @return int
     */
    public function handle()
    {
        logger('test');
    }
}
