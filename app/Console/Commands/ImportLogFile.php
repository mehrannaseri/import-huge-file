<?php

namespace App\Console\Commands;

use App\Services\FileReaderService;
use App\Services\LogService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportLogFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:log-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read and Import log file into database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $start_time = time();

            $this->alert("Importing file started, please wait...");

            $file_reader = new FileReaderService();
            $log_data = $file_reader->readFile();

            $logService = new LogService();

            foreach ($log_data as $log){
                $logService->store($log);
            }
            $end_time = time();

            $this->info("--- The file imported successfully --- \n
                Execution time : ".$end_time - $start_time." Second(s) \n
                The memory usage : ". formatBytes(memory_get_peak_usage()). "\n"
            );
            return Command::SUCCESS;
        }
        catch (Exception $exception){
            $this->error($exception->getMessage()."\n");
            return Command::FAILURE;
        }

    }
}
