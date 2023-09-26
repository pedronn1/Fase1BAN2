<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: login.php');
        exit();
    }

    $cliente_id = $_POST["cliente_id"];
    $funcionario_id = $_POST["funcionario_id"];
    $loja_id = $_POST["loja_id"];
    $totalAmount = $_POST["totalAmount"];

    $link = mysqli_connect("localhost", "root", "", "ban2");

    $data_venda = date("Y-m-d"); 
    $query = "INSERT INTO Venda (cliente_id, funcionario_id, loja_id, data_venda, valor_total) VALUES ('$cliente_id', '$funcionario_id', '$loja_id', '$data_venda', '$totalAmount')";
    mysqli_query($link, $query);

    $venda_id = mysqli_insert_id($link);

    $itemCount = $_POST["itemCount"];

    if (isset($_POST["selectedProductIds"])) {
        $selectedProductIds = json_decode($_POST["selectedProductIds"], true);
        $selectedProductQntd = json_decode($_POST["selectedProductQntd"], true);
        
        for ($i = 0; $i < $itemCount; $i++) {
            $produto_id = intval($selectedProductIds[$i]);
            $quantidade = intval($selectedProductQntd[$i]);

            $query = "SELECT quantidade FROM Estoque WHERE produto_id = '$produto_id'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            $quantidade_disponivel = $row['quantidade'];

            if ($quantidade_disponivel < $quantidade) {
                mysqli_close($link);
                header("Location: sua_pagina_de_erro.php");
                exit();
            }

            $query = "INSERT INTO venda_produto (venda_id, produto_id, quantidade) VALUES ('$venda_id', '$produto_id', '$quantidade')";
            mysqli_query($link, $query);

            $nova_quantidade = $quantidade_disponivel - $quantidade;
            $query = "UPDATE Estoque SET quantidade = '$nova_quantidade' WHERE produto_id = '$produto_id'";
            mysqli_query($link, $query);
        }
    } else {
        echo "Nenhum produto selecionado.";
    }

    mysqli_close($link);

    header("Location: ver_vendas.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
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
                    <div class="img" style="background-image: url(images/bg-1.png);"></div><br>
                    <div class="d-flex" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                        <div class="w-100">
                            <h3 class="mb-4">Vendas</h3>
                        </div>
                    </div>
                    <div class="content" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                        <form class="form" method="POST" action="">
                            <label for="cliente_id">Cliente:</label><br>
                            <select name="cliente_id" required>
                                <?php
                                $link = mysqli_connect("localhost", "root", "", "ban2");
                                $query = "SELECT cliente_id, nome FROM Cliente";
                                $result = mysqli_query($link, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['cliente_id'] . "'>" . $row['nome'] . "</option>";
                                }
                                mysqli_close($link);
                                ?>
                            </select>
                            <br>
                            <label for="funcionario_id">Funcionário:</label><br>
                            <select name="funcionario_id" required>
                                <?php
                                $link = mysqli_connect("localhost", "root", "", "ban2");
                                $query = "SELECT funcionario_id, nome FROM Funcionario";
                                $result = mysqli_query($link, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['funcionario_id'] . "'>" . $row['nome'] . "</option>";
                                }
                                mysqli_close($link);
                                ?>
                            </select>
                            <br>
                            <label for="loja_id">Loja:</label><br>
                            <select name="loja_id" required>
                                <?php
                                $link = mysqli_connect("localhost", "root", "", "ban2");
                                $query = "SELECT loja_id, nome FROM Loja";
                                $result = mysqli_query($link, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['loja_id'] . "'>" . $row['nome'] . "</option>";
                                }
                                mysqli_close($link);
                                ?>
                            </select>
                            <br><br>

                            <input type="hidden" name="totalAmount" id="totalAmountInput" value="0.00">

                            <input type="hidden" name="itemCount" id="itemCount" value="0">
                            <input type="hidden" name="selectedProductIds" id="selectedProductIds" value="">
                            <input type="hidden" name="selectedProductQntd" id="selectedProductQntd" value="">

                            <div id="addProductForm">
                            <label for="product">Produto:</label><br>
                            <select name="selectedProducts[]" id="product">
                                <?php
                                $conn = mysqli_connect("localhost", "root", "", "ban2");

                                $query = "SELECT p.produto_id, p.nome, p.preco, e.quantidade AS quantidade_disponivel
                                        FROM Produto AS p
                                        LEFT JOIN Estoque AS e ON p.produto_id = e.produto_id";
                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $productId = $row["produto_id"];
                                        $productName = $row["nome"];
                                        $productPrice = $row["preco"];
                                        $quantityAvailable = $row["quantidade_disponivel"];

                                        echo "<option value='$productId' data-price='$productPrice' data-quantity='$quantityAvailable'>$productName (Disponível: $quantityAvailable)</option>";
                                    }
                                }

                                $conn->close();
                                ?>
                            </select><br>

                                <label for="quantity">Quantidade:</label><br>
                                <input type="number" name="selectedQuantities[]" id="quantity" value="1" min="1"><br><br>

                                <button type="button" id="addProduct">Adicionar Produto</button><br>
                                <br><table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Preço</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsTable">
                                    </tbody>
                                </table><br>
                                <h3>Total da Venda: <span id="totalAmount">0.00</span></h3>

                            </div><br>
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3" id="submitBtn">Adicionar Venda</button><br><br>
                            <p class="text-center"> <a href="ver_vendas.php">Voltar</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<script>
