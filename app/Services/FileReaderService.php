<?php

namespace App\Services;

use Exception;
use Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FileReaderService
{
    /**
     * @var int
     * for limit chunk data
     */
    private int $counter;



    /**
     * @var false
     */
    private bool $divisible;


    /**
     * @var int
     */
    private int $limiter;
    private string $file_path;

    public function __construct()
    {
        $this->counter = 0;
        $this->divisible = false;
        $this->limiter = 500;
        $this->file_path = config('setting.log_file_path');
    }

    /**
     * get and read file
     * @return Generator
     * @throws Exception
     */
    public function readFile() :Generator
    {
        $file_path = storage_path($this->file_path);
        if(! file_exists($file_path)){
            throw new Exception('file does not exists');
        }
        $data = [];
        $file = fopen( $file_path, 'r');

        while(!feof($file)) {
            $this->divisible = false;
            $row = fgets($file);
            $this->counter++;
            $data[] =  $row;
            if($this->counter != 0 && $this->counter % $this->limitter == 0){
                $this->divisible = true;
                $chunk = $data;
                $data = [];
                yield $chunk;
            }
        }

        if(!$this->divisible){
            yield $data;
        }
        fclose($file);
    }
}
