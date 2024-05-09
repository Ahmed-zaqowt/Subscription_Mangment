<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\SMS;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

use function PHPUnit\Framework\isEmpty;

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

        $expiredSubscriptions = Subscription::where('status', Subscription::ACCEPTED)
            ->get();

        $expiredSubscriptionsTomorrow = Subscription::where('status', Subscription::ACCEPTED)
            ->whereDate('end', Carbon::tomorrow())
            ->get();


        if ($expiredSubscriptionsTomorrow->isNotEmpty()) {
            foreach ($expiredSubscriptionsTomorrow as $subscription) {
                    Controller::sendSMS($subscription->user->mobile , env('APP_NAME') , SMS::EXPIRED_USER_MESSAGE , null , null , $subscription->end );

                    Controller::sendSMS($subscription->subscriber->mobile , env('APP_NAME') , SMS::EXPIRED_USER_MESSAGE , null , null , $subscription->end );

            }
        }


        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update([
                'status' => Subscription::EXPIRED,
            ]);
        }

    }
}
