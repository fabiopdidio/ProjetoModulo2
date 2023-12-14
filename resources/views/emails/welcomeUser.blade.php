<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao TrainSys</title>
</head>
<body>
    <div class="welcome-container">
        <h3>Bem-vindo ao TrainSys</h3>
        <p>
            Olá, <strong>{{ $name }}</strong>!<br>
            Seja Bem-vindo ao TrainSys!<br>
            Você escolheu o plano <strong>{{ $plan }}.</strong> <br>
            O plano te dá direito a cadastrar <strong>{{ $limit }} alunos</strong>.
        </p>
    </div>
</body>
<style>
    body {
        font-family: 'Arial', sans-serif;
        text-align: center;
        background-color: #f4f4f4;
        padding: 20px;
    }

    .welcome-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h3 {
        color: #3498db;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
    }
</style>
</html>
