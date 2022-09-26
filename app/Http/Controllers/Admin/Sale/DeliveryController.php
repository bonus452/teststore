<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
use App\Models\Sale\Delivery;

class DeliveryController extends Controller
{
    public function list()
    {
        $items = (new Delivery())->paginate(12);
        return view('admin.sale.delivery.list', compact('items'));
    }

    public function showFormCreate()
    {
        return view('admin.sale.delivery.create');
    }

    public function create(DeliveryRequest $request){
        $data = $request->validated();
        $delivery = Delivery::create($data);

        return redirect()->route('admin.sale.delivery.update_form',  compact('delivery'))->with(RESULT_MESSAGE, __('success.delivery_created'));
    }

    public function showFormUpdate(Delivery $delivery)
    {
        return view('admin.sale.delivery.edit', compact('delivery'));
    }

    public function update(DeliveryRequest $request, Delivery $delivery){
        $data = $request->validated();
        $delivery->update($data);

        return redirect()
            ->route('admin.sale.delivery.update_form', compact('delivery'))
            ->with(RESULT_MESSAGE, __('delivery_updated'));
    }

    public function delete(Delivery $delivery){
        $delivery->delete();
        return redirect()
            ->route('admin.sale.delivery.list')
            ->with(RESULT_MESSAGE, __('success.delivery_deleted'));
    }

}
