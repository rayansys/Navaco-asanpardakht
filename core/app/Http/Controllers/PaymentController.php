<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\PaymentProviders\PSP\Payment;
use Illuminate\Support\Facades\DB;
use Validator;

class PaymentController extends Controller
{
    public function callbackPayment(Request $request)
    {

        $rules = [
            '__RequestVerificationToken' => 'required',
            'Data' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            abort(404);
        }
        $data = json_decode($request->Data);

        try {
            DB::beginTransaction();
            $transaction = Transaction::lockForUpdate()->find($request->PaymentID);
            if ($transaction)
			{
                if ($transaction->status && $transaction->verified)
				{
                    return $this->showReceipt($transaction);
                } else if (!$transaction->status && !$transaction->verified && isset($data->ActionCode) && $data->ActionCode == 0 ) {
					$paymentProvider = new Payment();
					$verify = $paymentProvider->verify($data->RRN, $data->PaymentID);

					if ($verify && isset($verify->ActionCode) && isset($verify->Amount) && isset($verify->RRN))
					{
                        if ($verify->ActionCode == 0 && $verify->Amount == $transaction->amount)
						{
                            $transaction->update([
                                'payment_info' => [
                                    'token' 		=> $request->__RequestVerificationToken,
                                    'trans_id' 		=> $data->MessageNumber,
                                    'card_number' 	=> "",
                                    'status' 		=> $verify->ActionCode,
                                ],

                                'status' 		=> 1,
                                'verified' 		=> 1,
                                'paid_at' 		=> date('Y-m-d H:i:s'),
                                'verified_at' 	=> date('Y-m-d H:i:s'),
                            ]);
                            switch ($transaction->type)
							{
                                case Transaction::$type['form']:
                                    $transaction->form()->update(['pay_count' => $transaction->form()->pay_count + 1]);
                                    break;
                                case Transaction::$type['factor']:
                                    $transaction->factor()->update([
                                        'paid' => 1,
                                        'transaction_id' => $transaction->id,
                                    ]);
                                    break;
                            }
                            \DB::commit();

                            return $this->showReceipt($transaction);
                        }
                    }
                }
            }
            DB::rollBack();

            return $this->showReceipt($transaction);
        } catch (\Exception $e) {
            if (env('APP_ENV') === 'local') {
                throw $e;
            } else {
                abort(500);
            }
        }
    }

    public function pay(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $rules = [
            'id' => 'required|exists:transactions,id,status,0,verified,0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            abort(404);
        }

        $transaction = Transaction::find($id);

        return $this->payWithPayment($transaction);
    }

    private function payWithPayment(Transaction $transaction)
    {
        $paymentProvider = new Payment();
        $paymentInfo = $paymentProvider->send($transaction->amount, $transaction->id);
        if (isset($paymentProvider->paymentUrl) && $paymentProvider->paymentUrl) {
            $transaction->update([
                'payment_info' => [
                    'token' => $paymentInfo['token'],
                ],
            ]);

            return redirect($paymentProvider->paymentUrl);
        }

        return redirect()->back()
            ->with('alert', 'danger')
            ->with('message', isset($paymentProvider->errorMessage) ? $paymentProvider->errorMessage : 'Error');
    }

    private function showReceipt(Transaction $transaction)
    {
        return view('home.receipt')
            ->with('transaction', $transaction);
    }
}
