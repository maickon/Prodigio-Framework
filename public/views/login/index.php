<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Login - Management Admin</title>
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
                                <h5 class="text-center modal-title text_white">Sistema de lançamento de pedidos</h5>
                            </div>

                            <div class="modal-body">
                                
                                <?php include component('alerts') ?>

                                <form method="POST" action="/autorizar/login">
                                    <div>
                                        <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                                    </div>
                                    <div>
                                        <input type="password" class="form-control" name="password" placeholder="Senha" required>
                                    </div>
                                    <button type="submit" class="btn_1 full_width text-center">Log in</button>
                                </form>
                                <div class="mt-3 text-center">
                                    <a href="/recuperar-senha" class="text-decoration-none">Esqueceu a senha?</a>
                                    <p class="mt-2 mb-0">Não tem uma conta? <a href="/criar-conta" class="text-decoration-none">Cadastre-se</a></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>