<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matricula</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #18181b;
            /* zinc-900 */
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            font-size: 14px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 120px;
            width: 100%;
            height: auto;
        }

        h1 {
            color: #18181b;
            text-align: center;
            margin-bottom: 30px;
            font-size: 18px;
        }

        .greeting {
            font-size: 14px;
            color: #18181b;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #d4d4d8;
            /* zinc-200 */
        }

        th {
            background-color: #f7fee7;
            /* lime-100 */
            font-weight: bold;
            color: #18181b;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #52525b;
            /* zinc-600 */
            font-size: 12px;
        }

        h2 {
            color: #18181b;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            h1 {
                font-size: 16px;
            }

            .greeting {
                font-size: 12px;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 8px;
            }

            h2 {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="https://www.unu.edu.pe/posgrado/images/LogoPosgradoSF.png" alt="Logo EPG" class="logo"
            style="width: 70px; height: 85px;">
        <h1>Escuela de Posgrado</h1>
        <p class="greeting">
            Estimado(a), {{ $nombre }}:
        </p>
        <p>
            ¡Gracias por Matricularte!
        </p>
        <p>
            Nos complace informarte que se ha generado exitosamente su ficha de matrícula. Agradecemos tu interés en
            nuestro programa y estamos entusiasmados por brindarte una experiencia educativa valiosa.
        </p>
        <p>
            Adjunto a este correo, encontrarás el detalle de tu ficha de matrícula. Si tienes alguna pregunta o
            necesitas más información, por favor no dudes en contactarnos. Estamos aquí para ayudarte.
        </p>
        <div class="footer">
            <p>Atentamente,</p>
            <p>Universidad Nacional de Ucayali</p>
            <p>Escuela de Posgrado</p>
        </div>
    </div>
</body>

</html>
