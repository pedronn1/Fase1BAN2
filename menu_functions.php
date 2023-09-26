<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You have to log in first";
	header('location: login.php');
	exit();
}

if (isset($_GET['logout'])) {
	unset($_SESSION['username']);
	header("location: mainpage.php");
	exit();
}

if (isset($_GET['delete_account'])) {
	$db = mysqli_connect('localhost', 'root', '', 'ban2');

	$username = $_SESSION['username'];

	// Excluir o registro do funcionário na tabela "Funcionario"
	$deleteUserQuery = "DELETE FROM Funcionario WHERE nome = '$username'";
	mysqli_query($db, $deleteUserQuery);

	unset($_SESSION['username']);
	header("location: mainpage.php");
	exit();
}

$db = mysqli_connect('localhost', 'root', '', 'ban2');

$username = $_SESSION['username'];
$query = "SELECT * FROM Funcionario WHERE nome = '$username'";
$result = mysqli_query($db, $query);
$userData = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.logout-delete {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.logout-delete a {
			margin: 10px;
			padding: 12px 24px;
			border: 1px solid red;
			color: red;
			text-decoration: none;
			text-align: center;
		}

		.ver-atividades {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 20px;
		}

		.ver-atividades a {
			display: block;
			width: 100%;
			padding: 20px;
			background-color: #ddd;
			color: #333;
			text-decoration: none;
			text-align: center;
		}

        .user-data {
            margin-top: 20px;
            padding: 10px;
            background-color: #f1f1f1;
        }
	</style>
</head>
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
									<h3 class="mb-4">Bem Vindo</h3>
								</div>
							</div>
							<div class="content">
								<?php if (isset($_SESSION['success'])) : ?>
									<div class="error success">
										<h3>
											<?php
											echo $_SESSION['success'];
											unset($_SESSION['success']);
											?>
										</h3>
									</div>
								<?php endif ?>
								<?php if (isset($_SESSION['username'])) : ?>
									<p>Olá 
										<strong>
											<?php echo $_SESSION['username']; ?>
										</strong>
									</p>
									
								<?php endif ?>
                                <?php if (isset($userData)) : ?>
                                    <div class="user-data">
                                        <h5>Seus dados:</h5>
                                        <p><strong>Nome:</strong> <?php echo $userData['nome']; ?></p>
                                        <p><strong>Email:</strong> <?php echo $userData['email']; ?></p>
                                    </div>
                                <?php endif ?>
								<div class="logout-delete">
									<a class="form-control btn btn-danger rounded submit px-3" href="vendas/ver_vendas.php">VENDA</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-danger rounded submit px-3" href="compras/ver_compras.php">COMPRA</a>
								</div>
                                <div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="produtos/ver_produtos.php">Ver produtos</a>
								</div>
                                <div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="fornecedores/ver_fornecedores.php">Ver fornecedores</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="clientes/ver_clientes.php">Ver clientes</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="funcionarios/ver_funcionarios.php">Ver funcionários</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="lojas/ver_lojas.php">Ver lojas</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="cidade/inserir_cidade.php">Adicionar cidade</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-primary rounded submit px-3" href="desempenho/desempenho.php">Desempenho</a>
								</div>
								<div class="logout-delete">
									<a class="form-control btn btn-danger rounded submit px-3" href="index.php?logout='1'">Sair da Conta</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
