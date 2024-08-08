<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Classe;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class CourseController extends Controller
{

    // Listar todos os cursos
    public function index( Teacher $teacher)
    {
        // Usuário logado
        $user = Auth::user();

        // Relaciona o usuário logado com o aluno
        $student = Student::where('user_id', $user->id)->first();

        // Carrega os cursos do aluno, caso não seja aluno carrega tudo
        if ($user->hasRole('Aluno')) {
            $courses = DB::table('students as s')
                ->join('users as u', 'u.id', '=', 's.user_id')
                ->join('courses as c', 'c.id', '=', 's.course_id')
                ->where('s.user_id', '=',  Auth::id())
                ->paginate(8);
        }else {
            $courses = Course::orderByDesc('created_at')->paginate(8);
        }

        // Carregar a view
        return view('courses.index', [
            'courses' => $courses,
            'teacher' => $teacher,
            'menu' => 'courses',
            'student' => $student,
        ]);
   }

    // Visualizar os detalhes do  curso
    public function show(Course $course)
    {
        // Carregar a view
        return view('courses.show', ['course' => $course, 'menu' => 'courses']);
    }

    // Carregar o formulário para cadastar um novo curso
    public function create()
    {
        $teachers = Teacher::all();

        // Carregar a view
        return view('courses.create', ['teachers' => $teachers, 'menu' => 'courses']);
    }

    // Cadastrar no banco de dados o novo curso
    public function store(CourseRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {
            // Verificar se a imagem existe e se é válida
            if ($request->hasFile('cover') && $request->file('cover')->isValid()){
                // Atribuir o nome da imagem
                $requestImage = $request->cover;

                // Pegar a extensão
                $extension = $requestImage->extension();

                // Atribuir hash ao nome da imagem e concatenar com a hora e a extensão para ser único
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                // Mover o arquivo na pasta public
                $requestImage->move(public_path('img/courses'), $imageName);
            }
            // Cadastra as informações no banco de dados
            $course = Course::create([
                'teacher_id' => $request->teacher_id,
                'name' => $request->name,
                'hour' => $request->hour,
                'cover' => $request->hasFile('cover') ? $imageName : $request->cover,
                'price' => str_replace([".", ","], ["", "."], $request->price),
                'description' => $request->description
            ]);

            // Processo concluído
            DB::commit();

            // Salvar o log
            Log::info('Curso cadastrado', ['id' => $course->id, 'action_user_id' => Auth::id()]);

            // Redirecionar e enviar a mensagem
            return redirect()->route('course.index')->with('success', 'Curso cadastrado com sucesso!');

        }catch (\Exception $ex){

            // Salvar o log
            Log::error('Curso não cadastrado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Processo não concluído
            DB::rollBack();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->back()->withInput()->with('error', 'Curso não cadastrado!');
        }
    }

    // Carregar o formulário para editar
    public function edit(Course $course)
    {
        $teachers = Teacher::all();

        // Carregar a view
        return view('courses.edit', ['course' => $course, 'teachers' => $teachers, 'menu' => 'courses']);
    }

    // Editar o curso no banco de dados
    public function update(CourseRequest $request, Course $course)
    {
        // Valida as informações do formulário
        $request->validated();

        // Ponto inicial da transação
        DB::beginTransaction();

        try {

            if ($request->hasFile('cover') && $request->file('cover')->isValid())
            {
                // Atribuir a imagem
                $requestImage = $request->cover;

                // Atribuir a extensão da imagem
                $extension = $requestImage->extension();

                // Atribuir o nome da imagem e concatenar com hora, md5 e depois extesão
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                // Mover o arquivo para a pasta expecífica
                $requestImage->move(public_path('img/courses'), $imageName);

                // Atribuir o arquivo atual
                $imageDestination = 'img/courses/' . $course->cover;
                if (File::exists($imageDestination)) {
                    File::delete($imageDestination);
                }
            }

            // Editar as informações no banco de dados
            $course->update([
                'teacher_id' => $request->teacher_id,
                'name' => $request->name,
                'hour' => $request->hour,
                'cover' => $request->hasFile('cover') ? $imageName : $course->cover,
                'price' => str_replace([".", ","], ["", "."], $request->price),
                'description' => $request->description
            ]);

            // Salvar o log
            Log::info('Curso atualizado', ['id' => $course->id, 'action_user_id' => Auth::id()]);

            // Transação concluída
            DB::commit();

            // Redirecionar o usuário e mensagem
            return redirect()->route('course.index')->with('success', 'Curso atualizado com sucesso');

        }catch (\Exception $ex){
            //Salvar o log
            Log::error('Curso não atualizado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Desfaz a transação
            DB::rollBack();

            //Redireciona o usuário e envia a mensagem
            return redirect()->back()->withInput()->with('error', 'Curso não atualizado');
        }
    }

    // Excluir o curso do banco de dados
    public function destroy(Course $course)
    {
        try {

            // Deleta o curso do banco de dados
            $course->delete();

            // Apaga a imagem
            $imageDestination = 'img/courses/' . $course->cover;
            if (File::exists($imageDestination)) {
                File::delete($imageDestination);
            }

            // Salvar o log
            Log::info('Curso excluído', ['id' => $course->id, 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e envia a mensagem
            return redirect()->route('course.index')->with('success', 'Curso excluido com sucesso');
        }catch (\Exception $ex){
            // Salvar o log
            Log::error('Curso não excluido', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e envia a mensagem
            return redirect()->route('course.index')->with('error', 'Não é possível excluir um curso que possui módulos ou alunos vinculados');
        }
    }

}
