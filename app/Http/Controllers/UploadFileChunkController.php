<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadFileChunk;
use App\Jobs\JobCsvDataUploadProcess;
use App\Jobs\JobCsvDataUploadProcessV2;
use App\Jobs\JobUploadFileDataProcess;
use App\Jobs\JobBatchUploadFileDataProcess;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;


class UploadFileChunkController extends Controller
{
    //
    public function UploadFile(Request $request){
        if(request()->has('csvFile')){

            //$data = array_map('str_getcsv', file(request()->csvFile));

            $data = file(request()->csvFile);
            // $header = $data[0];
            // unset($data[0]);

            // chunking file
            $chunks = array_chunk($data, 20000);
            //echo count($chunks); exit;

            $csvPath = public_path();            


            foreach($chunks as $key => $chunks){
                $tmpName = "tmp{$key}.csv";
                file_put_contents($csvPath.'/'.$tmpName, $chunks);
            }

            // foreach($data as $key => $value){
            //     $saveData = array_combine($header, $value);                
            //     UploadFileChunk::create($saveData);
            // }

            //$this->storeData();
        }
    }

    public function storeData()
    {

        $csvPath = public_path();
        $files = glob("$csvPath/*.csv");
        
        $header = [];
        foreach($files as $key => $file)
        {
            print "$file<br/>";
            $data = array_map('str_getcsv', file($file));
            if($key === 0)
            {
                $header = $data[0];
                unset($data[0]);
            }

            foreach($data as $d){
                $saveData = array_combine($header, $d);
                UploadFileChunk::create($saveData);
            }

            unlink($file);
        }

    }

    public function JobStoreData()
    {                
        JobCsvDataUploadProcess::dispatch();
    }

    public function storeDataV2()
    {

        $csvPath = public_path();
        $files = glob("$csvPath/*.csv");
        
        $header = [];
        foreach($files as $key => $file)
        {
            $data = array_map('str_getcsv', file($file));
            if($key === 0)
            {
                $header = $data[0];
                unset($data[0]);
            }
            print "$file<br/>";
            JobCsvDataUploadProcessV2::dispatch($data, $header);

            unlink($file);
        }

    }

    public function oneUploaData()
    {


        if(request()->has('csvFile')){

            $data = file(request()->csvFile);
            $chunks = array_chunk($data, 20000);

            $csvPath = public_path();            


            foreach($chunks as $key => $chunks){
                $tmpName = "tmp{$key}.csv";
                file_put_contents($csvPath.'/'.$tmpName, $chunks);
            }
            
            $files = glob("$csvPath/*.csv");
            
            $header = [];
            foreach($files as $key => $file)
            {
                print "$file<br/>";
                $data = array_map('str_getcsv', file($file));
                if($key === 0)
                {
                    $header = $data[0];
                    unset($data[0]);
                }

                foreach($data as $d){
                    $saveData = array_combine($header, $d);
                    UploadFileChunk::create($saveData);
                }

                unlink($file);
            }
        }
    }

    public function uploaFileData()
    {

        if(request()->has('csvFile')){

            $data = file(request()->csvFile);
            $chunks = array_chunk($data, 20000);

            $csvPath = public_path();            


            foreach($chunks as $key => $chunks){
                $tmpName = "tmp{$key}.csv";
                file_put_contents($csvPath.'/'.$tmpName, $chunks);
            }
            
            $files = glob("$csvPath/*.csv");
            
            $header = [];
            foreach($files as $key => $file)
            {
                print "$file<br/>";
                $data = array_map('str_getcsv', file($file));
                if($key === 0)
                {
                    $header = $data[0];
                    unset($data[0]);
                }

                foreach($data as $d){
                    $saveData = array_combine($header, $d);
                    UploadFileChunk::create($saveData);
                }

                unlink($file);
            }
        }
    }

    public function uploadFileProcess()
    {
        if(request()->has('csvFile')){
            $data = file(request()->csvFile);
            $chunks = array_chunk($data, 20000);

            $header = [];
            foreach($chunks as $key => $chunk)
            {
                $data = array_map('str_getcsv', $chunk);
                
                if($key === 0)
                {
                    $header = $data[0];
                    unset($data[0]);
                }

                JobUploadFileDataProcess::dispatch($data, $header);

            }
        }
    }

    public function BatchUploadFileProcess()
    {
        if(request()->has('csvFile')){
            $data = file(request()->csvFile);
            $chunks = array_chunk($data, 10000);

            $header = [];
            $batch = Bus::batch([])->dispatch();

            foreach($chunks as $key => $chunk)
            {
                $data = array_map('str_getcsv', $chunk);
                
                if($key === 0)
                {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new JobBatchUploadFileDataProcess($data, $header));

            }
        }
        //redirect('/get-batch-uploaded?id='.$batch->id);
        return $batch;
    }

    public function getBatchUploaded()
    {
       $batchId = request('id');
       return Bus::findBatch($batchId);
    }

    public function getInProgressJob()
    {
        $batches = DB::table('job_batches')->where('pending_jobs' , ">", "0")->get();
        if(count($batches) > 0)
        {
            return Bus::findBatch($batches[0]->id);
        }
        return [];
    }
}

