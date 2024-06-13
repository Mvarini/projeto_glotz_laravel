<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    // Listar todos os professores
    public function index(Request $request)
    {

        $teacherSearch = $request->input('pesquisar');
        $teachers = Teacher::where('first_name', 'like', '%' . $teacherSearch . '%')
            ->orWhere('last_name', 'like', '%' . $teacherSearch . '%')
            ->paginate(10)
            ->withQueryString();

//        // Listar todos os professores, ordenar e paginação
//        $teachers = Teacher::orderByDesc('created_at')->paginate(10);

        // Carrega a view
        return view('teachers.index', ['teachers' => $teachers, 'menu' => 'teachers', 'pesquisar' => $teacherSearch]);
    }

    // Detalhes do professor
    public function show(Teacher $teacher)
    {
        // Recuperar as iformações do banco de dados passando o Request
//        $teacher = Teacher::where('id', $request->teacher)->first();

        // Carrega a view
        return view('teachers.show', ['teacher' => $teacher, 'menu' => 'teachers']);
    }

    // Formulário para cadastro
    public function create()
    {
        // Carrega a view
        return view('teachers.create', ['menu' => 'teachers']);
    }

    // Cadastro no banco de dados
    public function store(TeacherRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Inicia a transação
        DB::beginTransaction();

        try {
            // Verifica se tem imagem e se é no formato válido
            if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
                // Atribuir o nome da imagem
                $requestImage = $request->signature;

                // Pegar a extensão da imagem
                $extension = $requestImage->extension();

                // Atribuir hash ao nome da imagem e concatenar com a hora e a extensão para que seja único
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                // Mover o arquivo na pasta public
                $requestImage->move(public_path('img/teachers'), $imageName);
            }

            $teacher = Teacher::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'signature' => $request->hasFile('signature') ? $imageName : $request->signature,
            ]);

            // Processo concluído
            DB::commit();

            // Salvar log
            Log::info('Professor cadastrado', ['id' => $teacher->id, $teacher, 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e mostra a mensagem
            return redirect()->route('teacher.index')->with('success', 'Professor cadastrado com sucesso!');

        }catch (\Exception $ex){
            // Processo não concluído
            DB::rollBack();

            // Salvar log
            Log::error('Professor não cadastrado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e mostra a mensagem
            return redirect()->back()->with('error', 'Professor não cadastrado!');
        }
    }

    // Carregar o formulário para editar o registro
    public function edit(Teacher $teacher)
    {
        // Utilizando o request como parâmetor no médotod Request $request
       //$teacher = Teacher::where('id', $request->teacher)->first();

        // Carregar a view
        return view('teachers.edit', ['teacher' => $teacher, 'menu' => 'teachers']);
    }

    // Atualiza os dados do professor no banco de dados
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        // Validar o formulário
        $request->validated();

        // Ponto inicial da transação
        DB::beginTransaction();

        try {

            // Verificar se existe a imagem e se é válida
            if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
                // Atribuir o nome da imagem
                $requestImage = $request->signature;

                // Pegar a extensão da imagem
                $extension = $requestImage->extension();

                //Atribuir hash ao nome da imagem e concatenar com a hora e a extensão para que seja único
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                // Mover o arquivo na pasta public
                $requestImage->move(public_path('img/teachers'), $imageName);

                // Caminho para apagar o arquivo da imagem
                $imageBack = 'img/teachers/' . $teacher->signature;
                if (File::exists($imageBack)){
                    File::delete($imageBack);
                }
            }

            // Atualiza os dados no banco
            $teacher->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'signature' => $request->hasFile('signature') ? $imageName : $teacher->signature,
            ]);

            // Operaçaõ concluída
            DB::commit();

            // Salvar log
            Log::info('Professor atualizado', ['id' => $teacher->id, $teacher, 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e mostra a mensagem
            return redirect()->route('teacher.index')->with('success', 'Professor atualizado com sucesso!');

        }catch (\Exception $ex){

            // Operação não é concluída
            DB::rollBack();

            // Salvar log
            Log::error('Professor não atualizado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redireciona o usuário e mostra a mensagam
            return redirect()->back()->with('error', 'Professor não editado!');
        }
    }

    // Deleta do banco de dados
    public function destroy(Teacher $teacher)
    {
        try {
            // Caminho para apagar o arquivo da imagem
            $imageBack = 'img/teachers/' . $teacher->signature;
            if (File::exists($imageBack)){
                File::delete($imageBack);
            }

            // Excluir o registro do banco de dados
            $teacher->delete();

            // Salvar log
            Log::info('Professor excluido', ['id' => $teacher->id, 'action_user_id' => Auth::id()]);

            // Redirecionar e apresentar a mensagem
            return redirect()->route('teacher.index')->with('success', 'Professor excluído com sucesso!');

        }catch (\Exception $ex){

            //Salvar log
            Log::error('Professor não excluido', ['id' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar e apresentar a mensagem
            return redirect()->route('teacher.index')->with('error', 'Professor não excluído, pois, existe curso vinculado a este professor!');
        }
    }
}
