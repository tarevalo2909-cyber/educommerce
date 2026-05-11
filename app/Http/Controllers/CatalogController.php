<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['teacher', 'category'])->where('is_published', true);

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }
        if ($level = $request->input('level')) {
            $query->where('level', $level);
        }

        $courses = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        abort_unless($course->is_published, 404);
        $course->load(['teacher', 'category', 'modules.lessons']);
        return view('catalog.show', compact('course'));
    }
}
