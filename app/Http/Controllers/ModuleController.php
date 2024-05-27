<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleRequest;
use App\Models\Classe;
use App\Models\ClasseWatched;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\table;

class ModuleController extends Controller
{
    // Listar os módulos
    public function index(Course $course, Classe $classe)
    {

        // Listar os módulos do curso específico, ordenar e mostrar a paginação
        $modules = Module::with('course')->where('course_id', $course->id)->orderBy('created_at', 'desc')->paginate(10);

        // Listar os módulos do curso específico, ordenar e mostrar a paginação
        $nameCourse = Module::with('course')->where('course_id', $course->id)->first();

        // Dados das aulas
        $datas = Module::with('classe')->where('course_id', $course->id)->get();

        // Cadastrar as aulas que o aluno visualizou na tabela (classes_watched)
        $student = Student::with('user')->where('user_id', Auth::id())->first();

        // Recuperar somente os ids concatenados
        $listClassesWatched = ClasseWatched::selectRaw("id, CONCAT(class_id,'',student_id) as n")->pluck('n', 'id');

        // Carregar a view
        return view('modules.index', ['modules' => $modules, 'course' => $course, 'nameCourse' => $nameCourse, 'datas' => $datas, 'menu' => 'courses', 'listClassesWatched' => $listClassesWatched, 'student' => $student]);
    }

    // Visualizar detalhes do módulo
    public function show(Module $module)
    {
        // Carregar a view
        return view('modules.show', ['module' => $module, 'menu' => 'courses']);
    }

    // Carregar o formulário para cadastrar o módulo
    public function create(Course $course)
    {
        // Carregar a view
        return view('modules.create', ['course' => $course, 'menu' => 'courses']);
    }

    // Salvar as informações no banco de dados
    public function store(ModuleRequest $request)
    {
        // Valida o formulário
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {
            // Cadastrar as informações no banco de dados
            $module = Module::create([
                'course_id' => $request->course_id,
                'name' => $request->name,
                'hour' => $request->hour,
                'description' => $request->description
            ]);

            // Processo conclúido
            DB::commit();

            // Salvar o log
            Log::info('Módulo cadastrado', ['id' => $module->id, 'action_user_id' => Auth::id()]);

            // Redirecionar e enviar a mensagem
            return redirect()->route('module.index', ['course' => $request->course_id])->with('success', 'Módulo cadastrado com sucesso!');
        }catch (\Exception $ex){
            // Processo não concluido
            DB::rollBack();

            // Salvar o log
            Log::error('Módulo não cadastrado', ['id' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->back()->withInput()->with('error', 'Módulo não cadastrado');
        }
    }

    // Carregar o formulário para editar
    public function edit(Module $module)
    {
        // Carregar a view
        return view('modules.edit', ['module' => $module, 'menu' => 'courses']);
    }

    // Editar o módulo no banco de dados
    public function update(ModuleRequest $request, Module $module)
    {
        // Valida as informações do formulário
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {
            // Editar as informações no banco de dados
            $module->update([
                'name' => $request->name,
                'hour' => $request->hour,
                'description' => $request->description
            ]);

            // Processo concluido
            DB::commit();

            // Salvar o log
            Log::info('Módulo editado', ['id' => $module->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e mensagem
            return redirect()->route('module.index', ['course' => $module->course_id])->with('success', 'Módulo atualizado com sucesso!');

        }catch (\Exception $ex){
            // Processo não concluido
            DB::rollBack();

            // Salvar o log
            Log::error('Módulo não editado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e mensagem
            return redirect()->back()->withInput()->with('error', 'Módulo não cadastrado');
        }
    }

    // Deletar o professor
    public function destroy(Module $module)
    {
        try {
            // Apagar do banco de dados
            $module->delete();

            // Salvar o log
            Log::info('Módulo excluído', ['id' => $module->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e mensagem
            return redirect()->route('module.index', ['course' => $module->course_id])->with('success', 'Módulo excluído com sucesso!');
        }catch (\Exception $ex){

            // Salvar o log
            Log::error('Módulo não excluído', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e mensagem
            return redirect()->route('module.index', ['course' => $module->course_id])->with('error', 'Módulo não excluído, pois, existe aula vinculada ao módulo');
        }
    }
}
