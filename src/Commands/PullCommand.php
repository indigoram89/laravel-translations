<?php

namespace Indigoram89\Laravel\Translations\Commands;

use Illuminate\Console\Command;
use Indigoram89\Laravel\Translations\Facades\Translations;

class PullCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all translations';

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
        $translations = Translations::driver()->pull();

        Translations::repository()->save($translations);

        $this->info('Completed!');
    }
}
