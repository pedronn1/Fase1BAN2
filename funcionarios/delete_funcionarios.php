<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

if (isset($_GET['codigo'])) {
    $funcionario_id = $_GET['codigo'];
    $link = mysqli_connect("localhost", "root", "", "ban2");

    $query = "SELECT * FROM Funcionario WHERE funcionario_id = '$funcionario_id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $delete_query = "DELETE FROM Funcionario WHERE funcionario_id = '$funcionario_id'";
        mysqli_query($link, $delete_query);
        $_SESSION['success_msg'] = "Funcionario excluído com sucesso!";
    } else {
        $_SESSION['error_msg'] = "Erro ao excluir o funcionario.";
    }

    mysqli_close($link);
    header('location: ver_funcionarios.php');
    exit();
} else {
    header('location: menu_functions.php');
    exit();
}
?>
