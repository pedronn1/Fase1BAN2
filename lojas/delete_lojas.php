<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

if (isset($_GET['codigo'])) {
    $loja_id = $_GET['codigo'];
    $link = mysqli_connect("localhost", "root", "", "ban2");

    $query = "SELECT * FROM Loja WHERE loja_id = '$loja_id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $delete_query = "DELETE FROM Loja WHERE loja_id = '$loja_id'";
        mysqli_query($link, $delete_query);
        $_SESSION['success_msg'] = "Loja excluída com sucesso!";
    } else {
        $_SESSION['error_msg'] = "Erro ao excluir a loja.";
    }

    mysqli_close($link);
    header('location: ver_lojas.php');
    exit();
} else {
    header('location: menu_functions.php');
    exit();
}
?>
