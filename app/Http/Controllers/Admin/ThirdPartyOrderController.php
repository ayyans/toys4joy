<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ThirdPartyOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ThirdPartyOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ThirdPartyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? now();

        $thirdPartyOrders = ThirdPartyOrder::query()
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get();

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new ThirdPartyOrdersExport($thirdPartyOrders), 'third-party-orders-report.xlsx');
        }

        return view('admin.third-party-orders.index', compact('thirdPartyOrders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.third-party-orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validated( $request );

        $thirdPartyOrder = ThirdPartyOrder::create( $data );

        $thirdPartyOrder->product()->decrement('qty', $data['quantity']);

        return redirect()->route('admin.third-party-orders.index')->with('success', 'Third Party Order Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThirdPartyOrder  $thirdPartyOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ThirdPartyOrder $thirdPartyOrder)
    {
        return view('admin.third-party-orders.edit', compact('thirdPartyOrder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThirdPartyOrder  $thirdPartyOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThirdPartyOrder $thirdPartyOrder)
    {
        $data = $this->validated( $request );

        $quantity = $thirdPartyOrder->product->qty
            + $thirdPartyOrder->quantity - $data['quantity'];

        $thirdPartyOrder->update( $data );

        $thirdPartyOrder->product()->update([ 'qty' => $quantity ]);

        return redirect()->route('admin.third-party-orders.index')->with('success', 'Third Party Order Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThirdPartyOrder  $thirdPartyOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThirdPartyOrder $thirdPartyOrder)
    {
        $quantity = $thirdPartyOrder->quantity;

        $thirdPartyOrder->delete();

        $thirdPartyOrder->product()->increment('qty', $quantity);

        return redirect()->back()->with('success', 'Third Party Order Deleted');
    }

    /**
     * Get the specified resource from request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function search2ProductSearch(Request $request)
    {
        $search = $request->search;
        $page = $request->page;
        $perPage = 10;

        $products = Product::where(function($query) use ($search) {
            $query->where('sku', 'LIKE', "%$search%")
                ->orWhere('barcode', 'LIKE', "%$search%")
                ->orWhere('title', 'LIKE', "%$search%");
        })->get();

        $result = $products->forPage($page, $perPage)->map(function($product) {
            return [
                'id' => $product->sku,
                'text' => $product->title,
            ];
        })->values();

        return response()->json([
            'results' => $result,
            'pagination' => [
                'more' =>  $products->forPage($page+1, $perPage)->count() //($page * $perPage) < $products->count()
            ]
        ]);
    }

    /**
     * Validate the specified resource from request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validated(Request $request)
    {
        return $request->validate([
            'channel' => ['required'],
            'order_number' => ['required'],
            'sku' => ['required', 'exists:products,sku'],
            'quantity' => ['required', 'min:0']
        ]);
    }
}
