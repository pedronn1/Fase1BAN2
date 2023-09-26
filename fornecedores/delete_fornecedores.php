<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

if (isset($_GET['codigo'])) {
    $fornecedor_id = $_GET['codigo']; 
    $link = mysqli_connect("localhost", "root", "", "ban2");

    $query = "SELECT * FROM Fornecedor WHERE fornecedor_id = '$fornecedor_id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $delete_query = "DELETE FROM Fornecedor WHERE fornecedor_id = '$fornecedor_id'";
        mysqli_query($link, $delete_query);
        $_SESSION['success_msg'] = "Fornecedor excluído com sucesso!";
    } else {
        $_SESSION['error_msg'] = "Erro ao excluir o fornecedor.";
    }

    mysqli_close($link);
    header('location: ver_fornecedores.php');
    exit();
} else {
    header('location: menu_functions.php');
    exit();
}
?>
