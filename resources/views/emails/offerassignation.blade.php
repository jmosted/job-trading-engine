<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceptación de solicitud de oferta de trabajo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #007BFF;
            font-size: 22px;
        }
        p {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .cta a {
            text-decoration: none;
            color: #ffffff;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>¡Hola, <b>{{$user->name}}</b>!</h2>
    <p>Te informamos que se ha aceptado tu solicitud de asignación a la oferta: <strong>{{$offer->name}}</strong>.</p>
    <p>Para ver los detalles de la solicitud, haz clic en el botón a continuación:</p>
    <div class="cta">
        <a href="http://job-trading.top" target="_blank">Ver solicitud</a>
    </div>
    <p>Gracias por usar <strong>JobTrading</strong>. Estamos aquí para ayudarte a conectar con las mejores oportunidades.</p>
    <div class="footer">
        <p>El equipo de JobTrading</p>
    </div>
</body>
</html>
