<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $teacher1 = User::where('email', 'profesor@educommerce.test')->first();
        $teacher2 = User::where('email', 'profesor2@educommerce.test')->first();
        $student1 = User::where('email', 'estudiante@educommerce.test')->first();
        $student2 = User::where('email', 'estudiante2@educommerce.test')->first();
        $admin = User::where('email', 'admin@educommerce.test')->first();

        $catProg = Category::where('slug', 'programacion')->first();
        $catDesign = Category::where('slug', 'diseno')->first();
        $catMarketing = Category::where('slug', 'marketing')->first();

        $courses = [
            ['title' => 'PHP desde cero', 'teacher' => $teacher1, 'category' => $catProg, 'price' => 150000, 'level' => 'basico'],
            ['title' => 'Laravel 8 avanzado', 'teacher' => $teacher1, 'category' => $catProg, 'price' => 280000, 'level' => 'avanzado'],
            ['title' => 'JavaScript moderno', 'teacher' => $teacher1, 'category' => $catProg, 'price' => 180000, 'level' => 'intermedio'],
            ['title' => 'Diseño UI/UX con Figma', 'teacher' => $teacher2, 'category' => $catDesign, 'price' => 220000, 'level' => 'basico'],
            ['title' => 'Photoshop profesional', 'teacher' => $teacher2, 'category' => $catDesign, 'price' => 250000, 'level' => 'intermedio'],
            ['title' => 'Marketing digital 360', 'teacher' => $teacher2, 'category' => $catMarketing, 'price' => 320000, 'level' => 'intermedio'],
            ['title' => 'SEO para principiantes', 'teacher' => $teacher2, 'category' => $catMarketing, 'price' => 120000, 'level' => 'basico'],
        ];

        $created = [];
        foreach ($courses as $data) {
            $created[] = Course::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'teacher_id' => $data['teacher']->id,
                    'category_id' => $data['category']->id,
                    'title' => $data['title'],
                    'description' => 'Curso completo de ' . $data['title'] . '. Aprende desde lo más básico hasta dominar la materia con ejercicios prácticos.',
                    'price' => $data['price'],
                    'level' => $data['level'],
                    'duration_hours' => rand(10, 40),
                    'is_published' => true,
                ]
            );
        }

        $this->createOrder($created[0], $student1, $admin, Order::STATUS_APPROVED);
        $this->createOrder($created[1], $student1, $admin, Order::STATUS_APPROVED);
        $this->createOrder($created[3], $student2, $admin, Order::STATUS_APPROVED);
        $this->createOrder($created[2], $student2, $admin, Order::STATUS_REJECTED, 'Comprobante ilegible');
        $this->createOrder($created[4], $student1, null, Order::STATUS_PENDING);
        $this->createOrder($created[5], $student2, null, Order::STATUS_PENDING);
    }

    private function createOrder(Course $course, User $student, ?User $reviewer, string $status, ?string $reason = null): void
    {
        $order = Order::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'status' => $status,
            'rejection_reason' => $reason,
            'reviewed_by' => $reviewer ? $reviewer->id : null,
            'reviewed_at' => $reviewer ? now() : null,
        ]);

        $banks = ['Bancolombia', 'Davivienda', 'BBVA', 'Banco de Bogotá', 'Nequi', 'Daviplata'];
        $order->paymentProof()->create([
            'file_path' => 'comprobantes/demo.jpg',
            'bank' => $banks[array_rand($banks)],
            'operation_number' => (string) rand(100000, 999999),
            'payment_date' => now()->subDays(rand(1, 30)),
        ]);

        if ($status === Order::STATUS_APPROVED) {
            Enrollment::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
            ], [
                'order_id' => $order->id,
            ]);
        }
    }
}
