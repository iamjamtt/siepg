<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaginaController extends Controller
{
    public array $noticias = [];

    public function __construct()
    {
        $this->noticias = [
            [
                'id' => 1,
                'slug' => Str::slug('PROGRAMA DE ELABORACIÓN DE TESIS EN MEDIO AMBIENTE Y DESARROLLO Y RESPONSABILIDAD SOCIAL'),
                'titulo' => 'PROGRAMA DE ELABORACIÓN DE TESIS EN MEDIO AMBIENTE Y DESARROLLO Y RESPONSABILIDAD SOCIAL',
                'titulo_corto' => Str::limit('PROGRAMA DE ELABORACIÓN DE TESIS EN MEDIO AMBIENTE Y DESARROLLO Y RESPONSABILIDAD SOCIAL', 50),
                'descripcion_md' => <<<'MD'
                    ## ESCUELA DE POSGRADO UNU
                    **LANZA PROGRAMA DE ELABORACIÓN DE TESIS EN MEDIO AMBIENTE Y DESARROLLO Y RESPONSABILIDAD SOCIAL**

                    La Escuela de Posgrado de la **Universidad Nacional de Ucayali** hace de público conocimiento el lanzamiento del **Programa de Actualización – Elaboración de Tesis de Maestría en Medio Ambiente y Desarrollo Sostenible y Responsabilidad Social**, cuyo ciclo académico **presencial y virtual** se iniciará el **12 de septiembre** y culminará el **29 de diciembre** del presente año, informó el **Dr. Walter Fernando Pineda Aguilar**, coordinador general de este programa.

                    La presente directiva alcanza a estudiantes que participan del **programa de actualización del proyecto de tesis** y **elaboración del informe de tesis**; estos deben ser alumnos de la maestría enunciada líneas arriba.

                    La finalidad es que el egresado de la maestría **actualice, elabore y desarrolle** su informe y proyecto de tesis con la **orientación personalizada** de un docente metodólogo en investigación y la **colaboración de un asesor de tesis**, acortando la brecha entre la cantidad de egresados y la cantidad de graduados del programa de maestría en **Medio Ambiente y Desarrollo Sostenible y Responsabilidad Social**.

                    La modalidad de enseñanza será **híbrida** (presencial y virtual), dependiendo de las necesidades de los egresados que requieran atención.

                    La duración de las clases será de **tres horas diarias**. La convocatoria tiene alcance para **cien tesistas**, divididos en grupos de **25**; cada grupo tendrá un **instructor**.

                    **El Programa fue elaborado por:**
                    - Dr. Walter Fernando Pineda Aguilar
                    - Dra. Auristela Chávez Vidalón
                    - Dr. Jorge Luis Hilario Riva
                    - Dr. Wilmer Ortega Chávez

                    Este programa fue **aprobado por el Consejo Universitario** de la Universidad Nacional de Ucayali.
                    MD,
                'descripcion_corto' => Str::limit('La Escuela de Posgrado de la Universidad Nacional de Ucayali hace de público conocimiento el lanzamiento del Programa de Actualización el 29 de diciembre del presente año', 80),
                'imagen' => asset('media/page/noticias/noticia_1.jpg'),
                'fecha' => '07/09/2022',
                'dia' => '07',
                'mes' => 'SEP',
                'anio' => '2022',
                'autor' => 'Autor'
            ],
        ];
    }

    public function inicio()
    {
        $noticias = $this->noticias;
        return view('paginas.inicio', compact('noticias'));
    }

    public function noticia($slug)
    {
        $noticia = null;
        foreach ($this->noticias as $item) {
            if ($item['slug'] === $slug) {
                $noticia = $item;
                break;
            }
        }

        if (!$noticia) {
            abort(404);
        }

        return view('paginas.noticia', compact('noticia'));
    }

    public function mision()
    {
        $mision = <<<'MD'
            ### Misión
            Promueve, orienta y regula el desarrollo de los posgrados académicos de la UNU, garantizando su excelencia académica para la generación de competencias de alto nivel en investigación científica, docencia universitaria, y el mejor desempeño de profesionales altamente calificados en ciencias, tecnología y humanidades con sensibilidad social.
            MD;

        $detalle = [
            'titulo' => 'Misión',
            'descripcion_md' => $mision,
            'fecha' => '06/02/2018',
        ];
        return view('paginas.detalle', compact('detalle'));
    }

    public function vision()
    {
        $vision = <<<'MD'
            ### Visión
            La Escuela de Posgrado de la Universidad Nacional de Ucayali es referente nacional y latinoamericano en el desarrollo de posgrado de alto nivel y excelencia académica en las áreas de competencia de la UNU. Es reconocida como institución nacional que desarrolla investigaciones y aporta nuevos conocimientos que promueven y es líder en el desarrollo sostenible de la Región, comprometida con la conservación y preservación del medio ambiente.
            MD;

        $detalle = [
            'titulo' => 'Visión',
            'descripcion_md' => $vision,
            'fecha' => '06/02/2018',
        ];
        return view('paginas.detalle', compact('detalle'));
    }

    public function objetivos()
    {
        $objetivos = <<<'MD'
            ### Objetivos
            - Formar investigadores calificados, para realizar proyectos científicos, tecnológicos,empresariales, humanísticos e interdisciplinarios; asimismo contribuir al estudio y solución de los problemas locales, regionales y nacionales; en las diferentes áreas del conocimiento de las ciencias involucradas.
            - Promover la consolidación de la formación académica en las distintas áreas del conocimiento, tendiente al mejoramiento de la calidad de la educación superior universitaria.
            MD;

        $detalle = [
            'titulo' => 'Objetivos',
            'descripcion_md' => $objetivos,
            'fecha' => '06/02/2018',
        ];
        return view('paginas.detalle', compact('detalle'));
    }
}
