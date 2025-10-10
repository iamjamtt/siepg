<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Reporte de Pagos - {{ $programa }}
    </title>
    <style>
        body {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        header {
            position: fixed;
            top: -20px;
            width: 100%;
        }

        #footer {
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
    <header>
        {{-- <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 0rem;">
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
        </table> --}}
        <div style="margin-top: 0.4rem; text-align: center;">
            <span style="text-align: center; font-weight: 700; font-size: 0.9rem">
                {{ $programa }} - GRUPO {{ $grupo }}
            </span>
        </div>
    </header>
    {{-- <div id="footer">
        <div style="margin-top: 1.5rem; text-align: right;">
            <span style="text-align: center; font-weight: 400; font-size: 0.7rem">
                Fecha de emisión: ___/___/___
            </span>
        </div>
    </div> --}}
    <table class="table" style="width:100%; padding-right: 0rem; padding-left: 0rem; padding-bottom: 0rem; padding-top: 1rem; border-collapse: collapse;">
        <thead>
            <tr style="border: 1px solid black; padding: 6px; font-size: 0.6rem">
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 50px;">
                    Nro
                </th>
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 75px;">
                    Código
                </th>
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 190px;">
                    Alumno
                </th>
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 65px;">
                    Matricula
                </th>
                <th colspan="{{ $mayor }}" style="border: 1px solid black; padding: 6px;">
                    Depositos
                </th>
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 65px;">
                    Costo de Enesñanza
                </th>
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 65px;">
                    Total Pagado
                </th>
                <th rowspan="2" style="border: 1px solid black; padding: 6px; width: 65px;">
                    Deuda
                </th>
            </tr>
            <tr style="border: 1px solid black; padding: 6px; font-size: 0.6rem">
                @if ($mayor == 0)
                    <th style="border: 1px solid black; padding: 6px;">
                        DN° 1
                    </th>
                @else
                    @for ($i = 0; $i < $mayor; $i++)
                        <th style="border: 1px solid black; padding: 6px;">
                            DN° {{ $i + 1 }}
                        </th>
                    @endfor
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $total_costo_ensenanza = 0;
                $total_pagado = 0;
                $total_deuda = 0;
            @endphp
            @foreach ($matriculados as $item)
            @php
                $monto_total = dataPagoMatricula($item->id_admitido, $item->id_matricula)['monto_total'];
                $monto_pagado = dataPagoMatricula($item->id_admitido, $item->id_matricula)['monto_pagado'];
                $deuda = dataPagoMatricula($item->id_admitido, $item->id_matricula)['deuda'];

                $mensualidades = App\Models\Mensualidad::query()
                    ->where('id_matricula', $item->id_matricula)
                    ->where('id_admitido', $item->id_admitido)
                    ->get();
                $cantidad_mensualidades = $mensualidades->count();
                $colspan = $mayor - $cantidad_mensualidades;

                $pago_matricula = App\Models\Pago::query()
                    ->where('id_pago', $item->id_pago)
                    ->first();

                $total_costo_ensenanza += $monto_total;
                $total_pagado += $monto_pagado;
                $total_deuda += $deuda;
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
                        S/: {{ number_format($pago_matricula->pago_monto ?? 0, 2, ',', '.') }}
                    </td>
                    @if ($mayor == 0)
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            -
                        </td>
                    @else
                        @foreach ($mensualidades as $mensualidad)
                        <td style="border: 1px solid black; padding: 4px;" align="center">
                            S/: {{ number_format($mensualidad->pago->pago_monto ?? 0, 2, ',', '.') }}
                        </td>
                        @endforeach
                        @if ($colspan > 0)
                            @for ($i = 0; $i < $colspan; $i++)
                                <td style="border: 1px solid black; padding: 4px;" align="center">
                                    -
                                </td>
                            @endfor
                        @endif
                    @endif
                    <td style="border: 1px solid black; padding: 4px;" align="center">
                        S/: {{ number_format($monto_total, 2, ',', '.') }}
                    </td>
                    <td style="border: 1px solid black; padding: 4px;" align="center">
                        S/: {{ number_format($monto_pagado, 2, ',', '.') }}
                    </td>
                    <td style="border: 1px solid black; padding: 4px; @if ($deuda > 0) color: red; @else color: green; @endif" align="center">
                        S/: {{ number_format($deuda, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="border: 1px solid black; padding: 4px; font-size: 0.5rem">
                <td colspan="{{ $mayor == 0 ? '5' : ($mayor + 4) }}" style="border: 1px solid black; padding: 4px; font-weight: 700;" align="center">
                    TOTAL
                </td>
                {{-- <td style="border: 1px solid black; padding: 4px;" align="center">

                </td>
                @if ($mayor == 0)
                    <td style="border: 1px solid black; padding: 4px;" align="center">

                    </td>
                @else
                    @for ($i = 0; $i < $mayor; $i++)
                        <td style="border: 1px solid black; padding: 4px;" align="center">

                        </td>
                    @endfor
                @endif --}}
                <td style="border: 1px solid black; padding: 4px; font-weight: 700;" align="center">
                    S/: {{ number_format($total_costo_ensenanza, 2, ',', '.') }}
                </td>
                <td style="border: 1px solid black; padding: 4px; font-weight: 700;" align="center">
                    S/: {{ number_format($total_pagado, 2, ',', '.') }}
                </td>
                <td style="border: 1px solid black; padding: 4px; font-weight: 700;" align="center">
                    S/: {{ number_format($total_deuda, 2, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
