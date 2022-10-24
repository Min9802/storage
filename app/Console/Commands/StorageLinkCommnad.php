<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class StorageLinkCommnad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storagelink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'storage link';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(File::exists(public_path().'/storage')){
            File::delete(public_path().'/storage');
        }
        Artisan::call('storage:link',[]);
        return Command::SUCCESS;
    }
}
