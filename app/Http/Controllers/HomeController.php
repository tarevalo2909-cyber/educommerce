<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.reports.sales');
        }
        if ($user->isTeacher()) {
            return redirect()->route('teacher.courses.index');
        }
        if ($user->isStudent()) {
            return redirect()->route('student.enrollments.index');
        }
        return redirect()->route('catalog.index');
    }
}
