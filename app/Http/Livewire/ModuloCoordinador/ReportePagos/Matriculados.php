<?php

namespace App\Http\Livewire\ModuloCoordinador\ReportePagos;

use App\Exports\Reporte\ModuloCoordinador\ReportePagos\ListaReportePagosAdmitidosExport;
use App\Models\CostoEnseñanza;
use App\Models\Matricula;
use App\Models\Matricula\Matricula as ModelMatricula;
use App\Models\MatriculaGestion;
use App\Models\ProgramaProceso;
use App\Models\ProgramaProcesoGrupo;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class Matriculados extends Component
{
    public $id_programa_proceso;
    public $id_grupo;

    public $search = '';

    public $matriculados = [];
    public $gestionMatricula;

    protected $queryString = [
        'search' => ['except' => ''],
        'gestionMatricula' => ['except' => ''],
    ];

    // public function exportar_excel()
    // {
    //     $programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
    //         ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
    //         ->join('modalidad', 'modalidad.id_modalidad', '=', 'programa.id_modalidad')
    //         ->where('programa_proceso.id_programa_proceso', $this->id_programa_proceso)
    //         ->first();

    //     $mencion = $programa->mencion ? ' con mencion en ' . $programa->mencion : '';
    //     $nombre = 'Reporte de pagos admitidos del ' . $programa->programa . ' en ' . $programa->subprograma . $mencion;
    //     $nombre = Str::slug($nombre, '-');
    //     $nombre = $nombre . '.xlsx';
    //     return Excel::download(new ListaReportePagosAdmitidosExport($this->id_programa_proceso, $this->id_grupo), $nombre);
    // }

    public function render()
    {
        $programa_proceso = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'programa.id_modalidad')
            ->where('programa_proceso.id_programa_proceso', $this->id_programa_proceso)
            ->first();

        // $matriculados = ModelMatricula::query()
        //     ->join('admitido', 'admitido.id_admitido', '=', 'tbl_matricula.id_admitido')
        //     ->join('persona', 'persona.id_persona', '=', 'admitido.id_persona')
        //     ->join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
        //     ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
        //     ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
        //     ->join('pago', 'pago.id_pago', '=', 'tbl_matricula.id_pago')
        //     ->where('programa_proceso.id_programa_proceso', $this->id_programa_proceso)
        //     ->where('tbl_matricula.estado', 1)
        //     ->where(function ($query) {
        //         $query->where('persona.nombre_completo', 'like', '%' . $this->search . '%')
        //             ->orWhere('persona.numero_documento', 'like', '%' . $this->search . '%')
        //             ->orWhere('admitido.admitido_codigo', 'like', '%' . $this->search . '%');
        //     })
        //     ->orderBy('persona.nombre_completo', 'asc')
        //     ->get();

        // $matriculadosNew = collect();

        // foreach ($matriculados as $matriculado) {
        //     ///
        //     $grupo = obtenerGrupoDeMatricula($matriculado->id_matricula);
        //     $grupoDetalle = ProgramaProcesoGrupo::query()
        //         ->where('id_programa_proceso_grupo', $this->id_grupo)
        //         ->first()
        //         ->grupo_detalle;
        //     if ($grupo == $grupoDetalle) {
        //         $matriculadosNew->push($matriculado);
        //     }
        // }

        if ($this->gestionMatricula) {
            $this->calcularMatriculados($this->gestionMatricula);
        } else if ($this->gestionMatricula == '0') {
            $this->calcularMatriculados(null);
        }

        $gestionesMatricula = MatriculaGestion::query()
            ->where('id_programa_proceso', $this->id_programa_proceso)
            ->where('matricula_gestion_estado', 1)
            ->get();

        $tienePrimerCiclo = false;

        foreach ($gestionesMatricula as $gestionMatricula) {
            if ($gestionMatricula->id_ciclo == 1) {
                $tienePrimerCiclo = true;
            }
        }

        return view('livewire.modulo-coordinador.reporte-pagos.matriculados', [
            'programa_proceso' => $programa_proceso,
            // 'matriculados' => $matriculadosNew,
            'gestionesMatricula' => $gestionesMatricula,
            'tienePrimerCiclo' => $tienePrimerCiclo,
        ]);
    }

    public function mount()
    {
        $this->matriculados = collect();

        $ultimaGestioneMatricula = MatriculaGestion::query()
            ->where('id_programa_proceso', $this->id_programa_proceso)
            ->where('matricula_gestion_estado', 1)
            ->orderBy('id_ciclo', 'desc')
            ->first();

        if ($ultimaGestioneMatricula) {
            $this->gestionMatricula = $ultimaGestioneMatricula->id_matricula_gestion;
            $this->calcularMatriculados($ultimaGestioneMatricula->id_matricula_gestion);
        } else {
            $this->calcularMatriculados(null);
        }
    }

    public function calcularMatriculados($id_matricula_gestion)
    {
        $matriculados = ModelMatricula::query()
            ->join('admitido', 'admitido.id_admitido', '=', 'tbl_matricula.id_admitido')
            ->join('persona', 'persona.id_persona', '=', 'admitido.id_persona')
            ->join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
            ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
            ->join('pago', 'pago.id_pago', '=', 'tbl_matricula.id_pago')
            ->where('programa_proceso.id_programa_proceso', $this->id_programa_proceso)
            // ->where(function ($query) use ($id_matricula_gestion) {
            //     if ($id_matricula_gestion) {
            //         $query->where('tbl_matricula.id_matricula_gestion', $id_matricula_gestion);
            //     } else {
            //         $query->where('tbl_matricula.id_matricula_gestion', null);
            //     }
            // })
            ->where('tbl_matricula.id_matricula_gestion', $id_matricula_gestion)
            ->where('tbl_matricula.estado', 1)
            ->where(function ($query) {
                $query->where('persona.nombre_completo', 'like', '%' . $this->search . '%')
                    ->orWhere('persona.numero_documento', 'like', '%' . $this->search . '%')
                    ->orWhere('admitido.admitido_codigo', 'like', '%' . $this->search . '%');
            })
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();

        $matriculadosNew = collect();

        foreach ($matriculados as $matriculado) {
            ///
            $grupo = obtenerGrupoDeMatricula($matriculado->id_matricula);
            $grupoDetalle = ProgramaProcesoGrupo::query()
                ->where('id_programa_proceso_grupo', $this->id_grupo)
                ->first()
                ->grupo_detalle;
            if ($grupo == $grupoDetalle) {
                $matriculadosNew->push($matriculado);
            }
        }

        $this->matriculados = $matriculadosNew;
    }

    // public function getMatriculados
}
