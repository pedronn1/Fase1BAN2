<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: login.php');
        exit();
    }

    $fornecedor_id = $_POST["fornecedor_id"];
    $funcionario_id = $_POST["funcionario_id"];
    $loja_id = $_POST["loja_id"];
    $totalAmount = $_POST["totalAmount"];

    $link = mysqli_connect("localhost", "root", "", "ban2");

    $data_compra = date("Y-m-d"); 
    $query = "INSERT INTO Compra (fornecedor_id, funcionario_id, loja_id, data_compra, valor_total) VALUES ('$fornecedor_id', '$funcionario_id', '$loja_id', '$data_compra', '$totalAmount')";
    mysqli_query($link, $query);

    $compra_id = mysqli_insert_id($link);

    $itemCount = $_POST["itemCount"];

    if (isset($_POST["selectedProductIds"])) {
        $selectedProductIds = json_decode($_POST["selectedProductIds"], true);
        $selectedProductQntd = json_decode($_POST["selectedProductQntd"], true);
        $selectedProductPrices = json_decode($_POST["selectedProductPrices"], true);
    
        for ($i = 0; $i < $itemCount; $i++) {
            $produto_id = intval($selectedProductIds[$i]);
            $quantidade = intval($selectedProductQntd[$i]);
            $preco = floatval($selectedProductPrices[$i]);
    
            $query = "SELECT quantidade FROM estoque WHERE produto_id = '$produto_id'";
            $result = mysqli_query($link, $query);
    
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $quantidade_existente = intval($row['quantidade']);
                $nova_quantidade = $quantidade_existente + $quantidade;
    
                $query = "UPDATE estoque SET quantidade = '$nova_quantidade' WHERE produto_id = '$produto_id'";
                mysqli_query($link, $query);
            } else {
                $query = "INSERT INTO estoque (produto_id, quantidade) VALUES ('$produto_id', '$quantidade')";
                mysqli_query($link, $query);
            }
    
            $query = "INSERT INTO compra_produto (compra_id, produto_id, quantidade, custo) VALUES ('$compra_id', '$produto_id', '$quantidade', '$preco')";
            mysqli_query($link, $query);
        }
    } else {
        echo "Nenhum produto selecionado.";
    }

    mysqli_close($link);

    header("Location: ver_compras.php");
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
                            <h3 class="mb-4">Compras</h3>
                        </div>
                    </div>
                    <div class="content" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                        <form class="form" method="POST" action="">
                            <label for="fornecedor_id">Fornecedor:</label><br>
                            <select name="fornecedor_id" required>
                                <?php
                                $link = mysqli_connect("localhost", "root", "", "ban2");
                                $query = "SELECT fornecedor_id, nome FROM Fornecedor";
                                $result = mysqli_query($link, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['fornecedor_id'] . "'>" . $row['nome'] . "</option>";
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
                            <br>

                            <input type="hidden" name="itemCount" id="itemCount" value="0">
                            <input type="hidden" name="selectedProductIds" id="selectedProductIds" value="">
                            <input type="hidden" name="selectedProductQntd" id="selectedProductQntd" value="">
                            <input type="hidden" name="selectedProductPrices" id="selectedProductPrices" value="">

                            <div id="addProductForm" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                                <label for="product">Produto:</label>
                                <select name="selectedProducts[]" id="product">
                                    <?php
                                    $conn = mysqli_connect("localhost", "root", "", "ban2");

                                    $query = "SELECT produto_id, nome, preco FROM Produto";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["produto_id"] . "' data-price='" . $row["preco"] . "'>" . $row["nome"] . "</option>";
                                        }
                                    }

                                    $conn->close();
                                    ?>
                                </select>
                                <br>

                                <label for="quantity">Quantidade:</label>
                                <input type="number" name="selectedQuantities[]" id="quantity" value="1" min="1"><br>
                                
                                <label for="price">Preço:</label>
                                <input type="number" name="selectedPrices[]" id="price" value="0.00" step="0.01"><br>

                                <button type="button" id="addProduct">Adicionar Produto</button><br>
                            <table style="text-align: center; display: flex; flex-direction: column; align-items: center;">

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
                            </table>

                            <input type="hidden" name="totalAmount" id="totalAmountInput" value="0.00">

                            <h3>Total da Compra: <span id="totalAmount">0.00</span></h3>
                            </div><br>
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3" id="submitBtn">Adicionar Compra</button><br><br>
                            <p class="text-center"> <a href="ver_compras.php">Voltar</a></p>
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
const productPriceList = [];

addProductButton.addEventListener("click", () => {
    const productSelect = document.getElementById("product");
    const quantityInput = document.getElementById("quantity");
    const priceInput = document.getElementById("price");

    const productId = productSelect.value;
    const productName = productSelect.options[productSelect.selectedIndex].text;
    const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].getAttribute("data-price"));
    const quantity = parseInt(quantityInput.value);
    const price = parseFloat(priceInput.value);
    const subtotal = (price * quantity).toFixed(2);

    productIdList.push(productId);
    productQtdList.push(quantity);
    productPriceList.push(price);

    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${productId}</td>
        <td>${productName}</td>
        <td>${quantity}</td>
        <td>${price.toFixed(2)}</td>
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
    priceInput.value = "0.00";

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
            productPriceList.splice(rowIndex, 1);

            row.remove();

            itemCountInput.value = productIdList.length;
        });
    });

    itemCountInput.value = productIdList.length;
});

document.getElementById("submitBtn").addEventListener("click", (event) => {
    if (productIdList.length === 0) {
        event.preventDefault(); 
        alert("Selecione pelo menos um produto antes de adicionar a compra.");
    } else {
        document.getElementById("selectedProductIds").value = JSON.stringify(productIdList);
        document.getElementById("selectedProductQntd").value = JSON.stringify(productQtdList);
        document.getElementById("selectedProductPrices").value = JSON.stringify(productPriceList);
    }
});
</script>
