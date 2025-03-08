<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Record Académico
    </title>
    <style>
        body {
            margin-top: 135px;
            margin-bottom: 80px;
        }

        header {
            position: fixed;
            top: -10px;
            width: 100%;
        }

        #footer {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: -10px;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
            <thead>
                <tr>
                    <th align="left">
                        <div style="display: flex; align-items: center; margin-left: 0px;">
                            <img src="{{ public_path('assets_pdf/unu.png') }}" width="65px" height="80px"
                                alt="logo unu">
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
                            <img src="{{ public_path('assets_pdf/posgrado.png') }}" width="65px" height="80px"
                                alt="logo posgrado">
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 0.5rem; text-align: center;">
            <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                RECORD ACADÉMICO
            </span>
        </div>
    </header>
    <div id="footer">
        <div style="margin-top: 1.9rem; text-align: right;">
            <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                Record Académico - {{ date('d/m/Y') }}
            </span>
        </div>
    </div>
    <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
        <tr>
            <td style="width: 50%;">
                <table class="table"
                    style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <tr>
                        <td style="width: 80px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                {{ $admitido->programa_proceso->programa_plan->programa->programa }}
                            </div>
                        </td>
                        <td style="width: 20px;">
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                :
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $admitido->programa_proceso->programa_plan->programa->subprograma }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @if ($admitido->programa_proceso->programa_plan->programa->mencion)
        <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
            <tr>
                <td>
                    <table class="table"
                        style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                        <tr>
                            <td style="width: 80px;">
                                <div style="font-weight: 700; font-size: 0.7rem;">
                                    MENCION
                                </div>
                            </td>
                            <td style="width: 20px;">
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    :
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 400; font-size: 0.7rem;">
                                    {{ $admitido->programa_proceso->programa_plan->programa->mencion }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @endif
    <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
        <tr>
            <td widht="50%">
                <table class="table"
                    style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <tr>
                        <td style="width: 80px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                ALUMNO
                            </div>
                        </td>
                        <td style="width: 20px;">
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                :
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $admitido->persona->nombre_completo }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
        <tr>
            <td>
                <table class="table"
                    style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <tr>
                        <td style="width: 80px;">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                CODIGO
                            </div>
                        </td>
                        <td style="width: 20px;">
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                :
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ $admitido->admitido_codigo }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table"
                    style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
                    <tr>
                        <td align="right">
                            <div style="font-weight: 700; font-size: 0.7rem;">
                                FECHA
                            </div>
                        </td>
                        <td align="right" style="width: 20px;">
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                :
                            </div>
                        </td>
                        <td align="right" style="width: 80px;">
                            <div style="font-weight: 400; font-size: 0.7rem;">
                                {{ date('d/m/Y') }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="width:100%; padding-right: 0rem; padding-left: 0rem; margin-bottom: 0.5rem; margin-top: 0.5rem; border-style: solid; border-width: 0.25px; border-color: black; border-collapse: collapse;">
    </div>
    {{-- <div style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0.5rem; text-align: center;">
        <span style="text-align: center; font-weight: 700; font-size: 0.7rem; font-style: italic;">
            PLAN DE ESTUDIOS {{ $plan->plan }} / {{ $plan->plan_resolucion }}
            {{ date('d/m/Y', strtotime($plan->plan_fecha_resolucion)) }}
        </span>
    </div> --}}
    @foreach ($ciclos as $item)
        @php
            $cursos = App\Models\CursoProgramaPlan::query()
                ->join('curso', 'curso.id_curso', '=', 'curso_programa_plan.id_curso')
                ->where('curso_programa_plan.id_programa_plan', $programa->id_programa_plan)
                ->where('curso.id_ciclo', $item->id_ciclo)
                ->get();
        @endphp
        <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0.5rem;">
            <tr>
                <td widht="50%">
                    <span style="font-weight: 700; font-size: 0.7rem;">
                        CICLO - {{ $item->ciclo }}
                    </span>
                </td>
                <td width="50%" align="right">
                    {{-- @php
                        $promedio = 0;
                    @endphp
                    @foreach ($cursos as $curso)
                    @php
                        $data = App\Models\Matricula\MatriculaCurso::query()
                            ->join('matricula_curso', 'matricula_curso.id_matricula_curso', '=', 'nota_matricula_curso.id_matricula_curso')
                            ->join('matricula', 'matricula.id_matricula', '=', 'matricula_curso.id_matricula')
                            ->join('programa_proceso_grupo', 'programa_proceso_grupo.id_programa_proceso_grupo', '=', 'matricula.id_programa_proceso_grupo')
                            ->where('matricula_curso.id_curso_programa_plan', $curso->id_curso_programa_plan)
                            ->where('matricula.id_admitido', $admitido->id_admitido)
                            ->first();
                        $promedio += $data ? $data->nota_promedio_final : 0;
                    @endphp
                    @endforeach
                    <span style="font-weight: 700; font-size: 0.5rem;">
                        PPC: {{ $promedio > 0 ? round($promedio / count($cursos), 2) : 0 }}
                    </span> --}}
                </td>
            </tr>
        </table>
        <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem; border-collapse: collapse;">
            <thead>
                <tr style="border: 1px solid black; padding: 7px; font-size: 0.5rem;">
                    <th>PPA: {{ calcularPPA($admitido, $item) }}</th>
                    <th>PPS: {{ calcularPPS($admitido, $item) }}</th>
                    <th></th>
                    <th>CA:</th>
                    <th>{{ calcularCA($admitido, $item) }}</th>
                    <th></th>
                    <th>CAA:</th>
                    <th>{{ calcularCAA($admitido, $item) }}</th>
                </tr>
                <tr style="border: 1px solid black; padding: 7px; font-size: 0.5rem; background: {{ $color }}">
                    <th style="border: 1px solid black; padding: 7px;">
                        CODIGO
                    </th>
                    <th style="border: 1px solid black; padding: 7px; width: 190px;">
                        CURSO
                    </th>
                    <th style="border: 1px solid black; padding: 7px;">
                        FECHA
                    </th>
                    <th style="border: 1px solid black; padding: 7px;">
                        GRUPO
                    </th>
                    <th style="border: 1px solid black; padding: 7px;">
                        CRED.
                    </th>
                    <th style="border: 1px solid black; padding: 7px;">
                        PERIODO
                    </th>
                    <th style="border: 1px solid black; padding: 7px;">
                        NOTA
                    </th>
                    <th style="border: 1px solid black; padding: 7px;">
                        ESTADO
                    </th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                @foreach ($cursos as $curso)
                    @php
                        $matriculaCurso = App\Models\Matricula\MatriculaCurso::query()
                            ->with([
                                'matricula' => function($query) use ($admitido) {
                                    $query->where('id_admitido', $admitido->id_admitido);
                                },
                                'programaProcesoGrupo',
                                'docente'
                            ])
                            ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                            ->whereHas('matricula', function($query) use ($admitido) {
                                $query->where('id_admitido', $admitido->id_admitido);
                            })
                            ->orderBy('id_matricula_curso', 'desc')
                            ->first();
                    @endphp
                    <tr style="padding: 4px; font-size: 0.5rem">
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;" align="center">
                            {{ $curso->curso_codigo }}
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;">
                            {{ $curso->curso_nombre }}
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;" align="center">
                            @if ($matriculaCurso)
                                {{ $matriculaCurso->fecha_ingreso_nota ? date('d/m/Y', strtotime($matriculaCurso->fecha_ingreso_nota)) : '---' }}
                            @else
                                ---
                            @endif
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;" align="center">
                            {{ $matriculaCurso ? $matriculaCurso->programaProcesoGrupo->grupo_detalle : '---' }}
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;" align="center">
                            {{ $curso->curso_credito }}
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;" align="center">
                            {{ $matriculaCurso ? $matriculaCurso->periodo : '---' }}
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px; font-weight: 700;" align="center">
                            @if ($matriculaCurso && $matriculaCurso->nota_promedio_final)
                                {{ number_format($matriculaCurso->nota_promedio_final, 0) }}
                            @else
                                ---
                            @endif
                        </td>
                        <td style="border-right: 1px solid black; border-left: 1px solid black; padding: 4px;" align="center">
                            @if ($matriculaCurso && $matriculaCurso->estado == 1)
                                PENDIENTE
                            @elseif ($matriculaCurso && $matriculaCurso->estado == 3)
                                NSP
                            @elseif ($matriculaCurso && $matriculaCurso->estado == 2)
                                APROBADO
                            @elseif ($matriculaCurso && $matriculaCurso->estado == 0)
                                DESAPROBADO
                            @else
                                PENDIENTE
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    <div style="position: absolute; right: 170px; top: 130px;">
        <img src="{{ public_path('assets_pdf/sello-posgrado.png') }}" width="110px" alt="sello posgrado">
    </div>
</body>

</html>
