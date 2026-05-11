<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')
            ->where('teacher_id', auth()->id())
            ->withCount(['enrollments', 'orders'])
            ->latest()->paginate(12);
        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('teacher.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['teacher_id'] = auth()->id();
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['image'] = $this->handleImage($request);
        $data['is_published'] = $request->boolean('is_published');
        Course::create($data);
        return redirect()->route('teacher.courses.index')->with('success', 'Curso creado.');
    }

    public function edit(Course $course)
    {
        $this->authorizeOwnership($course);
        $categories = Category::orderBy('name')->get();
        $course->load('modules.lessons');
        return view('teacher.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeOwnership($course);
        $data = $this->validateData($request, $course);
        if ($data['title'] !== $course->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $course->id);
        }
        if ($img = $this->handleImage($request)) {
            $data['image'] = $img;
        }
        $data['is_published'] = $request->boolean('is_published');
        $course->update($data);
        return redirect()->route('teacher.courses.index')->with('success', 'Curso actualizado.');
    }

    public function show(Course $course)
    {
        $this->authorizeOwnership($course);
        return redirect()->route('teacher.courses.edit', $course);
    }

    public function destroy(Course $course)
    {
        $this->authorizeOwnership($course);
        $course->delete();
        return back()->with('success', 'Curso eliminado.');
    }

    private function authorizeOwnership(Course $course): void
    {
        abort_unless($course->teacher_id === auth()->id(), 403);
    }

    private function validateData(Request $request, ?Course $course = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:basico,intermedio,avanzado',
            'duration_hours' => 'required|integer|min:0',
            'image_file' => 'nullable|image|max:2048',
        ]);
        unset($data['image_file']);
        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (Course::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }

    private function handleImage(Request $request): ?string
    {
        if ($request->hasFile('image_file')) {
            return $request->file('image_file')->store('courses', 'public');
        }
        return null;
    }
}
