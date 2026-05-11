<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();

        $orders = Order::with(['student', 'course'])
            ->whereHas('course', fn($q) => $q->where('teacher_id', $teacherId))
            ->where('status', Order::STATUS_APPROVED)
            ->latest()->paginate(15);

        $totalRevenue = Order::whereHas('course', fn($q) => $q->where('teacher_id', $teacherId))
            ->where('status', Order::STATUS_APPROVED)
            ->sum('amount');

        $totalSales = Order::whereHas('course', fn($q) => $q->where('teacher_id', $teacherId))
            ->where('status', Order::STATUS_APPROVED)
            ->count();

        return view('teacher.sales.index', compact('orders', 'totalRevenue', 'totalSales'));
    }
}
