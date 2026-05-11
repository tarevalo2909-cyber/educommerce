<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['student', 'course.teacher', 'paymentProof', 'reviewer']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($q = $request->input('q')) {
            $query->whereHas('student', fn($s) => $s->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"))
                ->orWhereHas('course', fn($c) => $c->where('title', 'like', "%{$q}%"));
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['student', 'course.teacher', 'paymentProof', 'reviewer']);
        return view('admin.orders.show', compact('order'));
    }

    public function approve(Order $order)
    {
        if (!$order->isPending()) {
            return back()->with('error', 'La orden ya fue revisada.');
        }
        DB::transaction(function () use ($order) {
            $order->update([
                'status' => Order::STATUS_APPROVED,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ]);
            Enrollment::firstOrCreate(
                ['student_id' => $order->student_id, 'course_id' => $order->course_id],
                ['order_id' => $order->id]
            );
        });
        return back()->with('success', 'Comprobante aprobado y curso habilitado para el estudiante.');
    }

    public function reject(Request $request, Order $order)
    {
        if (!$order->isPending()) {
            return back()->with('error', 'La orden ya fue revisada.');
        }
        $data = $request->validate(['rejection_reason' => 'required|string|max:500']);
        $order->update([
            'status' => Order::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $data['rejection_reason'],
        ]);
        return back()->with('success', 'Comprobante rechazado.');
    }
}
