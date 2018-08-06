<?php

namespace Indigoram89\Laravel\Translations\Commands;

use Illuminate\Console\Command;
use Indigoram89\Laravel\Translations\Facades\Translations;

class PushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export new translations';

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
        $translations = Translations::repository()->search();

        $translations = $this->filter($translations);

        Translations::driver()->push($translations);

        $this->info('Completed!');
    }

    public function filter(array $translations) : array
    {
        $exists = Translations::driver()->pull();

        return array_diff_key($translations, $exists);
    }
}
