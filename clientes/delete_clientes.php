<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

if (isset($_GET['codigo'])) {
    $cliente_id = $_GET['codigo'];
    $link = mysqli_connect("localhost", "root", "", "ban2");

    $query = "SELECT * FROM Cliente WHERE cliente_id = '$cliente_id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $delete_query = "DELETE FROM Cliente WHERE cliente_id = '$cliente_id'";
        mysqli_query($link, $delete_query);
        $_SESSION['success_msg'] = "Cliente excluído com sucesso!";
    } else {
        $_SESSION['error_msg'] = "Erro ao excluir o cliente.";
    }

    mysqli_close($link);
    header('location: ver_clientes.php');
    exit();
} else {
    header('location: menu_functions.php');
    exit();
}
?>
