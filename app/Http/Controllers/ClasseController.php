<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasseRequest;
use App\Models\Certificate;
use App\Models\Classe;
use App\Models\ClasseWatched;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ClasseController extends Controller
{
    // Listar as aulas
    public function index(Module $module)
    {
        // Listar os aulas específicas do módulo, ordenar e paginação
        $classes = Classe::with('module')->where('module_id', $module->id)->orderBy('created_at', 'desc')->paginate(10);

        // Carregar a view
        return view('classes.index', ['classes' => $classes, 'module' => $module, 'menu' => 'courses']);
    }

    // Visualizar os dados da aulas
    public function show(Classe $classe)
    {
        $dataFirst = Classe::with('module')->where('module_id', $classe->module_id)->first();

        // Listar os aulas específicas do módulo, ordenar e paginação
        $listClasses = Classe::with('module')->where('module_id', $classe->module_id)->orderBy(
            'created_at',
            'ASC'
        )->get();

        // Carregar a view
        return view(
            'classes.show',
            ['classe' => $classe, 'listClasses' => $listClasses, 'dataFirst' => $dataFirst, 'menu' => 'courses']
        );
    }

    // Carregar o formulário cadastar a aula
    public function create(Module $module)
    {
        // Carregar a view
        return view('classes.create', ['module' => $module, 'menu' => 'courses']);
    }

    // Cadastrar a aula no banco de dados
    public function store(ClasseRequest $request)
    {
        // Valida o formulário
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {
            // Recuperar a última ordem da aula do curso
            $lastOrderClasse = Classe::where('module_id', $request->module_id)->orderByDesc('order_classe')->first();

            // move o video para o diretório em store
            $video = $request->file('video')->store('video', 'public');

            // Verificar se existe arquivo no input
            if ($request->hasFile('pdf')) {
                // Move o pdf para o diretório store
                $pdf = $request->file('pdf')->store('pdf', 'public');
            }

            // Cadastra as informações no banco de dados
            $classe = Classe::create([
                'module_id' => $request->module_id,
                'name' => $request->name,
                'video' => $video,
                'order_classe' => $lastOrderClasse != null ? $lastOrderClasse->order_classe + 1 : 1,
                'pdf' => $request->hasFile('pdf') ? $pdf : $request->pdf
            ]);

            // Processo concluído
            DB::commit();

            // Salvar  o log
            Log::info('Aula cadastrada', ['id' => $classe->id, $classe, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('classe.index', ['module' => $request->module_id])->with(
                'success',
                'Aula cadastrada com sucesso!'
            );
        } catch (\Exception $ex) {
            // Processo não concluído
            DB::rollBack();

            // Salvar o log
            Log::error('Aula não cadastrada', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->back()->withInput()->with('error', 'Aula não cadastrada');
        }
    }

    // Carregar o formulário editar a aula
    public function edit(Classe $classe)
    {
        // Return a view
        return view('classes.edit', ['classe' => $classe, 'menu' => 'courses']);
    }

    // Editar a aula no banco de dados
    public function update(ClasseRequest $request, Classe $classe)
    {
        // Valida o formulário
        $request->validated();

        // Inicar a transação
        DB::beginTransaction();

        try {
            // Verificar se existe o vídeo no input
            if ($request->hasFile('video')) {
                // move o video para o diretório store
                $video = $request->file('video')->store('video', 'public');

                // Apaga o video anterior
                Storage::disk('public')->delete($classe->video);
            }

            // Verificar se existe o arquivo no input
            if ($request->hasFile('pdf')) {
                // Move o pdf para o diretório store
                $pdf = $request->file('pdf')->store('pdf', 'public');

                // Se existir o arquivo no banco de dados
                if ($classe->pdf) {
                    // Apaga o pdf anterior
                    Storage::disk('public')->delete($classe->pdf);
                }
            }

            // Atualiza os dados da aula no banco de dados
            $classe->update([
                'name' => $request->name,
                'video' => $request->hasFile('video') ? $video : $classe->video,
                'pdf' => $request->hasFile('pdf') ? $pdf : $classe->pdf
            ]);

            // Processo concluído
            DB::commit();

            // Salvar o log
            Log::info('Aula atualizada', ['id' => $classe->id, $classe, 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e mostra a mensagem
            return redirect()->route('classe.index', ['module' => $classe->module_id])->with(
                'success',
                'Aula atualizado com sucesso!'
            );
        } catch (\Exception $ex) {
            // Processo não concluído
            DB::rollBack();

            // Salvar o log
            Log::error('Aula não atualizada', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->back()->withInput()->with('error', 'Aula não cadastrada');
        }
    }

    // Excluir a aula no banco de dados
    public function destroy(Classe $classe)
    {
        try {
            // Apaga o video anterior
            Storage::disk('public')->delete($classe->video);

            // Se existir o pdf então apaga
            if ($classe->pdf) {
                // Apaga o pdf anterior
                Storage::disk('public')->delete($classe->pdf);
            }

            // Deletar a aula
            $classe->delete();

            // Salvar o log
            Log::info('Aula excluída', ['id' => $classe->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->route('classe.index', ['module' => $classe->module_id])->with(
                'success',
                'Aula excluída com sucesso!'
            );
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Aula não excluída', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->route('classe.index', ['module' => $classe->module_id])->with(
                'error',
                'Aula não excluída'
            );
        }
    }

    public function view(Classe $classe)
    {
        $dataFirst = Classe::with('module')->where('module_id', $classe->module_id)->first();

        // Listar os aulas específicas do módulo, ordenar e paginação
        $listClasses = Classe::with('module')->where('module_id', $classe->module_id)->orderBy('created_at', 'ASC')->get();

        // Compara se o id do usuário logado é igual ao aluno
        $student = Student::with('user')->where('user_id', Auth::id())->first();

        // Cadastra na tabela (classes_watched) se for Aluno e se existir não cadastra
        if (Auth::user()->hasrole('Aluno')) {
            ClasseWatched::firstOrCreate([
                'class_id' => $classe->id,
                'student_id' => $student->id,
            ]);
        }

        // Recuperar somente os ids concatenados da tablea (classes_watche)
        $listClassesWatched = ClasseWatched::selectRaw("id, CONCAT(class_id,'',student_id) as n")->pluck('n', 'id');

        // Se o papael do usuário logado é aluno
        if (Auth::user()->hasrole('Aluno')) {
            $query = DB::select(
                'select count(1) as qtde from classes_watched cw
                    join classes cl on cw.class_id  = cl.id
                    join modules m on cl.module_id  = m.id  and m.course_id  = :curso_id
                    where cw.student_id = :student_id',
                ['student_id' => $student->id, 'curso_id' => $classe->module->course_id]
            );


            $queryCount = DB::select(
                'select count(1) as qtde from classes cl
                    join modules m on cl.module_id  = m.id  and m.course_id  = :curso_id',
                ['curso_id' => $classe->module->course_id]
            );

            if ($query != null && $queryCount != null && $query[0]->qtde == $queryCount[0]->qtde) {
                Certificate::firstOrCreate([
                    'student_id' => $student->id,
                    'aux_course' => $classe->module->course_id
                ]);
            }
        }

        // Carregar a view
        return view('classes.view', ['classe' => $classe, 'listClasses' => $listClasses, 'dataFirst' => $dataFirst, 'menu' => 'courses', 'listClassesWatched' => $listClassesWatched, 'student' => $student]);
    }

    // Fazer o download do PDF da aula
    public function download(Classe $classe)
    {
        try {
            // Log
            Log::info('Download feito com sucesso', ['id' => $classe->id, 'action_user_id' => Auth::id()]);

            // Download direto no arquivo sem exibir na tela
            return Storage::disk('public')->download($classe->pdf, $classe->name);
        } catch (\Exception $ex) {
            // Log
            Log::error('Error ao fazer o download', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->with('error', 'Opps, não foi possível fazer o download');
        }
    }
}