const addProductButton = document.getElementById("addProduct");
const productsTable = document.getElementById("productsTable");
const totalAmount = document.getElementById("totalAmount");
const totalAmountInput = document.getElementById("totalAmountInput");
const itemCountInput = document.getElementById("itemCount"); 

const productIdList = [];
const productQtdList = [];

addProductButton.addEventListener("click", () => {
    const productSelect = document.getElementById("product");
    const quantityInput = document.getElementById("quantity");

    const productId = productSelect.value;
    const productName = productSelect.options[productSelect.selectedIndex].text;
    const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].getAttribute("data-price"));
    const quantity = parseInt(quantityInput.value);
    const subtotal = (productPrice * quantity).toFixed(2);

    const availableQuantity = parseInt(productSelect.options[productSelect.selectedIndex].getAttribute("data-quantity"));
    if (quantity > availableQuantity) {
        alert("A quantidade escolhida é maior do que a disponível em estoque.");
        return; 
    }

    productIdList.push(productId);
    productQtdList.push(quantity);

    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${productId}</td>
        <td>${productName}</td>
        <td>${quantity}</td>
        <td>${productPrice.toFixed(2)}</td>
        <td>${subtotal}</td>
        <td><button class="removeProduct">Remover</button></td>
    `;

    productsTable.appendChild(newRow);

    const currentTotal = parseFloat(totalAmount.textContent);
    const newTotal = (currentTotal + parseFloat(subtotal)).toFixed(2);
    totalAmount.textContent = newTotal;
    totalAmountInput.value = newTotal;

    productSelect.selectedIndex = 0;
    quantityInput.value = 1;

    const removeButtons = document.querySelectorAll(".removeProduct");
    removeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const row = button.closest("tr");
            const rowIndex = Array.from(productsTable.getElementsByTagName("tr")).indexOf(row);
            const rowSubtotal = parseFloat(row.childNodes[3].textContent);
            const newTotal = (currentTotal - rowSubtotal).toFixed(2);
            totalAmount.textContent = newTotal;
            totalAmountInput.value = newTotal;

            productIdList.splice(rowIndex, 1);
            productQtdList.splice(rowIndex, 1);

            row.remove();

            itemCountInput.value = productIdList.length;
        });
    });

    itemCountInput.value = productIdList.length;
});

document.getElementById("submitBtn").addEventListener("click", (event) => {
    if (productIdList.length === 0) {
        event.preventDefault();
        alert("Selecione pelo menos um produto antes de adicionar a venda.");
    } else {
        document.getElementById("selectedProductIds").value = JSON.stringify(productIdList);
        document.getElementById("selectedProductQntd").value = JSON.stringify(productQtdList);
    }
});
</script>
