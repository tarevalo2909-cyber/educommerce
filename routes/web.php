<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\EnrollmentController as StudentEnrollmentController;
use App\Http\Controllers\Student\OrderController as StudentOrderController;
use App\Http\Controllers\Teacher\ContentController as TeacherContentController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\SalesController as TeacherSalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/cursos/{course:slug}', [CatalogController::class, 'show'])->name('catalog.show');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/approve', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::post('orders/{order}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');

    Route::prefix('reportes')->name('reports.')->group(function () {
        Route::get('ventas', [AdminReportController::class, 'sales'])->name('sales');
        Route::get('pendientes', [AdminReportController::class, 'pending'])->name('pending');
        Route::get('usuarios', [AdminReportController::class, 'users'])->name('users');
    });
});

Route::middleware(['auth', 'role:profesor'])->prefix('profesor')->name('teacher.')->group(function () {
    Route::resource('cursos', TeacherCourseController::class)->parameters(['cursos' => 'course'])->names('courses');

    Route::prefix('cursos/{course}/contenido')->name('courses.content.')->group(function () {
        Route::get('/', [TeacherContentController::class, 'index'])->name('index');
        Route::post('modulos', [TeacherContentController::class, 'storeModule'])->name('modules.store');
        Route::put('modulos/{module}', [TeacherContentController::class, 'updateModule'])->name('modules.update');
        Route::delete('modulos/{module}', [TeacherContentController::class, 'destroyModule'])->name('modules.destroy');
        Route::post('modulos/{module}/lecciones', [TeacherContentController::class, 'storeLesson'])->name('lessons.store');
        Route::put('modulos/{module}/lecciones/{lesson}', [TeacherContentController::class, 'updateLesson'])->name('lessons.update');
        Route::delete('modulos/{module}/lecciones/{lesson}', [TeacherContentController::class, 'destroyLesson'])->name('lessons.destroy');
    });

    Route::get('ventas', [TeacherSalesController::class, 'index'])->name('sales.index');
});

Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('student.')->group(function () {
    Route::get('ordenes', [StudentOrderController::class, 'index'])->name('orders.index');
    Route::get('cursos/{course:slug}/comprar', [StudentOrderController::class, 'create'])->name('orders.create');
    Route::post('cursos/{course:slug}/comprar', [StudentOrderController::class, 'store'])->name('orders.store');
    Route::get('mis-cursos', [StudentEnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('mis-cursos/{course:slug}', [StudentEnrollmentController::class, 'show'])->name('enrollments.show');
});
