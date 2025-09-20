<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaginaController extends Controller
{
    public array $noticias = [];
    public array $programas = [];
    public array $anuncios = [];

    public function __construct()
    {
        $this->anuncios = [
            [
                'id' => 1,
                'slug' => Str::slug('Maestría en Derecho Constitucional y Administrativo'),
                'nombre' => 'Maestría en Derecho Constitucional y Administrativo',
                'tipo' => 'Maestría',
                'imagen' => asset('media/page/programa/foto_prueba.jpg'),
            ],
        ];

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

        $this->programas = [
            [
                'id' => 1,
                'slug' => Str::slug('Maestría en Derecho Constitucional y Administrativo'),
                'nombre' => 'Maestría en Derecho Constitucional y Administrativo',
                'tipo' => 'Maestría',
                'imagen' => asset('media/page/programa/foto_prueba.jpg'),
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

    public function resena_historica()
    {
        $resena = <<<'MD'
            ### Reseña Histórica
            Mediante Resolución Nº 061-2005-R-UNU del 12 de Febrero del 2005, se designa la Comisión encargada del Estudio y Organización para la creación de la Escuela de Posgrado de la Universidad Nacional de Ucayali, presidida por el Blgo. Mg. Emilio Pascual Valentín.

            Posteriormente, según Resolución Nº 022-2006-CU-R-UNU del 19 de Enero del 2006, el Consejo Universitario propone a la Asamblea Universitaria la creación de la Escuela de Posgrado de la UNU y se nombre una Comisión para que se encargue de elaborar los perfiles del proyecto.

            Mediante Resolución Nº 003-2007-AU-R-UNU del 20 de Enero del 2007, la Asamblea Universitaria aprueba el Proyecto de Creación de la Escuela de Posgrado de la Universidad Nacional de Ucayali. Luego, con Resolución Nº 199-2007-CU-R-UNU del 12 de Junio del 2007, el Consejo Universitario conforma la Comisión Implementadora de la Escuela de Posgrado de la Universidad Nacional de Ucayali presidida por el Ing. M.Sc. Roly Baldoceda Astete y conformada por el Mg. Gustavo Horacio Celi Arévalo y la Mg. Isabel Esteban Robladillo. Posteriormente, según Resolución Nº 3250-2008-CU-R-UNU del 02 de julio del 2008, el Consejo Universitario aprueba el funcionamiento de la Escuela de Posgrado de la UNU y el Desarrollo de las Maestrías iniciales con las menciones en Ciencias de la Computación y Salud Pública.

            **El 05 de diciembre del 2008, la Asamblea Nacional de Rectores mediante Resolución Nº 1079-2008-ANR aprueba la creación y funcionamiento de la Escuela de Posgrado en la Universidad Nacional de Ucayali con sede en la ciudad de Pucallpa**, con los Programas de Maestría en: Ciencias de la Computación, Salud Pública, Medio Ambiente, Gestión Sostenible y Responsable; y Gestión Pública.

            Luego mediante Resolución Nº 864-2009-ANR del 11 de agosto del 2009 se declara que la creación y organización de los Programas de: Maestría en Derecho Constitucional y Administrativo; Maestría en Ciencias Agrícolas, mención Agricultura sostenible; y Maestría en Evaluación y Acreditación de la Calidad de la Educación, en la Escuela de Posgrado de la UNU, se ha realizado de acuerdo con lo previsto en el inciso e) del artículo 92º de la Ley Universitaria Nº 23733. El 04 de Agosto del 2010 por resolución Nº011–CEP–D-UNU se aprueba la creación de la Maestría en Ingeniería de Sistemas, Mención Gestión de Tecnologías de Información.

            Finalmente, mediante Resolución Nº 008-2012-CEP–D-UNU del 08 de febrero del 2012 se aprueba la creación de la Maestría en Gestión Empresarial, Menciones: Auditoria de la Gestión Empresarial. Gestión de Negocios Internacionales y Comercio Exterior, Finanzas para Empresas Financieras, Gestión de Recursos y Costos de Agronegocios, Gestión Tributaria y Fiscal y Gestión de Proyectos de Inversión.
            MD;

        $detalle = [
            'titulo' => 'Reseña Histórica',
            'descripcion_md' => $resena,
            'fecha' => '01/04/2018',
        ];
        return view('paginas.detalle', compact('detalle'));
    }

    public function autoridades()
    {
        $autoridades = <<<'MD'
            ### Autoridades
            MD;

        $detalle = [
            'titulo' => 'Autoridades',
            'descripcion_md' => $autoridades,
            'fecha' => '03/09/2019',
        ];

        $autoridades = [
            [
                'nombre' => 'Mg. Gustavo Horacio Celi Arévalo',
                'cargo' => 'DIRECTOR DE LA ESCUELA DE POSGRADO',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Dra. Auristela Chávez Vidalón',
                'cargo' => 'SECRETARIO ACADÉMICO DE POSGRADO',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ]
        ];

        $directores = [
            [
                'nombre' => 'Mg. Isabel Esteban Robladillo',
                'cargo' => 'FACULTAD DE CIENCIAS DE LA SALUD',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Dr. Jorge Luis Hilario Riva',
                'cargo' => 'FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Dr. Wilmer Ortega Chávez',
                'cargo' => 'FACULTAD DE CIENCIAS FORESTALES Y AMBIENTALES',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Mg. César Augusto Salas Huamán',
                'cargo' => 'FACULTAD DE DERECHO Y CIENCIAS POLÍTICAS',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Mg. Juan Carlos Huamán Huamán',
                'cargo' => 'FACULTAD DE INGENIERÍA DE SISTEMAS E INGENIERÍA CIVIL',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Mg. César Augusto Salas Huamán',
                'cargo' => 'FACULTAD DE EDUCACIÓN Y CIENCIAS SOCIALES',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
            [
                'nombre' => 'Mg. Juan Carlos Huamán Huamán',
                'cargo' => 'FACULTAD DE CIENCIAS AGROPECUARIAS',
                'foto' => asset('media/page/autoridad/avatar_prueba.png'),
            ],
        ];

        return view('paginas.detalle', compact('detalle', 'autoridades', 'directores'));
    }

    public function reglamento()
    {
        $descripcion = <<<'MD'
            ### Reglamentos
            MD;

        $detalle = [
            'titulo' => 'Reglamentos',
            'descripcion_md' => $descripcion,
            'fecha' => '03/09/2019',
        ];

        $reglamentos = [
            [
                'nombre' => 'Reglamento General de la Escuela de Posgrado 2024',
                'archivo' => asset('media/page/reglamento/reglamento_general_2024.pdf'),
                'icono' => asset('media/page/pdf-icon.webp'),
            ],
            [
                'nombre' => 'Reglamento de Grado de la Escuela de Posgrado 2025',
                'archivo' => asset('media/page/reglamento/reglamento_de_grado_2025.pdf'),
                'icono' => asset('media/page/pdf-icon.webp'),
            ]
        ];

        return view('paginas.detalle', compact('detalle', 'reglamentos'));
    }

    public function requisito_ingreso()
    {
        $detalle = [
            'titulo' => 'Requisitos de Ingreso',
            'descripcion_md' => <<<'MD'
                ### Requisitos de ingreso

                > **Nota general:** Todos los archivos deben enviarse en **formato PDF**. Otros formatos no serán aceptados.

                #### Maestría
                - Fotocopia **ampliada** del DNI. En caso de **postulante extranjero**, fotocopia **legalizada** del **carné de extranjería**.
                - Constancia **en línea** otorgada por la **SUNEDU** del **grado académico de bachiller**.
                - **Currículum vítae documentado** (últimos **5 años**).
                - Recibo de pago por **derecho de inscripción**: **S/ 200.00**.

                #### Doctorado
                - Fotocopia **ampliada** del DNI. En caso de **postulante extranjero**, fotocopia **legalizada** del **carné de extranjería**.
                - Constancia **en línea** otorgada por la **SUNEDU** del **grado académico de maestro**.
                - **Currículum vítae documentado** (últimos **5 años**).
                - **Tema tentativo** del **proyecto de tesis**.
                - Recibo de pago por **derecho de inscripción**: **S/ 200.00**.
                MD,
            'fecha' => '06/02/2023',
        ];

        return view('paginas.detalle', compact('detalle'));
    }

    public function procesos_cronogramas()
    {
        $detalle = [
            'titulo' => 'Procesos y Cronogramas',
            'descripcion_md' => <<<'MD'
                ### Procesos y Cronogramas
                MD,
            'fecha' => '06/02/2023',
        ];

        $imagen = asset('media/page/admision/foto_prueba.jpg');
        // $imagen_opcional = null; // Puedes dejarlo como null si no hay imagen opcional
        $imagen_opcional = asset('media/page/admision/foto_prueba.jpg'); // Puedes dejarlo como null si no hay imagen opcional

        return view('paginas.detalle', compact('detalle', 'imagen', 'imagen_opcional'));
    }

    public function costos_modalidades()
    {
        $detalle = [
            'titulo' => 'Costos y Modalidades de Pago',
            'descripcion_md' => <<<'MD'
                ### Costos y Modalidades de Pago
                MD,
            'fecha' => '06/02/2023',
        ];

        $imagen = asset('media/page/admision/foto_prueba.jpg');
        // $imagen_opcional = null; // Puedes dejarlo como null si no hay imagen opcional
        $imagen_opcional = asset('media/page/admision/foto_prueba.jpg'); // Puedes dejarlo como null si no hay imagen opcional

        return view('paginas.detalle', compact('detalle', 'imagen', 'imagen_opcional'));
    }

    public function link_siepg()
    {
        $descripcion = <<<'MD'
            ### Links de los sistemas de la Escuela de Posgrado

            > **Nota general:** Estos enlaces son proporcionados para facilitar el acceso a las plataformas oficiales. Asegúrese de tener sus credenciales de acceso a mano.

            A continuación, se presentan los enlaces directos a los sistemas más utilizados en la Escuela de Posgrado de la Universidad Nacional de Ucayali:
            MD;

        $detalle = [
            'titulo' => 'Links de los sistemas de la Escuela de Posgrado',
            'descripcion_md' => $descripcion,
            'fecha' => '03/09/2019',
        ];

        $links = [
            [
                'nombre' => 'Plataforma de Estudiantes',
                'url' => 'http://posgrado.unu.edu.pe/plataforma/login',
                'icono' => asset('media/page/link-icon.png'),
            ],
            [
                'nombre' => 'Plataforma de Docentes',
                'url' => 'http://posgrado.unu.edu.pe/login',
                'icono' => asset('media/page/link-icon.png'),
            ],
            [
                'nombre' => 'Plataforma Administrativa',
                'url' => 'http://posgrado.unu.edu.pe/login',
                'icono' => asset('media/page/link-icon.png'),
            ]
        ];

        return view('paginas.detalle', compact('detalle', 'links'));
    }
}
