<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página não encontrada | Prodígio Framework</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 4rem;
            color: #333;
            margin-bottom: 0;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $error ?></h1>
        <p><?= $title ?></p>
        <p><?= $message ?></p>
        <p><a href="/">Voltar para a página inicial</a></p>
    </div>
</body>
</html>