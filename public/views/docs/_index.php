<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação do Framework Prodigio</title>
    <link rel="stylesheet" href="/assets/css/docs.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#introducao">Introdução</a></li>
                <li><a href="#instalacao">Instalação</a></li>
                <li><a href="#conceitos-basicos">Conceitos Básicos</a></li>
                <li><a href="#rotas">Rotas</a></li>
                <li><a href="#abstracao-de-dados">Abstração de Dados</a></li>
                <li><a href="#exemplos">Exemplos</a></li>
                <li><a href="#api-referencia">API Referência</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="introducao">
            <h1>Introdução</h1>
            <p>Bem-vindo à documentação do Prodigio Framework. Este framework foi criado para ajudar desenvolvedores iniciantes a construir seus projetos com facilidade.</p>
        </section>

        <section id="instalacao">
            <h2>Instalação</h2>
            <p>Para instalar o Prodigio Framework é bem simples. Baixe o código do projeto em: <a href="https://github.com/maickon/Prodigio-Framework">https://github.com/maickon/Prodigio-Framework</a>, renomeie a pasta para o seu nome do projeto. Entre na pasta via terminal e dê o comando para startar o servidor PHP.</p>
            
        </section>

        <section id="conceitos-basicos">
            <h2>Conceitos Básicos</h2>
        <p>O Prodigio Framework possui uma estrutura de diretórios organizada para facilitar o desenvolvimento de aplicações web, seguindo o padrão MVC (Model-View-Controller). Abaixo estão descritos os principais diretórios e seus respectivos conteúdos:</p>
        
        <h3>Estrutura de Diretórios do Sistema</h3>
        <ul>
            <li><strong>\App\Controllers</strong>
                <p>Contém os controladores que gerenciam a lógica de negócio e interação entre o modelo e a visão.</p>
                <pre><code class="php">namespace App\Controllers;

use core\Controller;
use core\TemplateTags;

class HomeController extends Controller {
    public function index() {
        $this->view('home', ['html' => new TemplateTags()]);
    }

    public function docs() {
        $this->view('docs');
    }
}</code></pre>
            </li>
            <li><strong>\App\Helpers</strong>
                <p>Armazena classes auxiliares com métodos utilitários para serem usados em diferentes partes do sistema.</p>
            </li>
            <li><strong>\App\Middlewares</strong>
                <p>Contém middlewares que implementam regras de negócio para serem aplicadas nas rotas.</p>
                <pre><code class="php">class Middlewares {
    public function hasLogin() {
        return SessionManager::get('user') ? true : false;
    }
}</code></pre>
            </li>
            <li><strong>\App\Models</strong>
                <p>Contém as classes de modelos que representam e manipulam os dados do banco de dados.</p>
                <pre><code class="php">namespace App\Models;

use core\ActiveRecord;

class UserExemple extends ActiveRecord {
    protected $table_name = 'usersExemple';

    public function save($user) {
        return $this->insert($user, 'email');
    }

    public function remove($id) {
        return $this->delete($id);
    }

    public function edit($id, $data, $return = false) {
        return $this->update($id, $data, $return);
    }

    public function getUserById($id) {
        return $this->find($id);
    }

    public function getUser($field, $value) {
        return $this->findByField($field, $value);
    }

    public function getAllUsers() {
        return $this->findAll();
    }
}</code></pre>
            </li>
            <li><strong>\App\Temp</strong>
                <p>Armazena arquivos temporários necessários para o funcionamento do sistema.</p>
            </li>
            <li><strong>\App\Tests</strong>
                <p>Contém os testes do sistema para garantir a qualidade do código.</p>
            </li>
            <li><strong>\config</strong>
                <p>Armazena arquivos de configuração, como configurações de banco de dados e definições do aplicativo.</p>
            </li>
            <li><strong>\core</strong>
                <p>Contém classes essenciais para o funcionamento do framework, como gerenciamento de sessão, roteamento, validação, etc.</p>
            </li>
            <li><strong>\public</strong>
                <p>Diretório onde o aplicativo roda. Contém os recursos acessíveis publicamente.</p>
                <ul>
                    <li><strong>\public\assets</strong>: Armazena arquivos estáticos como CSS, JS e imagens.</li>
                    <li><strong>\public\components</strong>: Contém componentes reutilizáveis da interface.</li>
                    <li><strong>\public\uploads</strong>: Armazena arquivos enviados pelo usuário.</li>
                    <li><strong>\public\views</strong>: Armazena as páginas de visualização do sistema.</li>
                </ul>
            </li>
            <li><strong>\public\index.php</strong>
                <p>Ponto de entrada do aplicativo. Carrega o arquivo <code>init.php</code> localizado na raiz do sistema.</p>
            </li>
        </ul>

        <h3>Arquivos de Inicialização e Autoload</h3>
        <p>O arquivo <code>autoload.php</code> carrega automaticamente as classes do sistema:</p>
        <pre><code class="php">class Autoloader {
    public static function register() {
        spl_autoload_register(function ($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        });
    }
}

Autoloader::register();</code></pre>
        <p>O arquivo <code>init.php</code> inicializa as dependências básicas do sistema:</p>
        <pre><code class="php">define('ROOT_DIR', __DIR__);
define('DATABASE_DIR', __DIR__ . '/database/');

require __DIR__ . '/core/functions.php';
require __DIR__ . '/autoload.php';

use core\SessionManager;
use core\Router;

SessionManager::start();
require __DIR__ . '/routers/ajax.php';
require __DIR__ . '/routers/api.php';
require __DIR__ . '/routers/web.php';

Router::handleRequest();</code></pre>

        <h3>Roteamento</h3>
        <p>As rotas são definidas em arquivos separados para a web, API e AJAX.</p>
        <p>Exemplo de rota com middleware:</p>
        <pre><code class="php">Router::addRoute('/caminho/{id}', function() use ($middlewares) {
    if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
        Router::controller('MeuController@metodo');
    } else {
        Router::route(__DIR__ . '/../public/views/home/404.php');
    }
});</code></pre>
        </section>

        <section id="rotas">
            <h2>Rotas</h2>
            <p>Configurando rotas no Prodigio Framework:</p>
            <pre>
                <code>
// Arquivo routes.php
$router->get('/', 'HomeController@index');
$router->post('/user', 'UserController@store');
                </code>
            </pre>
        </section>

        <section id="abstracao-de-dados">
            <h2>Abstração de Dados</h2>
            <p>Utilizando a abstração de dados:</p>
            <pre>
                <code>
$user = new User();
$user->name = 'John Doe';
$user->save();
                </code>
            </pre>
        </section>

        <section id="exemplos">
            <h2>Exemplos</h2>
            <p>Exemplos práticos de uso do Prodigio Framework:</p>
        </section>

        <section id="api-referencia">
            <h2>API Referência</h2>
            <p>Referência completa da API do Prodigio Framework:</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Prodigio Framework. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
