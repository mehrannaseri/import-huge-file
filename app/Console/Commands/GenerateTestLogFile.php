<?php

namespace App\Console\Commands;

use App\Services\FileCreatorService;
use Illuminate\Console\Command;

class GenerateTestLogFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:generate {numberLines}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate data log file for test';

    protected FileCreatorService $file_creator;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lines = $this->argument('numberLines');

        $this->warn("Creating file, please wait...");

        $this->file_creator = new FileCreatorService($lines);

        $data = $this->file_creator->generateContent();
        $this->file_creator->removeOldFile();

        foreach ($data as $log){
            $this->file_creator->createFile($log);
        }


        $this->info("Log file created successfully");


        return Command::SUCCESS;
    }
}
