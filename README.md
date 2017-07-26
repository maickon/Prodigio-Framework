<img src="app/assets/img/logo.gif">

# Prodígio Framework

Um simples framework para projetos simples de iniciante.

Com o passar do tempo eu fui reunindo os utilitários que eu escrevia para me ajudar no desenvolvimento de minhas aplicações. Sei que o projeto é bem simples e nem se compara aos frameworks famosos por aí. Mas acredito que de alguma forma este simples framework consiga contribuir com a apredizado de alguém.

O projeto é baseado no modelo MVC e oferecer recursos como geração de código a partir de comandos no termial. Classes de abstração de dados, configuração de rotas e entre outras ferramentas que buscam ajudar no desenvolvimento do projeto.

# Como usar

Para usá-lo você deve ter alguma familiaridade com o conceito de MVC. Caso já tenha mexido com o rails, saiba que esta aplicação tem inspiração nele.

Baixe uma ferramenta para o uso do PHP como Xampp, PhpMyAdmin ou algo similar, Crie um banco de dados com um nome ao seu gosto, abra o código do projeto e preencha as informações adequadas ao seu banco de dados em config/config.php.

No array $_CONFIG você tem a opção de preencher os dados no ambiente local ou de produção. Como você está num ambiente local preencha somente os índices nesta chave do array. Em file_path você coloca o nome da pasta onde seu projeto se encontra, em db você coloca os dados do seu database.

Dentro da pasta config/db eu deixei o arquivo .sql onde eu documentei um pouco sobre esta ferramenta. Sua descrição ainda é simples mas já da para ter uma noção básica ao dar uma olhada.

Para poder usa-lá você terá que importar este arquivo para o seu banco de dados para poder visualizar a documentação, do contrário a página de cocumentação estará vazia.

Qualquer sugestão, participação neste projeto é bem vinda.


# Version 1.4 - 10/06/2017
- Ajustes no arquivo de configuração.
- Configuração de página de erro 404 automática.
- novos metedos de filtro para banco de dados
    *save
    *update
    *delete
    *find_by_nome
    *find_by_nome_and_id
    *find_like_by_nome('ma');
    *find_all
    *find_all_asc
    *find_all_desc
    *find_last
    *find_first
    *find_duplicate_by_name
-Geração de models, views e controller separados pelo console
-Criação de tabelas pelo console com new migration + nome_da_tabela
-Adicionado fuñçao de auto complete no console interativo
-Adicionado atributo $permit no model para filtrar campos vindo do $_REQUEST

# Version 1.5 - 15/07/2017
- Novos métodos na classe db_record
    *find_all_off_dependency
    *find_all_asc_off_dependency
    *find_all_desc_off_dependency
    *find_last_off_dependency
    *find_first_off_dependency
    *find_by_join
- Adicionado parametro de permitir ou não a carga de dependências como objeto numa requisição do banco de dados
