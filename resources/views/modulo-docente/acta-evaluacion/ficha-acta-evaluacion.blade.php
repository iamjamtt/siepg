<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Acta Evaluación
    </title>
    <style>
        body {
            margin-top: 305px;
            margin-bottom: 75px;
        }

        header {
            position: fixed;
            top: -20px;
            width: 100%;
        }

        footer {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: -20px;
            width: 100%;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @if ($tipo === 'regular')
        <header>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                <thead>
                    <tr>
                        <th align="left">
                            <div style="display: flex; align-items: center; margin-left: 0px;">
                                <img src="{{ public_path('assets_pdf/unu.png') }}" width="65px" height="80px" alt="logo unu">
                            </div>
                        </th>
                        <th>
                            <div style="text-align: center">
                                <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                    UNIVERSIDAD NACIONAL DE UCAYALI
                                </div>
                                <div style="margin: 0.2rem"></div>
                                <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                    ESCUELA DE POSGRADO
                                </div>
                            </div>
                        </th>
                        <th align="right">
                            <div style="display: flex; align-items: center; margin-right: 0px;">
                                <img src="{{ public_path('assets_pdf/posgrado.png') }}" width="65px" height="80px" alt="logo posgrado">
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
            <div style="margin-top: 0.4rem; text-align: center;">
                <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                    REGISTRO FINAL DE EVALUACIÓN ACADÉMICA
                </span>
            </div>
            <div style="margin-top: 0.2rem; text-align: center;">
                <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                    {{ $admision_año }} - {{ $ciclo }}
                </span>
            </div>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                <tbody>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                {{ $programa }}:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $subprograma }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Mención:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $mencion }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Curso:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $curso }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Cod. Curso:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $codigo_curso }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Docente:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $docente }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Cod. Docente:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $codigo_docente }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Créditos:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $creditos }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Ciclo:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $ciclo }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Grupo:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $grupo }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Tipo de Acta:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                REGULAR
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>
        <footer>
            <div style="margin-top: 1.5rem; text-align: right;">
                <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                    Fecha de emisión: {{ date('d/m/Y') }}
                </span>
            </div>
            <div style="margin-top: 2.5rem; text-align: right;">
                <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                    {{ $docente }}
                </span>
            </div>
            <div style="margin-top: 0rem; text-align: right;">
                <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                    Responsable del curso
                </span>
            </div>
        </footer>
        <main>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem; border-collapse: collapse;">
                <thead>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Nro
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Código
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px; width: 190px;">
                            Alumno
                        </th>
                        <th colspan="3" style="border: 1px solid black; padding: 8px;">
                            Promedios
                        </th>
                        <th colspan="2" style="border: 1px solid black; padding: 8px;">
                            Promedio Final
                        </th>
                    </tr>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Permanente
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Medio Curso
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Final
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Número
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Letras
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matriculados as $item)
                    @php
                        $notas = App\Models\NotaMatriculaCurso::where('id_matricula_curso', $item->id_matricula_curso)->first();
                        $letras = array('Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez', 'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve', 'Veinte');
                    @endphp
                        <tr style="border: 1px solid black; padding: 4px; font-size: 0.5rem">
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $loop->iteration }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $item->admitido_codigo }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;">
                                {{ $item->nombre_completo }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $notas->nota_evaluacion_permanente ? $notas->nota_evaluacion_permanente : '-' }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $notas->nota_evaluacion_medio_curso ? $notas->nota_evaluacion_medio_curso : '-' }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $notas->nota_evaluacion_final ? $notas->nota_evaluacion_final : '-' }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}" align="center">
                                @if ($notas->id_estado_cursos == 4)
                                    NSP
                                @else
                                    {{ $notas->nota_promedio_final }}
                                @endif
                            </td>
                            <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}">
                                @if ($notas->id_estado_cursos == 4)
                                    NSP
                                @else
                                    {{ $letras[$notas->nota_promedio_final] }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    @endif

    @if ($tipo === 'adicional')
        <header>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                <thead>
                    <tr>
                        <th align="left">
                            <div style="display: flex; align-items: center; margin-left: 0px;">
                                <img src="{{ public_path('assets_pdf/unu.png') }}" width="65px" height="80px" alt="logo unu">
                            </div>
                        </th>
                        <th>
                            <div style="text-align: center">
                                <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                    UNIVERSIDAD NACIONAL DE UCAYALI
                                </div>
                                <div style="margin: 0.2rem"></div>
                                <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                    ESCUELA DE POSGRADO
                                </div>
                            </div>
                        </th>
                        <th align="right">
                            <div style="display: flex; align-items: center; margin-right: 0px;">
                                <img src="{{ public_path('assets_pdf/posgrado.png') }}" width="65px" height="80px" alt="logo posgrado">
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
            <div style="margin-top: 0.4rem; text-align: center;">
                <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                    REGISTRO FINAL DE EVALUACIÓN ACADÉMICA
                </span>
            </div>
            <div style="margin-top: 0.2rem; text-align: center;">
                <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                    {{ $admision_año }} - {{ $ciclo }}
                </span>
            </div>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                <tbody>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                {{ $programa }}:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $subprograma }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Mención:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $mencion }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Curso:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $curso }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Cod. Curso:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $codigo_curso }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Docente:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $docente }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Cod. Docente:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $codigo_docente }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Créditos:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $creditos }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Ciclo:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $ciclo }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Grupo:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $grupo }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 85px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                Tipo de Acta:
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                ADICIONAL
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>
        <footer>
            <div style="margin-top: 1.5rem; text-align: right;">
                <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                    Fecha de emisión: {{ date('d/m/Y') }}
                </span>
            </div>
            <div style="margin-top: 2.5rem; text-align: right;">
                <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                    {{ $docente }}
                </span>
            </div>
            <div style="margin-top: 0rem; text-align: right;">
                <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                    Responsable del curso
                </span>
            </div>
        </footer>
        <main>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem; border-collapse: collapse;">
                <thead>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Nro
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Código
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px; width: 190px;">
                            Alumno
                        </th>
                        <th colspan="3" style="border: 1px solid black; padding: 8px;">
                            Promedios
                        </th>
                        <th colspan="2" style="border: 1px solid black; padding: 8px;">
                            Promedio Final
                        </th>
                    </tr>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Permanente
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Medio Curso
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Final
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Número
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Letras
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matriculados_adicional as $item)
                    @php
                        $notas = App\Models\NotaMatriculaCurso::where('id_matricula_curso', $item->id_matricula_curso)->first();
                        $letras = array('Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez', 'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve', 'Veinte');
                    @endphp
                        <tr style="border: 1px solid black; padding: 4px; font-size: 0.5rem">
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $loop->iteration }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $item->admitido_codigo }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;">
                                {{ $item->nombre_completo }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $notas->nota_evaluacion_permanente ? $notas->nota_evaluacion_permanente : '-' }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $notas->nota_evaluacion_medio_curso ? $notas->nota_evaluacion_medio_curso : '-' }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px;" align="center">
                                {{ $notas->nota_evaluacion_final ? $notas->nota_evaluacion_final : '-' }}
                            </td>
                            <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}" align="center">
                                @if ($notas->id_estado_cursos == 4)
                                    NSP
                                @else
                                    {{ $notas->nota_promedio_final }}
                                @endif
                            </td>
                            <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}">
                                @if ($notas->id_estado_cursos == 4)
                                    NSP
                                @else
                                    {{ $letras[$notas->nota_promedio_final] }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    @endif

    @if ($tipo === 'reingreso')
        @foreach ($matriculados_reingreso as $item)
            @php
                $matriculado_reingreso_admitido = App\Models\MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $item->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $item->id_programa_proceso_grupo)
                        ->where('matricula_curso.matricula_curso_activo', 1)
                        ->where('matricula_curso.acta_adicional', 0)
                        ->where('matricula_curso.acta_reingreso', 1)
                        ->where('matricula_curso.acta_reincorporacion', 0)
                        ->where('admitido.id_admitido', $item->id_admitido)
                        ->first();
                $reingreso = App\Models\Reingreso::where('id_admitido', $item->id_admitido)->first();
            @endphp
            <header>
                <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <thead>
                        <tr>
                            <th align="left">
                                <div style="display: flex; align-items: center; margin-left: 0px;">
                                    <img src="{{ public_path('assets_pdf/unu.png') }}" width="65px" height="80px" alt="logo unu">
                                </div>
                            </th>
                            <th>
                                <div style="text-align: center">
                                    <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                        UNIVERSIDAD NACIONAL DE UCAYALI
                                    </div>
                                    <div style="margin: 0.2rem"></div>
                                    <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                        ESCUELA DE POSGRADO
                                    </div>
                                </div>
                            </th>
                            <th align="right">
                                <div style="display: flex; align-items: center; margin-right: 0px;">
                                    <img src="{{ public_path('assets_pdf/posgrado.png') }}" width="65px" height="80px" alt="logo posgrado">
                                </div>
                            </th>
                        </tr>
                    </thead>
                </table>
                <div style="margin-top: 0.4rem; text-align: center;">
                    <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                        REGISTRO FINAL DE EVALUACIÓN ACADÉMICA
                    </span>
                </div>
                <div style="margin-top: 0.2rem; text-align: center;">
                    <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                        {{ $admision_año }} - {{ $ciclo }}
                    </span>
                </div>
                <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <tbody>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    {{ $programa }}:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $subprograma }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Mención:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $mencion }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Curso:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $curso }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Cod. Curso:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $codigo_curso }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Docente:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $docente }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Cod. Docente:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $codigo_docente }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Créditos:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $creditos }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Ciclo:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $ciclo }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Grupo:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $grupo }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Tipo de Acta:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    REINGRESO APROBADO CON RESOLUCIÓN N° {{ $reingreso->reingreso_resolucion ?? '___-20__-UNU-CEPG-D' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </header>
            <footer>
                <div style="margin-top: 1.5rem; text-align: right;">
                    <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                        Fecha de emisión: {{ date('d/m/Y') }}
                    </span>
                </div>
                <div style="margin-top: 2.5rem; text-align: right;">
                    <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                        {{ $docente }}
                    </span>
                </div>
                <div style="margin-top: 0rem; text-align: right;">
                    <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                        Responsable del curso
                    </span>
                </div>
            </footer>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem; border-collapse: collapse;">
                <thead>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Nro
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Código
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px; width: 190px;">
                            Alumno
                        </th>
                        <th colspan="3" style="border: 1px solid black; padding: 8px;">
                            Promedios
                        </th>
                        <th colspan="2" style="border: 1px solid black; padding: 8px;">
                            Promedio Final
                        </th>
                    </tr>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Permanente
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Medio Curso
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Final
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Número
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Letras
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $notas = App\Models\NotaMatriculaCurso::where('id_matricula_curso', $matriculado_reingreso_admitido->id_matricula_curso)->first();
                        $letras = array('Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez', 'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve', 'Veinte');
                    @endphp
                    <tr style="border: 1px solid black; padding: 4px; font-size: 0.5rem">
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            1
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $matriculado_reingreso_admitido->admitido_codigo }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;">
                            {{ $matriculado_reingreso_admitido->nombre_completo }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $notas->nota_evaluacion_permanente ? $notas->nota_evaluacion_permanente : '-' }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $notas->nota_evaluacion_medio_curso ? $notas->nota_evaluacion_medio_curso : '-' }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $notas->nota_evaluacion_final ? $notas->nota_evaluacion_final : '-' }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}" align="center">
                            @if ($notas->id_estado_cursos == 4)
                                NSP
                            @else
                                {{ $notas->nota_promedio_final }}
                            @endif
                        </td>
                        <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}">
                            @if ($notas->id_estado_cursos == 4)
                                NSP
                            @else
                                {{ $letras[$notas->nota_promedio_final] }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endif

    @if ($tipo === 'incorporacion')
        @foreach ($matriculados_reincorporacion as $item)
            @php
                $matriculado_reincorporacion_admitido = App\Models\MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $item->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $item->id_programa_proceso_grupo)
                        ->where('matricula_curso.matricula_curso_activo', 1)
                        ->where('matricula_curso.acta_adicional', 0)
                        ->where('matricula_curso.acta_reingreso', 0)
                        ->where('matricula_curso.acta_reincorporacion', 1)
                        ->where('admitido.id_admitido', $item->id_admitido)
                        ->first();
                $reincorporacion = App\Models\Reincorporacion::where('id_admitido', $item->id_admitido)->first();
            @endphp
            <header>
                <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <thead>
                        <tr>
                            <th align="left">
                                <div style="display: flex; align-items: center; margin-left: 0px;">
                                    <img src="{{ public_path('assets_pdf/unu.png') }}" width="65px" height="80px" alt="logo unu">
                                </div>
                            </th>
                            <th>
                                <div style="text-align: center">
                                    <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                        UNIVERSIDAD NACIONAL DE UCAYALI
                                    </div>
                                    <div style="margin: 0.2rem"></div>
                                    <div class="" style="font-weight: 700; font-size: 0.9rem;">
                                        ESCUELA DE POSGRADO
                                    </div>
                                </div>
                            </th>
                            <th align="right">
                                <div style="display: flex; align-items: center; margin-right: 0px;">
                                    <img src="{{ public_path('assets_pdf/posgrado.png') }}" width="65px" height="80px" alt="logo posgrado">
                                </div>
                            </th>
                        </tr>
                    </thead>
                </table>
                <div style="margin-top: 0.4rem; text-align: center;">
                    <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                        REGISTRO FINAL DE EVALUACIÓN ACADÉMICA
                    </span>
                </div>
                <div style="margin-top: 0.2rem; text-align: center;">
                    <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                        {{ $admision_año }} - {{ $ciclo }}
                    </span>
                </div>
                <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <tbody>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    {{ $programa }}:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $subprograma }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Mención:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $mencion }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Curso:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $curso }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Cod. Curso:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $codigo_curso }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Docente:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $docente }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Cod. Docente:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $codigo_docente }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Créditos:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $creditos }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Ciclo:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $ciclo }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Grupo:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $grupo }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 85px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    Tipo de Acta:
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    INCORPORACION APROBADO CON RESOLUCIÓN N° {{ $reincorporacion->reincorporacion_resolucion ?? '___-20__-UNU-CEPG-D' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </header>
            <footer>
                <div style="margin-top: 1.5rem; text-align: right;">
                    <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                        Fecha de emisión: {{ date('d/m/Y') }}
                    </span>
                </div>
                <div style="margin-top: 2.5rem; text-align: right;">
                    <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                        {{ $docente }}
                    </span>
                </div>
                <div style="margin-top: 0rem; text-align: right;">
                    <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                        Responsable del curso
                    </span>
                </div>
            </footer>
            <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem; border-collapse: collapse;">
                <thead>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Nro
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px;">
                            Código
                        </th>
                        <th rowspan="2" style="border: 1px solid black; padding: 8px; width: 190px;">
                            Alumno
                        </th>
                        <th colspan="3" style="border: 1px solid black; padding: 8px;">
                            Promedios
                        </th>
                        <th colspan="2" style="border: 1px solid black; padding: 8px;">
                            Promedio Final
                        </th>
                    </tr>
                    <tr style="border: 1px solid black; padding: 8px; font-size: 0.6rem">
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Permanente
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Medio Curso
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Evaluación<br>Final
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Número
                        </th>
                        <th style="border: 1px solid black; padding: 8px;">
                            Letras
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $notas = App\Models\NotaMatriculaCurso::where('id_matricula_curso', $matriculado_reincorporacion_admitido->id_matricula_curso)->first();
                        $letras = array('Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez', 'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve', 'Veinte');
                    @endphp
                    <tr style="border: 1px solid black; padding: 4px; font-size: 0.5rem">
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            1
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $matriculado_reincorporacion_admitido->admitido_codigo }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;">
                            {{ $matriculado_reincorporacion_admitido->nombre_completo }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $notas->nota_evaluacion_permanente ? $notas->nota_evaluacion_permanente : '-' }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $notas->nota_evaluacion_medio_curso ? $notas->nota_evaluacion_medio_curso : '-' }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            {{ $notas->nota_evaluacion_final ? $notas->nota_evaluacion_final : '-' }}
                        </td>
                        <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}" align="center">
                            @if ($notas->id_estado_cursos == 4)
                                NSP
                            @else
                                {{ $notas->nota_promedio_final }}
                            @endif
                        </td>
                        <td style="border: 1px solid black; padding: 4px; {{ $notas->nota_promedio_final < 14 ? 'color: #ff0000;' : '' }}">
                            @if ($notas->id_estado_cursos == 4)
                                NSP
                            @else
                                {{ $letras[$notas->nota_promedio_final] }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endif
</body>
</html>
