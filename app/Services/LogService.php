<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Carbon;

class LogService
{
    /**
     * store data on logs table
     * @param $dataArr
     * @return bool
     */
    public function store($dataArr) :bool
    {
        $data = $this->prepareDataForDB($dataArr);
        Log::insert($data);

        return true;
    }


    public function show($request)
    {
        return Log::filter($request)->count();
    }

    /**
     * prepare data for insert on database
     * @param $dataArr
     * @return array
     */
    private function prepareDataForDB($dataArr) :array
    {
        $clean_data = [];
        foreach ($dataArr as $data){
            if($data != ''){
                $data = str_replace("\"", "", $data);
                $data = explode(' ', $data);
                $clean_data[] = [
                    'service_name' => $data[0],
                    'date' => $this->cleanDate($data[2]),
                    'status_code' => (int)$data[6],
                    'uri' => $data[4],
                    'method' => $data[3],
                    'http_version' => $data[5]
                ];
            }
        }

        return $clean_data;


    }

    /**
     * clean and format date record
     * @param $date
     * @return string
     */
    private function cleanDate($date) :string
    {
        $date = str_replace(['[', ']'], '',$date);
        $date = preg_replace('/:/', ' ', $date, 1);
        $date = preg_replace('/\//', '-', $date);
        return Carbon::createFromDate($date)->format('Y-m-d H:i:s');
    }
}
