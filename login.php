<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="css/style.css"></head>
<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(images/bg-1.png);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Acessar Conta</h3>
                                </div>
                            </div>
                            <form method="post" action="login.php">
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="nome" required>
                                    <label class="form-control-placeholder" for="nome">Nome</label>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <label class="form-control-placeholder" for="password">Senha</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3" name="login_user">Entrar</button>
                            </form>
                            <p class="text-center">Ainda não é membro? <a href="register.php">Cadastre-se</a></p>
                            <p class="text-center"><a href="index.php">Voltar a página principal</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
