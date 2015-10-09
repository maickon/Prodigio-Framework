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
    | Passo 4 [apcional] - Digite show e
    | saiba mais sobre o projeto.
    | -------------------------------------------------
    | Digite exit para sair..
    |--------------------------------------------------
    ";
}
$escolha = 0;
$html = file_get_contents(FORM_PAGES_PATH);
while(intval($escolha) != 5):
    display();
    $msg = "Aperte ";
    $escolha = readline("Digite aqui: ");
    switch($escolha):
        case 'make-class': make_class();
        break;

        case 'show': echo shell_exec("php project/sobre.php");
        break;

        case 'exit': exit();
        break;
    endswitch;
    readline("\n{$msg} [ENTER]");
    echo shell_exec("clear");
endwhile;

/*

*/