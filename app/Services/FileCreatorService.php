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

    /**
     * @param $number_of_lines
     */
    public function __construct($number_of_lines)
    {

        $this->number_of_lines = $number_of_lines;
        $this->content = null;
        $this->file_path = config('setting.log_file_path');
    }

    public function generateContent()
    {

        for($i = 0; $i <= $this->number_of_lines; $i++){
            $this->content .= $this->createLogLine();
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
            . ' HTTP/1.1' . '" ' . $status_code."\n";
    }

    public function removeOldFile()
    {
        $file_path = storage_path($this->file_path);
        if( file_exists($file_path)){
            unlink($file_path);
        }
    }

    public function createFile()
    {
        Storage::append('public/logs.txt', $this->content);
    }
}
