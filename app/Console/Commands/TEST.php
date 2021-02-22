<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\Memevui\Meme_;
use App\Actions\Memevui\Meme2;
use App\Models\Meme;
use App\Actions\Imgur\Imgur;

class TEST extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:now {--page=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $page = (int) $this->option('page');
        if(empty($page)) {
            $page = 20;
        }
        for ($i= $page + 1; $i > 0 ; $i--) {
            $this->info($i);
            (new Meme2())->run($page);
            $this->info('+ OK');
        }
    }
}
