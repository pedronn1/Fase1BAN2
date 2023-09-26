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
                                    <h3 class="mb-4">Criar uma conta</h3>
                                </div>
                            </div>
                            <form method="post" action="register.php">
                                <?php include('errors.php'); ?>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="nome" required value="<?php echo isset($username) ? $username : ''; ?>">
                                    <label class="form-control-placeholder" for="nome">Nome de usuário</label>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" required value="<?php echo isset($email) ? $email : ''; ?>">
                                    <label class="form-control-placeholder" for="email">E-mail</label>
                                </div>
								<div class="form-group">
									<label for="cidade">Cidade</label>
									<select class="form-control" name="cidade" required>
										<option value="" disabled selected>Selecione a cidade</option>
										<?php
										$query = "SELECT * FROM Cidade";
										$result = mysqli_query($db, $query);
										while ($row = mysqli_fetch_assoc($result)) {
											echo '<option value="' . $row['cidade_id'] . '">' . $row['nome'] . '</option>';
										}
										?>
									</select>
								</div><br>
                                <div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="inserir_cidade.php">Adicionar cidade</a>
								</div><br>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password_1" required>
                                    <label class="form-control-placeholder" for="password_1">Senha</label>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password_2" required>
                                    <label class="form-control-placeholder" for="password_2">Confirmar senha</label>
                                </div>
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3" name="reg_user">Cadastrar</button>
                            </form>
                            <p class="text-center">Já tem uma conta? <a href="login.php">Faça login</a></p>
                            <p class="text-center"><a href="index.php">Voltar a página principal</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
