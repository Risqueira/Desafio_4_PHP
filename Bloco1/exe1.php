<?php
//Bloco de processamento
$valor = "";
$cotacao = "";
$valor_dolar = "";
$erro = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['valor']) && !empty(trim($_POST['valor']))) {
        $valor_str = str_replace(',', '.', trim($_POST['valor']));
        $valor_valido = filter_var($valor_str, FILTER_VALIDATE_FLOAT);

        if ($valor_valido === false || $valor_valido <= 0) {
            $erro[] = "Valor invalido";
            $valor = htmlspecialchars(trim($_POST['valor']));
        } else {
            $valor = $valor_valido;
        }
    } else {
        $erro[] = "O campo Valor é obrigatório.";
    }

    if (isset($_POST['cotacao']) && !empty(trim($_POST['cotacao']))) {
        $cotacao_str = str_replace(',', '.', trim($_POST['cotacao']));
        $cotacao_valido = filter_var($cotacao_str, FILTER_VALIDATE_FLOAT);

        if ($cotacao_valido === false || $cotacao_valido <= 0) {
            $erro[] = "Cotação invalido";
            $cotacao = htmlspecialchars(trim($_POST['valor']));
        } else {
            $cotacao = $cotacao_valido;
        }
    } else {
        $erro[] = "O campo cotação é obrigatório.";
    }

    if (empty($erro)) {
        $valor_dolar = $valor / $cotacao;
        echo "<p>R$ " . number_format($valor, 2, ",", ".") .
            " equivalem a US$ " . number_format($valor, 2, ",", ".") . "<p>";
    } else {
        //exibe os erros
        foreach ($erro as $erro) {
            echo "<p style='color:red;'>$erro</p>";
        }
    }



}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h2>Conversor de Reais para Dólares</h2>

    <form method="post">
        Valor em Reais (R$):
        <input type="number" step="0.01" name="valor" required><br><br>

        Cotação do Dólar (USD):
        <input type="number" step="0.01" name="cotacao" required><br><br>

        <input type="submit" value="Converter">
    </form>



</body>

</html>