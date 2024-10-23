ENTIDADES DO SISTEMA

ADMINISTRADOR
    ID
    NOME
    E-MAIL
    SENHA
    CRIADO EM
    ATUALIZADO EM

CLIENTE
    ID
    NOME 
    CPF/CNPJ
    NASCIMENTO
    WHATSAPP
    TELEFONE
    E-MAIL
    ENDERECO
    COMPLEMENTO
    BAIRRO
    CIDADE
    ESTADO
    CEP

PEDIDO
    ID
    CLIENTE ID
    MARCA
    CODIGO PRODUTO
    CATEGORIA
    NOME PRODUTO
    TAMANHO
    COR
    PREÇO ATACADO
    TAXA CNPJ
    ASSESSORIA
    STATUS
    FOTO DA PECA
    CODIGO DA PECA
    CRIADO EM
    ATUALIZADO EM

CATEGORIAS
    ID
    NOME
    CRIADO EM
    ATUALIZADO EM

NOME DO PRODUTO
    ID
    NOME
    CRIADO EM
    ATUALIZADO EM

TAMANHO
    ID
    TAMANHO
    CRIADO EM
    ATUALIZADO EM

COR
    ID
    NOME
    CRIADO EM

PRECISO DE RELATORIO POR MARCA, POR DATA, POR CLIENTE OK
RELATORIO DE ANIVERSARIO
RELATORIO DE CLIENTES EM DEBITO


Tabelas Principais
Administrador
    id (PK): Identificador único do administrador.
    nome: Nome completo.
    email: E-mail.
    senha: Senha.
    criado_em: Data de criação.

Clientes
    cliente_id (PK): Identificador único do cliente.
    nome: Nome completo.
    cpf_cnpj: CPF ou CNPJ (dependendo do tipo de cliente).
    data_nascimento: Data de nascimento do cliente.
    whatsapp: Número de WhatsApp.
    telefone: Telefone alternativo.
    email: E-mail.
    endereco: Endereço completo.
    complemento: Complemento do endereço.
    bairro: Bairro.
    cidade: Cidade.
    estado: Estado.
    cep: Código Postal.
    status: Status do cliente (Em Dia, Inadimplente).
    criado_em: Data de criação.

Pedidos
    pedido_id (PK): Identificador único do pedido.
    cliente_id (FK): Referência ao cliente que fez o pedido.
    nome_id (FK): Nome do produto (Blusa, Saia, etc.).
    marca_id (FK): Referência à marca do pedido.
    tamanho_id (FK): Tamanho da peça (Dependendo da categoria).
    cor_id (FK): Cor da peça.
    status: Status do pedido (Comprado, Embalado, Enviado, Entregue).
    tipo_envio: Tipo de envio (PAC, SEDEX, Aéreo, Motoboy, Excursão, Transportadora).
    custo_envio: Custo do envio.
    codigo_produto: Código do produto.
    quantidade: Quantidade da peça.
    preco: Preço da peça.
    foto: URL ou nome da imagem da peça (com preço e código visíveis).
    criado_em: Data de criação.

Nomes
    nome_id (PK): Identificador único do nome do produto.
    nome: Nome do produto (Blusa, Saia, etc.).
    criado_em: Data de criação.

Categorias
    categoria_id (PK): Identificador único da categoria.
    nome: Nome da categoria (Roupa, Moda Praia, Pijamas, Acessório, etc.).
    criado_em: Data de criação.

Tamanhos
    tamanho_id (PK): Identificador único do tamanho.
    categoria_id (FK): Referência à categoria que define os tamanhos disponíveis.
    nome: Nome do tamanho (P, M, G, 34, 36, etc.).
    criado_em: Data de criação.

Marcas
    marca_id (PK): Identificador único da marca.
    taxa_id (FK)
    nome: Nome da marca.
    criado_em: Data de criação.

Taxas
    taxa_id (PK): Identificador único da taxa.
    nome: Nome da taxa (Taxa CNPJ, Taxa ICMS, Taxa Assessoria).
    taxa_cnpj: Taxa associada à marca (se aplicável).
    taxa_icms: Taxa de ICMS aplicável.
    taxa_assessoria: Valor da assessoria.
    criado_em: Data de criação.

7. Relatórios
    Relacionamentos podem ser definidos com base em queries utilizando os dados de Pedidos, Peças, Clientes, e Marcas, permitindo relatórios detalhados como:
    Relatório por marca.
    Relatório por data.
    Relatório de aniversários.
    Relatório de clientes inadimplentes.
    Exemplo de Diagrama de Entidade-Relacionamento (ER):


Copiar código
Clientes (1) --------- (n) Pedidos
Pedidos (1) ---------- (n) Peças
Pedidos (n) ---------- (1) Marcas
Peças (n) ------------ (1) Categorias
Categorias (1) ------- (n) Tamanhos

Regras de Preenchimento
Taxa CNPJ: Somente é cobrada se o produto for "Blusa" ou "Saia".
Assessoria: Campo apenas informativo, com base na marca configurada.
Pedido mínimo de R$500: A compra só pode ser finalizada se o valor total do pedido for superior a R$500.
Campos controlados: O cliente só pode preencher categorias e nomes de produto pré-definidos, com tamanhos variáveis conforme a categoria selecionada.
Foto do produto: Apenas uma foto permitida, e deve conter o preço e o código do produto visíveis.
Essa estrutura de banco de dados oferece flexibilidade para expandir as opções de produtos e controle sobre as regras de negócios, como taxas e categorias de produtos.