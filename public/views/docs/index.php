
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
        .menu {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 20px;
        }
        
        .menu-item {
            cursor: pointer;
            padding: 5px;
            margin: 5px 0;
            font-weight: bold;
        }
        
        .submenu {
            display: none;
            padding-left: 20px;
        }
        
        .submenu-item {
            padding: 3px;
        }
        .section {
            margin-bottom: 40px;
            padding-top: 60px; /* Espaço para o cabeçalho fixo */
            margin-top: -60px; /* Compensar o padding-top */
        }
    </style>
</head>

<body>

    <header>
        <h1><a href="/"><b>P</b>rod<b>í</b>gio <b>F</b>rame<b>w</b>ork<span class="version"> <?= VESION ?></span></a></h1>
        <p class="paragraph">DOCUMENTAÇÃO</p>
    </header>

    <div class="container">

    <div class="menu">
            <div class="menu-item" onclick="scrollToSection('core')">Core</div>
            <div class="submenu" id="core-submenu">
                <div class="submenu-item" onclick="scrollToSection('configuracao')">Configuração</div>
                <div class="submenu-item" onclick="scrollToSection('roteamento')">Roteamento</div>
                <div class="submenu-item" onclick="scrollToSection('controladores')">Controladores</div>
            </div>
            
            <div class="menu-item" onclick="scrollToSection('models')">Modelos</div>
            <div class="submenu" id="models-submenu">
                <div class="submenu-item" onclick="scrollToSection('abstracao-dados')">Abstração de Dados</div>
                <div class="submenu-item" onclick="scrollToSection('validacao')">Validação</div>
            </div>
            
            <div class="menu-item" onclick="scrollToSection('views')">Visualizações</div>
            <div class="submenu" id="views-submenu">
                <div class="submenu-item" onclick="scrollToSection('templates')">Templates</div>
                <div class="submenu-item" onclick="scrollToSection('componentes')">Componentes</div>
            </div>
            
            <div class="menu-item" onclick="scrollToSection('utils')">Utilitários</div>
            <div class="submenu" id="utils-submenu">
                <div class="submenu-item" onclick="scrollToSection('helpers')">Helpers</div>
                <div class="submenu-item" onclick="scrollToSection('bibliotecas')">Bibliotecas</div>
            </div>
        </div>
        
        <!-- Seções de conteúdo -->
        <section id="core" class="section">
            <h2>Core</h2>
            <p>O núcleo do Prodígio Framework, responsável pelas funcionalidades fundamentais do sistema.</p>
            
            <h3 id="configuracao">Configuração</h3>
            <p>Explica como configurar o framework, incluindo configurações de banco de dados, ambiente e outras opções globais.</p>
            
            <h3 id="roteamento">Roteamento</h3>
            <p>Detalha o sistema de roteamento, como definir rotas e mapear URLs para controladores e ações.</p>
            
            <h3 id="controladores">Controladores</h3>
            <p>Descreve a estrutura e funcionamento dos controladores, responsáveis por processar as requisições e preparar as respostas.</p>
        </section>
        
        <section id="models" class="section">
            <h2>Modelos</h2>
            <p>Camada de abstração de dados e lógica de negócios do framework.</p>
            
            <h3 id="abstracao-dados">Abstração de Dados</h3>
            <p>Explica como trabalhar com modelos para interagir com o banco de dados e encapsular a lógica de negócios.</p>
            
            <h3 id="validacao">Validação</h3>
            <p>Detalha os métodos de validação de dados disponíveis nos modelos para garantir a integridade dos dados.</p>
        </section>
        
        <section id="views" class="section">
            <h2>Visualizações</h2>
            <p>Responsável pela apresentação e interface do usuário no framework.</p>
            
            <h3 id="templates">Templates</h3>
            <p>Explica o sistema de templates, como criar e usar layouts e views para renderizar o conteúdo HTML.</p>
            
            <h3 id="componentes">Componentes</h3>
            <p>Descreve como criar e utilizar componentes reutilizáveis para construir interfaces mais complexas.</p>
        </section>
        
        <section id="utils" class="section">
            <h2>Utilitários</h2>
            <p>Ferramentas e funções auxiliares para facilitar o desenvolvimento.</p>
            
            <h3 id="helpers">Helpers</h3>
            <p>Detalha as funções auxiliares disponíveis para tarefas comuns, como manipulação de strings, datas e arrays.</p>
            
            <h3 id="bibliotecas">Bibliotecas</h3>
            <p>Explica as bibliotecas integradas ao framework e como utilizá-las em seus projetos.</p>
        </section>
    </div>

    <?php include component('footer') ?>
    
    <script>
        function toggleSubmenu(id) {
            var submenu = document.getElementById(id + '-submenu');
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        }
        
        function scrollToSection(id) {
            var element = document.getElementById(id);
            element.scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
        }
    </script>
</body>

</html>
