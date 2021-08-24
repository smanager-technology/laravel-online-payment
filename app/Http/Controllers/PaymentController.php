<?php

namespace App\Http\Controllers;

use App\Exceptions\sManagerPaymentException;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as ViewClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Exception;
use InvalidArgumentException;
use Error;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @param PaymentService $paymentService
     * @return RedirectResponse|void
     * @throws ValidationException
     */
    public function index(Request $request, PaymentService $paymentService)
    {
        // Start DB Transaction
        DB::beginTransaction();

        try {
            $paymentService->validateInsertData($request);

            $name    = $request->input('name');
            $phone   = $request->input('phone');
            $email   = $request->input('email');
            $address = $request->input('address');
            $amount  = $request->input('amount');
            $trnxId  = 'trnx_' . Str::uuid();

            # Insert into `users` table
            $paymentService
                ->saveUser($name, $email, $phone, $address, $amount, $trnxId);

            $info = [
                'amount'          => $amount,
                'transaction_id'  => $trnxId,
                'success_url'     => url('payment/success/' . $trnxId),
                'fail_url'        => route('fail'),
                'customer_name'   => $name,
                'customer_mobile' => $phone,
                'purpose'         => 'Demo Online Payment',
                'payment_details' => 'check sManager Online Payment'
            ];

            $link = $paymentService->initiatePayment($info);
            DB::commit();

            return redirect($link);
        } catch(ValidationException $ex) {
            return Redirect::back()
                ->withErrors($ex->errors())
                ->withInput();
        } catch(QueryException | sManagerPaymentException | Exception $ex) {
            DB::rollBack();

            return Redirect::back()
                ->withErrors([$ex->getMessage()]);
        }
    }

    /**
     * @param PaymentService $paymentService
     * @param string $trnxId
     * @return Application|\Illuminate\Contracts\View\Factory|View|void
     */
    public function success(PaymentService $paymentService, $trnxId = '')
    {
        try {
            if (!$trnxId) {
                if (!ViewClass::exists('failed')) {
                    throw new InvalidArgumentException('View file "failed" not found.');
                }
            }

            if (!$paymentService->trnxDetails($trnxId)) {
                if (!ViewClass::exists('failed')) {
                    throw new InvalidArgumentException('View file "failed" not found.');
                }
            }

            if (!ViewClass::exists('success')) {
                throw new InvalidArgumentException('View file "success" not found.');
            }

            return view('success');
        } catch (InvalidArgumentException | Exception $ex) {
            echo $ex->getMessage() . 'on line ' . $ex->getLine();
        }
    }

    /**
     * @return View
     */
    public function fail(): View
    {
        try {
            if (!ViewClass::exists('failed')) {
                throw new InvalidArgumentException('View file "failed" not found.');
            }
        }  catch (InvalidArgumentException | Error $ex) {
            echo $ex->getMessage() . 'on line ' . $ex->getLine();
        }

        return view('failed');
    }

}
