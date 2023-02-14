<?php

namespace App\Services;

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

    public function __construct()
    {
        $this->counter = 0;
        $this->divisible = false;
    }

    public function readFile()
    {

        $data = [];
        $file = fopen(storage_path('app/public/logs.txt') , 'r');

        while(!feof($file)) {
            $this->divisible = false;
            $row = fgets($file);
            $this->counter++;
            $data[] =  $row;
            if($this->counter != 0 && $this->counter % 15 == 0){
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
