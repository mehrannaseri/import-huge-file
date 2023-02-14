<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileCreatorService
{
    private $number_of_lines;
    /**
     * @var null
     */
    private $content;
    private string $file_path;
    private int $limiter;
    /**
     * @var false
     */
    private bool $divisible;
    private int $counter;

    /**
     * @param $number_of_lines
     */
    public function __construct($number_of_lines)
    {

        $this->number_of_lines = $number_of_lines;
        $this->content = [];
        $this->file_path = config('setting.log_file_path');
        $this->counter = 0;
        $this->divisible = false;
        $this->limiter = 500;
    }

    public function generateContent()
    {
        $i = 0;

        while($i < $this->number_of_lines){
            $this->content[] = $this->createLogLine();
            if($this->counter != 0 && $this->counter % $this->limiter == 0){
                $this->divisible = true;
                $chunk = $this->content;
                $this->content = [];
                yield $chunk;
            }
            $i++;
        }

        //what if the file rows not divisible?
        if(!$this->divisible){
            yield $this->content;
        }
    }

    private function createLogLine()
    {
        $status_codes = collect([201, 422]);
        $services = collect([
            [
                'service-name' => 'order-service',
                'path' => '/orders'
            ],
            [
                'service-name' => 'invoice-service',
                'path' => '/invoices'
            ]
        ]);
        $date = Carbon::now()->addSeconds(rand(1,25));

        $service = $services->random();
        $status_code = $status_codes->random();

        return $service['service-name'] . ' ' . "-" . ' [' . $date->format("d/M/Y:H:i:s") . '] ' . '"' . 'POST ' . $service['path']
            . ' HTTP/1.1' . '" ' . $status_code;
    }

    public function removeOldFile()
    {
        $file_path = storage_path($this->file_path);
        if( file_exists($file_path)){
            unlink($file_path);
        }
    }

    public function createFile($logArr)
    {
        Storage::put('public/logs.txt', implode("\n",$logArr));
    }
}
