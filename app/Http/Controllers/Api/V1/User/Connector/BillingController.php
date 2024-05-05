<?php

namespace App\Http\Controllers\Api\V1\User\Connector;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var Subscription $subscription */
        $subscription = $request->user()->subscriptions()->active()->first();

        $upcomingInvoice = $subscription?->upcomingInvoice();

        $nextPaymentDate = $upcomingInvoice?->date();
        $nextPaymentAmount = $upcomingInvoice?->total();

        $invoices = $request->user()->invoices()->map(function ($invoice) {
            return [
                'id'      => $invoice?->id,
                'date'    => $invoice?->date()->format('d/m/Y'),
                'total'   => $invoice?->total(),
                'status'  => $invoice?->status,
                'url'     => $invoice?->invoice_pdf,
                'product' => $invoice?->lines->data[0]->description,
            ];
        });

        $defaultPaymentMethodID = $request->user()->defaultPaymentMethod()?->id;

        $paymentMethods = $request->user()->paymentMethods()->map(function ($paymentMethod) use ($defaultPaymentMethodID) {

            if ($paymentMethod->type === 'card') {
                return [
                    'id'         => $paymentMethod->id,
                    'brand'      => $paymentMethod->card->brand,
                    'last_four'  => $paymentMethod->card->last4,
                    'expire'     => str_pad($paymentMethod->card->exp_month, 2, '0', STR_PAD_LEFT) . '/' . $paymentMethod->card->exp_year,
                    'is_default' => $defaultPaymentMethodID === $paymentMethod->id,
                ];
            }

            if ($paymentMethod->type === 'paypal') {
                return [
                    'id'         => $paymentMethod->id,
                    'brand'      => 'paypal',
                    'email'      => $paymentMethod->paypal->payer_email,
                    'is_default' => $defaultPaymentMethodID === $paymentMethod->id,
                ];
            }

            return $paymentMethod;
        });

        $data = [
            'invoices'               => $invoices,
            'payment_methods'        => $paymentMethods,
            'current_billing_amount' => $nextPaymentAmount,
            'next_billing_date'      => Carbon::parse($nextPaymentDate),
        ];

        return response()->json($data);
    }
}
