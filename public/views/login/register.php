<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro - Management Admin</title>
    <link rel="icon" href="/assets/img/mini_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/bootstrap1.min.css" />
    <link rel="stylesheet" href="/assets/css/style1.css" />
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img src="/assets/img/logo.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
                </div>
                <div class="card shadow">
                    <div class="modal-content cs_modal">
                        <div class="modal-header theme_bg_1 d-flex justify-content-center">
                            <h5 class="modal-title text_white">Criar conta</h5>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <input type="text" class="form-control" placeholder="Nome" required>
                                </div>
                                <div>
                                    <input type="email" class="form-control" placeholder="E-mail" required>
                                </div>
                                <div>
                                    <input type="password" class="form-control" placeholder="Senha" required>
                                </div>
                                <button type="submit" class="btn_1 full_width text-center">Cadastrar</button>
                            </form>
                            <div class="mt-3 text-center">
                                <p class="mb-0">Já tem uma conta? <a href="/login" class="text-decoration-none">Faça login</a></p>
                                <p class="mb-0"><a href="/login" class="text-decoration-none">Voltar</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>