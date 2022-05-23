<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\gc_product_item;
use Illuminate\Support\Facades\Redis;

class ProcessItemUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $file)
    {
        //
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('upload-item-csv')->allow(1)->every(10)->then(function(){

            dump('uploading file...:', $this->file);
            $data =  array_map('str_getcsv', file($this->file));

            foreach($data as $row){
                // dd($row);
                gc_product_item::updateorCreate([
                    'itemcode' => $row[0],
                    'product_name' => $row[1]
                ]);
                
            }
            dump('done uploading file...:', $this->file);
            
            unlink($this->file);
            
        }, function(){
            return $this->release(10);
        });


    }
}
