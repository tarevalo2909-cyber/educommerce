<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : Carbon::now()->subYear()->startOfDay();
        $to = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : Carbon::now()->endOfDay();

        $baseQuery = Order::where('status', Order::STATUS_APPROVED)
            ->whereBetween('created_at', [$from, $to]);

        $topCourses = (clone $baseQuery)
            ->select('course_id', DB::raw('COUNT(*) as sales_count'), DB::raw('SUM(amount) as revenue'))
            ->groupBy('course_id')
            ->orderByDesc('sales_count')
            ->with('course')
            ->limit(10)->get();

        $monthly = (clone $baseQuery)
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"), DB::raw('SUM(amount) as revenue'), DB::raw('COUNT(*) as sales'))
            ->groupBy('ym')->orderBy('ym')->get();

        $totalRevenue = (clone $baseQuery)->sum('amount');
        $totalSales = (clone $baseQuery)->count();

        $chartTopLabels = $topCourses->map(fn($r) => $r->course ? $r->course->title : 'Curso eliminado')->values();
        $chartTopData = $topCourses->pluck('sales_count')->values();

        $chartMonthlyLabels = $monthly->pluck('ym')->values();
        $chartMonthlyRevenue = $monthly->pluck('revenue')->values();
        $chartMonthlySales = $monthly->pluck('sales')->values();

        return view('admin.reports.sales', compact(
            'from', 'to', 'topCourses', 'monthly', 'totalRevenue', 'totalSales',
            'chartTopLabels', 'chartTopData',
            'chartMonthlyLabels', 'chartMonthlyRevenue', 'chartMonthlySales'
        ));
    }

    public function pending()
    {
        $pendingOrders = Order::with(['student', 'course.teacher', 'paymentProof'])
            ->where('status', Order::STATUS_PENDING)
            ->oldest()->get();

        $counts = Order::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        $pendingCount = $counts['pending'] ?? 0;
        $approvedCount = $counts['approved'] ?? 0;
        $rejectedCount = $counts['rejected'] ?? 0;

        return view('admin.reports.pending', compact(
            'pendingOrders', 'pendingCount', 'approvedCount', 'rejectedCount'
        ));
    }

    public function users()
    {
        $byAdmin = Order::select('reviewed_by',
                DB::raw("SUM(CASE WHEN status='approved' THEN 1 ELSE 0 END) as approved"),
                DB::raw("SUM(CASE WHEN status='rejected' THEN 1 ELSE 0 END) as rejected"))
            ->whereNotNull('reviewed_by')
            ->groupBy('reviewed_by')
            ->with('reviewer')->get();

        $totalUsers = User::count();
        $totalStudents = User::role('estudiante')->count();
        $totalTeachers = User::role('profesor')->count();
        $totalAdmins = User::role('admin')->count();

        $approvedGlobal = Order::where('status', Order::STATUS_APPROVED)->count();
        $rejectedGlobal = Order::where('status', Order::STATUS_REJECTED)->count();
        $totalReviewed = $approvedGlobal + $rejectedGlobal;
        $approvalRate = $totalReviewed > 0 ? round(($approvedGlobal / $totalReviewed) * 100, 1) : 0;

        $chartAdminLabels = $byAdmin->map(fn($r) => $r->reviewer ? $r->reviewer->name : 'N/A')->values();
        $chartAdminApproved = $byAdmin->pluck('approved')->values();
        $chartAdminRejected = $byAdmin->pluck('rejected')->values();

        return view('admin.reports.users', compact(
            'byAdmin', 'totalUsers', 'totalStudents', 'totalTeachers', 'totalAdmins',
            'approvedGlobal', 'rejectedGlobal', 'approvalRate',
            'chartAdminLabels', 'chartAdminApproved', 'chartAdminRejected'
        ));
    }
}
