<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class ProcessEnvioFichaMatricula implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data, $nombre, $correo;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $nombre, $correo)
    {
        $this->data = $data;
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // generar pdf
        $pdf = PDF::loadView('modulo-plataforma.matriculas.ficha-matricula', $this->data);
        $pdf_email = $pdf->output();

        // datos del correo
        $detalle = [
            'correo' => $this->correo,
            'nombre' => $this->nombre
        ];

        $nombre_pdf = 'Ficha de Matrícula - Escuela de Posgrado.pdf';

        Mail::send('modulo-plataforma.matriculas.email', $detalle, function ($message) use ($detalle, $pdf_email, $nombre_pdf) {
            $message->to($detalle['correo'])
                    ->subject('Ficha de Matrícula - Escuela de Posgrado')
                    ->attachData($pdf_email, $nombre_pdf, ['mime' => 'application/pdf']);
        });
    }
}
