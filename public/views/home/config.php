<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração do Banco de Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo img {
            max-width: 400px;
        }
        h3 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 0.5rem;
            font-weight: bold;
        }
        input {
            padding: 0.5rem;
            margin-top: 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 1.5rem;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="/assets/img/logo.png" alt="Prodígio Framework">
        </div>
        <h3>Configuração do Banco de Dados</h3>
        <p>Acesse o arquivo <b>App/Controllers/DatabaseConfig.php</b> para configurar suas tabelas de banco de dados.</p>
        <form action="/salvar-configuracao" method="POST">
            <label for="host">Host:</label>
            <input type="text" id="host" name="host" value="localhost" required>
            
            <label for="port">Porta:</label>
            <input type="number" id="port" name="porta" value="3306" required>
            
            <label for="user">Usuário:</label>
            <input type="text" id="user" name="user" value="root" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" value="" required>
            
            <label for="database">Nome do Banco:</label>
            <input type="text" id="database" name="database" value="prodigio" required>
            
            <button type="submit">Salvar Configurações</button>
        </form>
    </div>
</body>
</html>
