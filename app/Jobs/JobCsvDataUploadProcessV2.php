<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UploadFileChunk;

class JobCsvDataUploadProcessV2 implements ShouldQueue
{
    use Queueable;

    public $data;
    public $header;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $header)
    {
        //
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        
        foreach($this->data as $d){
            $saveData = array_combine($this->header, $d);
            UploadFileChunk::create($saveData);
        }

    }
}
