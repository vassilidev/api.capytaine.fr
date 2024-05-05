<?php

namespace App\Listeners;

use App\Models\User;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'customer.subscription.updated') {
            /** @var User $customer */
            $customer = User::query()->firstWhere('stripe_id', $event->payload['data']['object']['customer']);

            if (!$customer->hasDefaultPaymentMethod()) {
                $customer->updateDefaultPaymentMethod(
                    $event->payload['data']['object']['default_payment_method']
                );
            }
        }
    }
}
