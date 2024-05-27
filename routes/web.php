<?php


use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

// LOGIN
Route::get('/', [\App\Http\Controllers\LoginController::class, 'index'])->name('login.index');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'loginProcess'])->name('login.process');

// FORGOT PASSWORD
Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'showForgotPassword'])->name('forgot-password.show');

Route::group(['middleware' => 'auth'], function () {
// LOGOUT
Route::get('/logout', [\App\Http\Controllers\LoginController::class, 'destroy'])->name('login.destroy');

// DASHBOARD
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index')->middleware('permission:index-dashboard');

// PROFILE
Route::get('/show-profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::get('/edit-profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/update-profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::get('/edit-profile-password', [\App\Http\Controllers\ProfileController::class, 'editPassword'])->name('profile.edit-Password');
Route::put('/update-profile-password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.update-Password');


// STUDENT
Route::get('/index-student', [\App\Http\Controllers\StudentController::class, 'index'])->name('student.index')->middleware('permission:index-student');
Route::get('/show-student/{student}', [\App\Http\Controllers\StudentController::class, 'show'])->name('student.show')->middleware('permission:show-student');
Route::get('/create-student', [\App\Http\Controllers\StudentController::class, 'create'])->name('student.create')->middleware('permission:create-student');
Route::post('/store-student', [\App\Http\Controllers\StudentController::class, 'store'])->name('student.store')->middleware('permission:create-student');
Route::get('/edit-student/{student}', [\App\Http\Controllers\StudentController::class, 'edit'])->name('student.edit')->middleware('permission:edit-student');
Route::put('/update-student/{student}', [\App\Http\Controllers\StudentController::class, 'update'])->name('student.update')->middleware('permission:edit-student');
Route::delete('/destroy-student/{student}', [\App\Http\Controllers\StudentController::class, 'destroy'])->name('student.destroy')->middleware('permission:destroy-student');

// TEACHER
Route::get('/index-teacher', [\App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.index')->middleware('permission:index-teacher');
Route::get('/show-teacher/{teacher}', [\App\Http\Controllers\TeacherController::class, 'show'])->name('teacher.show')->middleware('permission:show-teacher');
Route::get('/create-teacher', [\App\Http\Controllers\TeacherController::class, 'create'])->name('teacher.create')->middleware('permission:create-teacher');
Route::post('/store-teacher', [\App\Http\Controllers\TeacherController::class, 'store'])->name('teacher.store')->middleware('permission:create-teacher');
Route::get('/edit-teacher/{teacher}', [\App\Http\Controllers\TeacherController::class, 'edit'])->name('teacher.edit')->middleware('permission:edit-teacher');
Route::put('/update-teacher/{teacher}', [\App\Http\Controllers\TeacherController::class, 'update'])->name('teacher.update')->middleware('permission:edit-teacher');
Route::delete('/destroy-teacher/{teacher}', [\App\Http\Controllers\TeacherController::class, 'destroy'])->name('teacher.destroy')->middleware('permission:destroy-teacher');

// COURSE
Route::get('/index-course', [\App\Http\Controllers\CourseController::class, 'index'])->name('course.index')->middleware('permission:index-course');
Route::get('/show-course/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('course.show')->middleware('permission:show-course');
Route::get('/create-course', [\App\Http\Controllers\CourseController::class, 'create'])->name('course.create')->middleware('permission:create-course');
Route::post('/store-course', [\App\Http\Controllers\CourseController::class, 'store'])->name('course.store')->middleware('permission:create-course');
Route::get('/edit-course/{course}', [\App\Http\Controllers\CourseController::class, 'edit'])->name('course.edit')->middleware('permission:edit-course');
Route::put('/update-course/{course}', [\App\Http\Controllers\CourseController::class, 'update'])->name('course.update')->middleware('permission:edit-course');
Route::delete('/destroy-course/{course}', [\App\Http\Controllers\CourseController::class, 'destroy'])->name('course.destroy')->middleware('permission:destroy-course');

// MODULE
Route::get('/index-module/{course}', [\App\Http\Controllers\ModuleController::class, 'index'])->name('module.index')->middleware('permission:index-module');
Route::get('/show-module/{module}', [\App\Http\Controllers\ModuleController::class, 'show'])->name('module.show')->middleware('permission:show-module');
Route::get('/create-module/{course}', [\App\Http\Controllers\ModuleController::class, 'create'])->name('module.create')->middleware('permission:create-module');
Route::post('/store-module', [\App\Http\Controllers\ModuleController::class, 'store'])->name('module.store')->middleware('permission:create-module');
Route::get('/edit-module/{module}', [\App\Http\Controllers\ModuleController::class, 'edit'])->name('module.edit')->middleware('permission:edit-module');
Route::put('/update-module/{module}', [\App\Http\Controllers\ModuleController::class, 'update'])->name('module.update')->middleware('permission:edit-module');
Route::delete('/destroy-module/{module}', [\App\Http\Controllers\ModuleController::class, 'destroy'])->name('module.destroy')->middleware('permission:destroy-module');

// CLASSE
Route::get('/index-classe/{module}', [\App\Http\Controllers\ClasseController::class, 'index'])->name('classe.index')->middleware('permission:index-classe');
Route::get('/show-classe/{classe}', [\App\Http\Controllers\ClasseController::class, 'show'])->name('classe.show')->middleware('permission:show-classe');
Route::get('/create-classe/{module}', [\App\Http\Controllers\ClasseController::class, 'create'])->name('classe.create')->middleware('permission:create-classe');
Route::post('/store-classe', [\App\Http\Controllers\ClasseController::class, 'store'])->name('classe.store')->middleware('permission:create-classe');
Route::get('/edit-classe/{classe}', [\App\Http\Controllers\ClasseController::class, 'edit'])->name('classe.edit')->middleware('permission:edit-classe');
Route::put('/update-classe/{classe}', [\App\Http\Controllers\ClasseController::class, 'update'])->name('classe.update')->middleware('permission:edit-classe');
Route::delete('/destroy-classe/{classe}', [\App\Http\Controllers\ClasseController::class, 'destroy'])->name('classe.destroy')->middleware('permission:destroy-classe');
Route::get('/view-classe/{classe}', [\App\Http\Controllers\ClasseController::class, 'view'])->name('classe.view')->middleware('permission:view-classe');
Route::get('/file-classe/{classe}', [\App\Http\Controllers\ClasseController::class, 'download'])->name('classe.file')->middleware('permission:file-classe');

// USER
Route::get('/index-user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index')->middleware('permission:index-user');
Route::get('/show-user/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.show')->middleware('permission:show-user');
Route::get('/create-user', [\App\Http\Controllers\UserController::class, 'create'])->name('user.create')->middleware('permission:create-user');
Route::post('/store-user/', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store')->middleware('permission:create-user');
Route::get('/edit-user/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit')->middleware('permission:edit-user');
Route::put('/update-user/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update')->middleware('permission:edit-user');
Route::delete('/destroy-user/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:destroy-user');
Route::get('/edit-user-password/{user}', [\App\Http\Controllers\UserController::class,'editPassword'])->name('user.edit-password')->middleware('permission:edit-password-user');
Route::put('/update-user-password/{user}', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.update-password')->middleware('permission:edit-password-user');

    // ROLES
    Route::get('/index-role', [\App\Http\Controllers\RoleController::class, 'index'])->name('role.index')->middleware('permission:index-role');
    Route::get('/show-role/{role}', [\App\Http\Controllers\RoleController::class,'show'])->name('role.show')->middleware('permission:show-role');
    Route::get('/create-role', [\App\Http\Controllers\RoleController::class, 'create'])->name('role.create')->middleware('permission:create-role');
    Route::post('/store-role', [\App\Http\Controllers\RoleController::class, 'store'])->name('role.store')->middleware('permission:create-role');
    Route::get('/edit-role/{role}', [\App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit')->middleware('permission:edit-role');
    Route::put('/update-role/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('role.update')->middleware('permission:edit-role');
    Route::delete('/destroy-role/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:destroy-role');

    // PERMISSION OF THE ROLES
    Route::get('/index-role-permission/{role}', [\App\Http\Controllers\RolePermissionController::class, 'index'])->name('role-permission.index')->middleware('permission:index-role-permission');
    Route::get('/update-role-permission/{role}/{permission}', [RolePermissionController::class, 'update'])->name('role-permission.update')->middleware('permission:update-role-permission');

    // PERMISSION
    Route::get('/index-permission', [\App\Http\Controllers\PermissionController::class, 'index'])->name('permission.index')->middleware('permission:index-permission');
    Route::get('/show-permission/{permission}', [\App\Http\Controllers\PermissionController::class, 'show'])->name('permission.show')->middleware('permission:show-permission');
    Route::get('/create-permission', [\App\Http\Controllers\PermissionController::class, 'create'])->name('permission.create')->middleware('permission:create-permission');
    Route::post('/store-permission', [\App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store')->middleware('permission:create-permission');
    Route::get('/edit-permission/{permission}', [\App\Http\Controllers\PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:edit-permission');
    Route::put('/update-permission/{permission}', [\App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update')->middleware('permission:edit-permission');
    Route::delete('/destroy-permission/{permission}', [\App\Http\Controllers\PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:edit-permission');

    // CERTIFICATE
    Route::get('/generate-pdf-user/{student}/{course}', [\App\Http\Controllers\CertificateController::class, 'certificate'])->name('certificate.user')->middleware('permission:generate-pdf-user');
});
