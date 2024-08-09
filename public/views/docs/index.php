
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/youtube-api/icon.png">
    <link rel="icon" href="/assets/img/icon.png">
    <title>Prodigio Framework</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/fonts.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4F20B6;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2em;
            font-family: 'CaptainFalconGradientItalic';
        }

        h1 a {
            text-decoration: none;
            color: #FFF;
        }

        .version {
            font-family: 'Arial';
            font-size: 12px;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4F20B6;
            border-bottom: 2px solid #4F20B6;
            padding-bottom: 5px;
        }

        .section {
            margin-bottom: 40px;
        }

        .code-block {
            background-color: #f4f4f4;
            border-left: 4px solid #4F20B6;
            padding: 10px;
            margin: 10px 0;
            font-family: "Courier New", Courier, monospace;
            overflow-x: auto;
        }

        .endpoint {
            background-color: #e7f3ff;
            border-left: 4px solid #007acc;
            padding: 10px;
            margin: 10px 0;
            font-family: "Courier New", Courier, monospace;
            overflow-x: auto;
        }

        .note {
            background-color: #fffbcc;
            border-left: 4px solid #ffeb3b;
            padding: 10px;
            margin: 10px 0;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }
        footer a {
            text-decoration: none;
            color: #FFF;
        }
        .paragraph {
            margin: 0;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <header>
        <h1><a href="/"><b>P</b>rod<b>í</b>gio <b>F</b>rame<b>w</b>ork<span class="version"> <?= VESION ?></span></a></h1>
        <p class="paragraph">DOCUMENTAÇÃO</p>
    </header>

    <div class="container">

        <section class="section">
            <h2>Introdução</h2>
            <p>O conceito deste projeto é criar um framework que seja simples o bastante para que iniciantes consigam entende-lo. Além disso, o projeto é uma coleção ideias que vim reunindo ao longo dos anos de desenvolvimento web.</p>
            <p>O projeto é baseado no modelo MVC e oferecer recursos como classes de abstração de dados, configuração de rotas, views e entre outras ferramentas que buscam ajudar no desenvolvimento do projeto.</p>
        </section>

        <section class="section">
            <h2>Como usar</h2>
            <p>Para usá-lo você deve ter alguma familiaridade com o conceito de MVC. Caso já tenha mexido com o rails, saiba que esta aplicação tem inspiração nele.</p>
            <p>A sua documentação busca explicar de forma geral o objetivo de cada módulo do projeto. Ele não busca explicar em detalhes cada linha de código. O intuito é fazer com que você tenha uma ideia geral e por análise própria do código, consiga entender o que está sendo feito.</p>
        </section>

        <section class="section">
            <h2>Instalação</h2>
            <p>O código fonte está disponível no GitHub. Para instalar e configurar a API, siga as instruções fornecidas no repositório.</p>
        </section>
    </div>

    <?php include component('footer') ?>

</body>

</html>
