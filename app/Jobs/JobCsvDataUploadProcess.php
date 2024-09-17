<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UploadFileChunk;

class JobCsvDataUploadProcess implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $csvPath = public_path();
        $files = glob("$csvPath/*.csv");
        
        $header = [];
        foreach($files as $key => $file)
        {
            print "$file \n";
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
