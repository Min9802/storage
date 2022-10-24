<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Laravel\Passport\ClientRepository;

class GenerateClientPassport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:passport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Client Passport';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clientRepo =  App::make(ClientRepository::class);
        $client = $clientRepo->create(1, "Storage", '',"users",true, true);
        $client_id = $client->id;
        $client_Secret = $client->secret;
        $this->info("client_id: " . $client_id);
        $this->info("client_Secret: " . $client_Secret);
        return Command::SUCCESS;
    }
}
