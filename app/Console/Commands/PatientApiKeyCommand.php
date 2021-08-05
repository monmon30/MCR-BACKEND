<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class PatientApiKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patient:key {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate patient api key.';

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
     * @return string
     */
    public function handle()
    {
        $name = $this->argument('name');
        $key = Crypt::encrypt($name);
        $secret = Hash::make($name);
        $this->info("Patient Key Generated: $key");
        $this->warn("Patient Secret Generated: $secret");
        // $this->error(Hash::check(Crypt::decrypt($key), $secret));
        $this->error(
            Hash::check(Crypt::decrypt(env('PATIENT_KEY')), env('PATIENT_SECRET')) . "GEY",
        );
    }
}
