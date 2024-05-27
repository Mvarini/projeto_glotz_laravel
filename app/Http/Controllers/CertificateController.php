<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Css\Style;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;


class CertificateController extends Controller
{
    public function certificate(Student $student, Course $course)
    {
        // Quantidade de certificados do aluno
        $certificate = Certificate::where('student_id', $student->id)->where('aux_course', $course->id)->count();

        // Número do registro do certificado do aluno
        $certificateUUID = Certificate::where('student_id', $student->id)->where('aux_course', $course->id)->value('certificate');

        if (!auth()->user()->hasRole('Aluno')) {
            return redirect()->back()->with('error', 'Somente alunos podem emitir certificado!');
        }

        if ($certificate > 0) {

            // Carregar o view do pdf com os parâmetros e definições da página
            $pdf = Pdf::loadView('certificates.index', ['student' => $student, 'course' => $course, 'certificateUUID' => $certificateUUID])->setPaper('A4', 'landscape');

            // Salva uma cópia do certificado do aluno no momento que ele é gerado
            Storage::put('public/certificate/'. $student->user->name.'_'. $course->name.'.'.'pdf', $pdf->output());

            // Fazer download do certifiado
            return $pdf->download($course->name . '.pdf');

            // Visualizar o certificado no navegador
//            return $pdf->stream();


            // Recarregar a view do certificado
//            return view('certificates.index', ['menu' => 'course', 'student' => $student, 'course' => $course, 'certificateUUID' => $certificateUUID]);
        } else {
            return redirect()->back()->with('error', 'Ainda existe aula para você assistir');
        }
    }
}
