<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConversionRequest;
use App\Models\Conversion;
use App\Services\ConversionService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    protected $paymentService;
    protected $conversionService;

    public function __construct(PaymentService $paymentService, ConversionService $conversionService)
    {
        $this->paymentService = $paymentService;
        $this->conversionService = $conversionService;
    }

    public function index()
    {
        return view('conversion.index');
    }

    public function panel()
    {
        $orders = Conversion::all();
        return view('dashboard', compact('orders'));
    }

    public function conversion(CreateConversionRequest $request)
    {
        $data = $request->validated();
        $response = $this->conversionService->rate($data);

        return view('conversion.index', compact('response'));
    }

    public function pay(CreateConversionRequest $request)
    {
        $data = $request->validated();

        $orderId = Conversion::max('order_id') ? Conversion::max('order_id') + 1 : 1000;

        $order = Conversion::create([
            'order_id' => $orderId,
            'order_date' => now(),
            'from_currency' => $data['from_currency'],
            'to_currency' => $data['to_currency'],
            'from_amount' => $data['from_amount'],
            'to_amount' => $data['to_amount'],
            'status' => 'new',
            'email' => 'datigabashvili@gmail.com',
        ]);

        $link = $this->paymentService->generateLinkManually($order);
        return redirect($link);
    }

    public function approve(Conversion $conversion)
    {

    }

    public function destroy(Conversion $conversion)
    {
        $conversion->delete();
        return redirect()->back();
    }
}
