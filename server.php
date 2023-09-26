<?php
session_start();

$errors = array();
$_SESSION['success'] = "";

$db = mysqli_connect('localhost', 'root', '', 'ban2');

if (isset($_POST['reg_user'])) {

	$username = mysqli_real_escape_string($db, $_POST['nome']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

	if (empty($username)) { array_push($errors, "Nome de usuário é obrigatório"); }
	if (empty($email)) { array_push($errors, "Email é obrigatório"); }
	if (empty($password_1)) { array_push($errors, "Senha é obrigatória"); }

	if ($password_1 != $password_2) {
		array_push($errors, "As senhas são diferentes");
	}

	$user_check_query = "SELECT * FROM Funcionario WHERE nome='$username' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	$cidade_id = mysqli_real_escape_string($db, $_POST['cidade']);

    if (empty($cidade_id)) {
        array_push($errors, "Cidade é obrigatória");
    }

	if ($user) { 
		array_push($errors, "Nome de usuário já existe");
	}

	if (count($errors) == 0) {
		
		$query = "INSERT INTO Funcionario (nome, cidade_id, email, senha)
		VALUES('$username', '$cidade_id', '$email', '$password_1')";
		
		mysqli_query($db, $query);

		$funcionario_id = mysqli_insert_id($db);

		$_SESSION['username'] = $username;
		
		$_SESSION['success'] = "You have logged in";
		
		header('location: menu_functionS.php');
		exit();
	}
}

if (isset($_POST['login_user'])) {
	
	$username = mysqli_real_escape_string($db, $_POST['nome']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username)) {
		array_push($errors, "Nome é obrigatório");
	}
	if (empty($password)) {
		array_push($errors, "Senha é obrigatória");
	}

	if (count($errors) == 0) {
		$query = "SELECT * FROM Funcionario WHERE nome = '$username'";
		$result = mysqli_query($db, $query);

		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			if ($row != null) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You have logged in!";
				header('location: menu_functions.php');
				exit(); 
			} else {
				array_push($errors, "Usuário ou senha incorretos");
			}
		} else {
			array_push($errors, "Usuário ou senha incorretos");
		}
	}
}
?>
