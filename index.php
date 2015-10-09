<?php
/*
**  Prodígio Framework
**  Arquivo de teste para gerar a classe
**  com base no formulario HTML informado a baixo.
*/

require 'autoload.php';
function display(){
    echo
    "
    |--------------------------------------------------
    | [Prodígio Framework]
    | * Instruções:
    | -------------------------------------------------
    | Passo 1 - Crie um formulário HTML
    | dentro da pasta [html_form_pages]
    | e dê nome a todas as tags[OBRIGATÓRIO]
    | -------------------------------------------------
    | Passo 2 - Digite make-class para gerar
    |  as classes conforme o formulairo
    | criado em html_form_pages
    | -------------------------------------------------
    | Passo 3 - Acesse a pasta /generate_class/
    | e veja as classes geradas.
    | -------------------------------------------------
    | Passo 4  - Configure o seu banco de
    | dados, execute db-config e informe:
    | *nome do banco de dados
    | *usuário, senha e host.
    | -------------------------------------------------
    | Digite exit para sair..
    |--------------------------------------------------
    ";
}
$escolha = 0;
$html = file_get_contents(FORM_PAGES_PATH);
while(1):
    display();
    $msg = "Aperte ";
    $escolha = readline("Digite aqui: ");
    switch($escolha):
        case 'make-class': make_class();
        break;

        case 'show': echo shell_exec("php project/sobre.php");
        break;

        case 'db-config':
            $database_name    =  readline("Digite o nome do banco de dados: ");
            $database_user      = readline("Digite o nome do usuário do banco: ");
            $database_pass      = readline("Digite a sua senha de banco de dados: ");
            $database_host      = readline("Informe o hostname ex:[localhost]: ");
            db_config($database_name, $database_user, $database_pass, $database_host);
        break;

        case 'exit': exit();
        break;
    endswitch;
    readline("\n{$msg} [ENTER]");
    echo shell_exec("clear");
endwhile;
