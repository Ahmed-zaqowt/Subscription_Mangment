<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSubscriptionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription status';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
       // ابحث عن الاشتراكات التي انتهت
        $expiredSubscriptions = Subscription::
        where('status' , Subscription::ACCEPTED)
        ->where('end', '<', Carbon::now())->get();

        // قم بتحديث حالة الاشتراكات المنتهية
       foreach ($expiredSubscriptions as $subscription) {
            $subscription->update([
               'status' => Subscription::EXPIRED ,
            ]);
        }

       // echo $expiredSubscriptions->count();
    }
}
