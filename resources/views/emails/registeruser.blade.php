<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida a JobTrading</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #007BFF;
            font-size: 24px;
        }
        .content {
            font-size: 16px;
        }
        .content p {
            margin-bottom: 16px;
        }
        .cta {
            text-align: center;
            margin-top: 20px;
        }
        .cta a {
            text-decoration: none;
            background: #007BFF;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>¡Hola, <b>{{ $user->name }}</b>!</h2>
        </div>
        <div class="content">
            <p>Bienvenido a <strong>JobTrading</strong>, la plataforma donde puedes ofrecer y buscar trabajo de manera rápida y sencilla.</p>
            <p>Estamos emocionados de tenerte con nosotros.</p>
            <p>Haz clic en el enlace a continuación para empezar:</p>
        </div>
        <div class="cta">
            <a href="https://job-trading.top" target="_blank">Visita JobTrading</a>
        </div>
        <div class="footer">
            <p>Gracias por confiar en nosotros. <br> Cordial saludo, <br> El equipo de JobTrading</p>
        </div>
    </div>
</body>
</html>
