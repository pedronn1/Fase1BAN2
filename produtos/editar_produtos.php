<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "ban2");

if (!isset($_GET['produto_id'])) {
    echo "ID do produto não fornecido";
    exit();
}

$codigo = $_GET['produto_id'];

$query = "SELECT Produto.produto_id, Produto.nome AS produto_nome, Produto.preco, Fornecedor.fornecedor_id, Fornecedor.nome AS fornecedor_nome 
          FROM Produto
          INNER JOIN Fornecedor ON Produto.fornecedor_id = Fornecedor.fornecedor_id
          WHERE Produto.produto_id = $codigo";

$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Produto não encontrado";
    exit();
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($link, $_POST['nome']);
    $preco = mysqli_real_escape_string($link, $_POST['preco']);
    $fornecedor_id = mysqli_real_escape_string($link, $_POST['fornecedor_id']);

    $updateQuery = "UPDATE Produto 
                    SET nome = '$nome', preco = '$preco', fornecedor_id = '$fornecedor_id' 
                    WHERE produto_id = $codigo";
    mysqli_query($link, $updateQuery);

    header('location: ver_produtos.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                                <h3 class="mb-4">Editar Produto</h3>
                            </div>
                        </div>
						<div class="content">
							<form class="form" method="POST" action="">
								<label for="nome">Nome do Produto:</label><br>
								<input type="text" name="nome" value="<?php echo $row['produto_nome']; ?>" required>
								<br>
								<label for="preco">Preço:</label><br>
								<input type="text" name="preco" value="<?php echo $row['preco']; ?>" required>
								<br>
								<label for="fornecedor_id">Fornecedor:</label><br>
								<select name="fornecedor_id" required>
									<?php
									$fornecedoresQuery = "SELECT fornecedor_id, nome FROM Fornecedor";
									$fornecedoresResult = mysqli_query($link, $fornecedoresQuery);

									while ($fornecedor = mysqli_fetch_assoc($fornecedoresResult)) {
										echo "<option value='" . $fornecedor['fornecedor_id'] . "'";
										if ($fornecedor['fornecedor_id'] == $row['fornecedor_id']) {
											echo " selected";
										}
										echo ">" . $fornecedor['nome'] . "</option>";
									}
									?>
								</select>
								<br><br>
								<input type="submit" class="form-control btn btn-primary rounded submit px-3" value="Salvar Alterações">
							</form>
						</div><br>
						<p class="text-center"> <a href="ver_produtos.php">Voltar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
