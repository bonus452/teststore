<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Sale\Payment;

class PaymentController extends Controller
{
    public function list()
    {
        $items = (new Payment())->paginate(12);
        return view('admin.sale.payment.list', compact('items'));
    }

    public function showFormCreate()
    {
        return view('admin.sale.payment.create');
    }

    public function create(PaymentRequest $request){
        $data = $request->validated();
        $payment = Payment::create($data);

        return redirect()
            ->route('admin.sale.payment.update_form',  compact('payment'))
            ->with(RESULT_MESSAGE, __('success.payment_created'));
    }

    public function showFormUpdate(Payment $payment)
    {
        return view('admin.sale.payment.edit', compact('payment'));
    }

    public function update(PaymentRequest $request, Payment $payment){
        $data = $request->validated();
        $payment->update($data);

        return redirect()
            ->route('admin.sale.payment.update_form', compact('payment'))
            ->with(RESULT_MESSAGE, __('success.payment_updated'));
    }

    public function delete(Payment $payment){
        $payment->delete();
        return redirect()
            ->route('admin.sale.payment.list')
            ->with(RESULT_MESSAGE, __('success.payment_deleted'));
    }
}
