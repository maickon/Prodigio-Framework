<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/icon.png">
    <title>Prodigio Framework</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/home.css">
</head>
<body>
	<?php include component('header') ?>
    <!-- <header>
        <h1><b>P</b>rod<b>í</b>gio <b>F</b>rame<b>w</b>ork<span class="version">V1.2</span></h1>
        <p>Construa seu próximo projeto com facilidade</p>
    </header> -->
    <div class="content">
        <h2>Bem-vindo ao <b class="logo">Prodigio Framework</b></h2>
        <p>
            Prodigio Framework é um framework simples e acessível, ideal para iniciantes. Nascido da reunião de utilitários desenvolvidos ao longo do tempo, este projeto visa facilitar o aprendizado e o desenvolvimento de aplicações.
        </p>
       	<p>
       		Baseado no modelo MVC, oferece recursos como, classes de abstração de dados, configuração de rotas e outras ferramentas úteis para criar projetos de forma rápida sem muitas depenências.
       	</p>
    
        <?php include component('exemple') ?>

        <div class="buttons">
            <a href="/docs">Iniciar</a>
            <a href="/tutorial">Tutorial</a>
        </div>
    </div>
 
    <?php include component('footer') ?>
</body>
</html>
