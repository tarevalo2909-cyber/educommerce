<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Course $course)
    {
        $this->authorizeOwnership($course);
        $course->load(['modules' => fn($q) => $q->orderBy('position'), 'modules.lessons' => fn($q) => $q->orderBy('position')]);
        return view('teacher.courses.content', compact('course'));
    }

    public function storeModule(Request $request, Course $course)
    {
        $this->authorizeOwnership($course);
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $course->modules()->create([
            'title' => $data['title'],
            'position' => ($course->modules()->max('position') ?? 0) + 1,
        ]);
        return back()->with('success', 'Módulo agregado.');
    }

    public function updateModule(Request $request, Course $course, Module $module)
    {
        $this->authorizeOwnership($course);
        $this->ensureModuleBelongs($course, $module);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'nullable|integer|min:0',
        ]);
        $module->update($data);
        return back()->with('success', 'Módulo actualizado.');
    }

    public function destroyModule(Course $course, Module $module)
    {
        $this->authorizeOwnership($course);
        $this->ensureModuleBelongs($course, $module);
        $module->delete();
        return back()->with('success', 'Módulo eliminado.');
    }

    public function storeLesson(Request $request, Course $course, Module $module)
    {
        $this->authorizeOwnership($course);
        $this->ensureModuleBelongs($course, $module);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
        ]);
        $module->lessons()->create([
            'title' => $data['title'],
            'content' => $data['content'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'position' => ($module->lessons()->max('position') ?? 0) + 1,
        ]);
        return back()->with('success', 'Lección agregada.');
    }

    public function updateLesson(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeOwnership($course);
        $this->ensureModuleBelongs($course, $module);
        $this->ensureLessonBelongs($module, $lesson);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'position' => 'nullable|integer|min:0',
        ]);
        $lesson->update($data);
        return back()->with('success', 'Lección actualizada.');
    }

    public function destroyLesson(Course $course, Module $module, Lesson $lesson)
    {
        $this->authorizeOwnership($course);
        $this->ensureModuleBelongs($course, $module);
        $this->ensureLessonBelongs($module, $lesson);
        $lesson->delete();
        return back()->with('success', 'Lección eliminada.');
    }

    private function authorizeOwnership(Course $course): void
    {
        abort_unless($course->teacher_id === auth()->id(), 403);
    }

    private function ensureModuleBelongs(Course $course, Module $module): void
    {
        abort_unless($module->course_id === $course->id, 404);
    }

    private function ensureLessonBelongs(Module $module, Lesson $lesson): void
    {
        abort_unless($lesson->module_id === $module->id, 404);
    }
}
