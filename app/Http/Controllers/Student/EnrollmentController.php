<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = auth()->user()->enrollments()
            ->with('course.teacher')
            ->latest()->paginate(12);
        return view('student.enrollments.index', compact('enrollments'));
    }

    public function show(Course $course)
    {
        $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();
        abort_unless($enrollment, 403, 'No tienes acceso a este curso.');
        $course->load(['teacher', 'category', 'modules.lessons']);
        return view('student.enrollments.show', compact('course'));
    }
}
