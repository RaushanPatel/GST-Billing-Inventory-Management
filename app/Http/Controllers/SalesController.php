<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function showSales()
    {
        // Total Sale for each day (sum of grand_total per day)
        $dailySales = Bill::select(DB::raw('DATE(bills.created_at) as date'), DB::raw('SUM(bills.grand_total) as total_sale'))
            ->groupBy(DB::raw('DATE(bills.created_at)'))
            ->get();

        // Total Sale for each month (sum of grand_total per month)
        $monthlySales = Bill::select(DB::raw('MONTHNAME(bills.created_at) as month'), DB::raw('SUM(bills.grand_total) as total_sale'))
            ->groupBy(DB::raw('MONTHNAME(bills.created_at)'))
            ->orderBy(DB::raw('MONTH(bills.created_at)')) // Ordering by month
            ->get();

        // Application with the most sales (sum of grand_total per application)
        $topApplication = Application::with(['bills' => function ($query) {
            $query->selectRaw('application_id, SUM(grand_total) as total_sales')
                ->groupBy('application_id');
        }])->get()
        ->sortByDesc(fn($application) => $application->bills->sum('total_sales'))
        ->first();

        return view('sales', compact('dailySales', 'monthlySales', 'topApplication'));
    }
}