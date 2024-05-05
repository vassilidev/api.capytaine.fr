<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscribeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $plan, $period)
    {
        if (array_key_exists($plan, $planConfig = config('cashier.plans'))) {
            $planConfig = $planConfig[$plan];
        } else {
            Log::warning('Plan not found', ['plan' => $plan]);

            return redirect()->back();
        }

        if (!in_array($period, ['monthly', 'yearly'])) {
            Log::warning('Invalid period', ['period' => $period]);

            return redirect()->back();
        }

        $user = $request->user();
        $price = $planConfig['prices'][$period];

        if (!$price) {
            Log::warning('Price not found', ['plan' => $plan, 'period' => $period]);

            return redirect()->back();
        }

        $subscriptionRequest = $user
            ->newSubscription($plan, $price)
            ->allowPromotionCodes();

        if (array_key_exists('trial_days', $planConfig)) {
            $subscriptionRequest->trialDays($planConfig['trial_days']);
        }

        return $subscriptionRequest->checkout([
            'success_url' => url()->previous() . '/account/billing?subscribe=1',
            'cancel_url'  => url()->previous(),
        ]);
    }
}
