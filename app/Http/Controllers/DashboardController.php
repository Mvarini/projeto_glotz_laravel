<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Cards
        $Course = Course::count();
        $teacher = Teacher::count();
//        $student = Student::distinct()->count('user_id');
//        $courseStudentCount = Student::count();

        // Cards Papéis
        $superAdminCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Super Admin')->toArray()
        )->count();

        $adminCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Admin')->toArray()
        )->count();

//        $teacherCount = User::with('roles')->get()->filter(
//            fn ($user) => $user->roles->where('name', 'Professor')->toArray()
//        )->count();
//
//        $studentCount = User::with('roles')->get()->filter(
//            fn ($user) => $user->roles->where('name', 'Aluno')->toArray()
//        )->count();

        // Gráfico 01 - Estudantes
        $studentData = Student::select([
            DB::raw("YEAR(created_at) as ano"),
            DB::raw("COUNT(DISTINCT user_id) as total")
        ])
            ->groupBy('ano')
            ->orderBy('ano', 'asc')
            ->get();

        // Preparar os dados Gráfico 01
        foreach ($studentData as $student) {
            $year[] = $student->ano;
            $total[] = $student->total;
        }

        // Formatar para chartjs Gráfico 01
        $studentLabel = " 'Cdastro de Alunos' ";
        $studentYear = implode(',', $year);
        $studentTotal = implode(',', $total);

        // Gráfico 02
        $courseData = Course::with('student')->get();

        // Prepar os dados Gráfico 02
        foreach ($courseData as $course) {
            $courseName[] = "'".$course->name."'";
            $courseTotal[] = $course->student->count();
        }

        // Formatar para chartjs
        $courseLabel = implode(',', $courseName);
        $courseTotal = implode(',', $courseTotal);

        // Carregar a view
        return view('dashboards.index', [
            'menu' => 'dashboard',
            'course' => $Course,
            'teacher' => $teacher,
            'student' => $student,
            'superAdminCount' => $superAdminCount,
            'adminCount' => $adminCount,
            'studentLabel' => $studentLabel,
            'studentYear' => $studentYear,
            'studentTotal' => $studentTotal,
            'courseLabel' => $courseLabel,
            'courseTotal' => $courseTotal,
        ]);
    }
}
