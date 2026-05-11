<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['course.teacher', 'paymentProof', 'reviewer'])
            ->where('student_id', auth()->id())
            ->latest()->paginate(15);
        return view('student.orders.index', compact('orders'));
    }

    public function create(Course $course)
    {
        abort_unless($course->is_published, 404);

        if (auth()->user()->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.enrollments.show', $course->slug)
                ->with('success', 'Ya estás inscrito en este curso.');
        }
        $existingPending = Order::where('student_id', auth()->id())
            ->where('course_id', $course->id)
            ->where('status', Order::STATUS_PENDING)->first();
        if ($existingPending) {
            return redirect()->route('student.orders.index')
                ->with('error', 'Ya tienes una orden pendiente para este curso.');
        }

        return view('student.orders.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        abort_unless($course->is_published, 404);

        $data = $request->validate([
            'bank' => 'required|string|max:100',
            'operation_number' => 'required|string|max:100',
            'payment_date' => 'required|date',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3072',
        ]);

        DB::transaction(function () use ($data, $course, $request) {
            $order = Order::create([
                'student_id' => auth()->id(),
                'course_id' => $course->id,
                'amount' => $course->price,
                'status' => Order::STATUS_PENDING,
            ]);
            $path = $request->file('proof')->store('comprobantes', 'public');
            $order->paymentProof()->create([
                'file_path' => $path,
                'bank' => $data['bank'],
                'operation_number' => $data['operation_number'],
                'payment_date' => $data['payment_date'],
            ]);
        });

        return redirect()->route('student.orders.index')
            ->with('success', 'Comprobante enviado. Quedará pendiente hasta que el administrador lo apruebe.');
    }
}
