<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $Course = Course::count();
        $teacher = Teacher::count();
        $student = Student::distinct()->count('user_id');
        $courseStudentCount = Student::count();

        $superAdminCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Super Admin')->toArray()
        )->count();

        $adminCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Admin')->toArray()
        )->count();

        $teacherCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Professor')->toArray()
        )->count();

        $studentCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Aluno')->toArray()
        )->count();

        return view('dashboards.index', ['menu' => 'dashboard', 'course' => $Course, 'teacher' => $teacher, 'student' => $student, 'superAdminCount' => $superAdminCount, 'adminCount' => $adminCount, 'teacherCount' => $teacherCount, 'studentCount' => $studentCount, 'courseStudentCount' => $courseStudentCount]);
    }
}
