<?php

namespace App\Console\Commands;

use App\Models\DevCodes;
use Illuminate\Console\Command;

class CreateDevCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createdevcodes {num}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new dev codes to be used';

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
        for ($x = 0; $x < $this->argument("num"); $x++)
        {
            DevCodes::create([
                "code" => $this->genCode(),
            ]);
        }
    }

    /**
     * Generates and returns a random string
     *
     * @return string
     */
    protected function genCode() : string
    {
        return bin2hex(random_bytes(10));
    }
}
