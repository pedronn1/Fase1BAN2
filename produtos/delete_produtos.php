<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $link = mysqli_connect("localhost", "root", "", "ban2");

    $query = "SELECT * FROM Produto WHERE produto_id = '$produto_id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $delete_query = "DELETE FROM Produto WHERE produto_id = '$produto_id'";
        mysqli_query($link, $delete_query);
        $_SESSION['success_msg'] = "Produto excluído com sucesso!";
    } else {
        $_SESSION['error_msg'] = "Erro ao excluir o produto.";
    }

    mysqli_close($link);
    header('location: ver_produtos.php');
    exit();
} else {
    header('location: ../menu_functions.php');
    exit();
}
?>
