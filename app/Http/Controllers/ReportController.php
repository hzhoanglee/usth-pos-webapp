<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;

class ReportController extends Controller
{
    // public function generateReport(Request $request)
    // {
    //     // retrieve data
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     // Filter based on time
    //     $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

    //     // Count number of orders
    //     $totalOrders = $orders->count();

    //     // Sum total revenue
    //     $totalRevenue = $orders->sum('total_amount');

    //     // Total tax
    //     $totalTax = $orders->sum('tax_amount');

    //     // Return
    //     $htmlContent = '<h1>Report from ' . $startDate . ' to ' . $endDate . '</h1>';
    //     $htmlContent .= '<p>Total Orders: ' . $totalOrders . '</p>';
    //     $htmlContent .= '<p>Total Revenue: ' . $totalRevenue . '</p>';
    //     $htmlContent .= '<p>Total Tax: ' . $totalTax . '</p>';

    //     return response()->json(['html' => $htmlContent]);
    // }

    private function listOrder() {
        // $orders = Order::where('created_at', '<=', Carbon::now()->format('Y-m-d'))->get();
        $orders = Order::all();
        return $orders;
    }

    public function getOrderList() {
        $orders = $this->listOrder();
        return response()->json($orders);
    }
}
