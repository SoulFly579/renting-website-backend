<?php

namespace App\Jobs;

use App\Mail\InformationMailMakingDeactiveProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InformationMailMakingDeactiveProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ids;

    public $afterCommit = true;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->ids as $id){
            $user = User::where("id",$id["user_id"])->first();
            $product = Product::where("id",$id["id"])->first();
            if($product && $user){
                Mail::to($user->email)->send(new InformationMailMakingDeactiveProduct($product,$user));
            }
        }
    }
}
