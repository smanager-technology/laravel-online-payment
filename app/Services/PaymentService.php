<?php

namespace App\Services;

use App\Exceptions\sManagerPaymentException;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    public function validateInsertData($request)
    {
        # Input Validation
        $rules = [
            'name'    => 'required',
            'email'   => 'nullable|email',
            'phone'   => 'required|min:11|regex:/\+?(88)?0?1[3456789][0-9]{8}\b/',
            'address' => 'nullable',
            'amount'  => 'required|numeric|gte:10|lt:500000'
        ];

        $messages = [
            'name.required'   => 'Please provide your name.',
            'email.email'     => 'Please provide a valid Email Address.',
            'phone.required'  => 'Please provide your Phone Number.',
            'phone.min'       => 'Please provide your Phone Number.',
            'phone.regex'     => 'Please provide a valid Bangladeshi Phone Number',
            'amount.required' => 'Please provide amount.',
            'amount.numeric'  => 'Please provide a valid amount.',
            'amount.gte'      => 'Amount must be greater than or equal 10.',
            'amount.lt'       => 'Amount must be less than 500000'
        ];

        $request
            ->validate($rules, $messages);
    }

    public function saveUser($name, $email, $phone, $address, $amount, $trnxId)
    {
        $user  = new User;

        $user->name    = $name;
        $user->email   = $email;
        $user->phone   = $phone;
        $user->address = $address;
        $user->amount  = $amount;
        $user->trnxId  = $trnxId;

        $user->save();
    }

    /**
     * @param $data
     * @return string
     * @throws sManagerPaymentException
     */
    public function initiatePayment($data): string
    {
        $url = env('PL_URL') . '/v1/ecom-payment/initiate';

        $responsejSON = Http::withHeaders([
            'client-id'     => env('PL_CLIENT_ID'),
            'client-secret' => env('PL_CLIENT_SECRET')
        ])->post($url, $data)->object();

        $code    = $responsejSON->code;
        $message = $responsejSON->message;

        if ($code !== 200) {
            throw new sManagerPaymentException($message);
        }

        return $responsejSON->data->link;
    }

    /**
     * @param $trnxId
     * @return bool
     */
    public function trnxDetails($trnxId): bool
    {
        $url = env('PL_URL') . '/v1/ecom-payment/details';

        $responsejSON = Http::withHeaders([
            'client-id'     => env('PL_CLIENT_ID'),
            'client-secret' => env('PL_CLIENT_SECRET')
        ])->get($url, [
            'transaction_id'   => $trnxId,
        ])->object();

        $code    = $responsejSON->code;
        $message = $responsejSON->message;

        if ($code !== 200) {
            throw new sManagerPaymentException($message);
        }

        # Check if the transaction is completed
        $paymentStatusFromApi = $responsejSON->data->payment_status;
        if ($paymentStatusFromApi !== 'completed') {
            return false;
        }

        return true;
    }

}
