<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Certificate;
use App\Models\ClasseWatched;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index(Course $course, User $user)
    {
        $students = Student::orderBy('user_id', 'asc')->paginate(10);

        return view('students.index', ['user' => $user, 'course' => $course, 'students' => $students, 'menu' => 'students']);
    }

    public function show(Student $student, Course $course, User $user)
    {
        return view('students.show', ['student' => $student, 'course' => $course, 'user' => $user, 'menu' => 'students']);
    }

    public function create()
    {
        $courses = Course::all();
        $users = User::all();

        return view('students.create', ['courses' => $courses, 'users' => $users, 'menu' => 'students']);
    }

    public function store(StudentRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {
            // Se a requisão já existir no banco não cadastra novamente
            $student = Student::firstOrCreate([
                'user_id' => $request->user_id,
                'course_id' => $request->course_id
            ]);

            // Processo concluído
            DB::commit();

            // Salvar o log
            Log::info('Aluno e curso cadastrado', ['id' => $student->id, $student, 'action_user_id' => Auth::id()]);

            // Verifica se já foi recentemente cadastrada o request
            if ($student->wasRecentlyCreated) {
                // Redirecionar o usuário e enviar mensagem
                return redirect()->route('student.index')->with('success', 'Aluno cadastrado com sucesso');
            } else {
                // Redirecionar o usuário e enviar mensagem
                return redirect()->route('student.index')->with('error', 'O aluno e o curso já estão cadastrados');
            }
        } catch (\Exception $ex) {
            // Processo não concluído
            DB::rollBack();

            // Salvar o log
            Log::error('Aluno e curso não cadastrado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'O aluno e o curso não foram cadastrados');
        }
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        $users = User::all();

        return view('students.edit', ['student' => $student, 'courses' => $courses, 'users' => $users, 'menu' => 'students']);
    }

    public function update(StudentRequest $request, Student $student)
    {
        // Validar o formulário
        $request->validated();

        // Inicar o transação
        DB::beginTransaction();

        try {
            // Verifica se o request já existe no banco de dados antes de atualizar
            if (Student::where('user_id', '=', $request->user_id)->where('course_id', '=', $request->course_id)->first()) {
                return redirect()->route('student.index')->with('error', 'Aluno e o curso que você tentou cadastrar já existem');
            } else {
                $student->update([
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id
                ]);

                // Processo concluído
                DB::commit();

                // Salvar o log
                Log::info('Aluno e curso cadastrado', ['id' => $student->id, $student, 'action_user_id' => Auth::id()]);

                // Redirecionar o usuário e enviar a mensagem
                return redirect()->route('student.index')->with('success', 'Aluno e curso atualiado com sucesso');
            }
        } catch (\Exception $ex) {
            // Processo não conlcluído
            DB::rollBack();

            // Salvar o log
            Log::error('Aluno e curso não atualizado', ['id' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Aluno e curso não atualizado');
        }
    }

    public function destroy(Student $student)
    {

        try {
            // Deletar todas as aulas do aluno na tabela (classes_watched)
            ClasseWatched::where('student_id', $student->id)->delete();

            // Deletar todos os certificados do aluno na tabela (certificates)
            Certificate::where('student_id', $student->id)->delete();

            // Deletar os dados do banco
            $student->delete();

            // Salvar o log
            Log::info('Aluno e curso excluído', ['id' => $student->id, 'action_user_id' => Auth::id()]);

            // Redircionar o usuário e enviar a mensagem
            return redirect()->route('student.index')->with('success', 'Aluno e curso exluído com sucesso');
        }catch (\Exception $ex){
            // Salvar o log
            Log::error('Aluno e curso não excluído', ['id' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('student.index')->with('error', 'Existe aula assistida deste aluno para o curso');
        }

    }
}
