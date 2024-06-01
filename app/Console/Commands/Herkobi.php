<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Herkobi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'herkobi';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Herkobi Kurulum';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);
    }
}
