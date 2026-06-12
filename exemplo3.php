<?php
// --- BLOCO DE PROCESSAMENTO (PHP) ---
$peso = $altura = "";
$imc_resultado = null;
$classificacao = "";
$erros = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Validar Peso
    if (isset($_POST['peso']) && !empty(trim($_POST['peso']))) {
        // Troca vírgula por ponto para o filtro funcionar
        $peso_str = str_replace(',', '.', trim($_POST['peso']));
        $peso_valido = filter_var($peso_str, FILTER_VALIDATE_FLOAT);
        
        if ($peso_valido === false || $peso_valido <= 0) {
            $erros[] = "Peso inválido. Use apenas números (ex: 70.5).";
            $peso = htmlspecialchars(trim($_POST['peso']));
        } else {
            $peso = $peso_valido;
        }
    } else {
        $erros[] = "O campo Peso é obrigatório.";
    }


    // 2. Validar Altura
    if (isset($_POST['altura']) && !empty(trim($_POST['altura']))) {
        // Troca vírgula por ponto
        $altura_str = str_replace(',', '.', trim($_POST['altura']));
        $altura_valida = filter_var($altura_str, FILTER_VALIDATE_FLOAT);
        
        if ($altura_valida === false || $altura_valida <= 0 || $altura_valida > 3.0) {
            $erros[] = "Altura inválida. Use metros (ex: 1.75).";
            $altura = htmlspecialchars(trim($_POST['altura']));
        } else {
            $altura = $altura_valida;
        }
    } else {
        $erros[] = "O campo Altura é obrigatório.";
    }


    // 3. Se não houve erros, calcular
    if (count($erros) == 0) {
        // Lógica do Algoritmo (Cálculo e Condicionais)
        $imc_resultado = $peso / ($altura * $altura); // ou $peso / pow($altura, 2)
        
        if ($imc_resultado < 18.5) {
            $classificacao = "Magreza";
        } elseif ($imc_resultado < 24.9) {
            $classificacao = "Normal";
        } elseif ($imc_resultado < 29.9) {
            $classificacao = "Sobrepeso";
        } elseif ($imc_resultado < 39.9) {
            $classificacao = "Obesidade";
        } else {
            $classificacao = "Obesidade Grave";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ex. 3: Cálculo de IMC</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .erro { color: red; background-color: #ffe8e8; border: 1px solid red; padding: 10px; margin-bottom: 15px; }
        .resultado { color: #0056b3; background-color: #e8f4ff; border: 1px solid #0056b3; padding: 10px; margin-bottom: 15px; }
        div { margin-bottom: 10px; }
        label { display: inline-block; width: 100px; }
    </style>
</head>
<body>


    <h2>Calculadora de IMC</h2>
    
    <?php
    if (count($erros) > 0) {
        echo "<div class='erro'><ul>";
        foreach ($erros as $erro) { echo "<li>$erro</li>"; }
        echo "</ul></div>";
    }


    if ($imc_resultado !== null) {
        $imc_formatado = number_format($imc_resultado, 2, ',', '.');
        echo "<div class='resultado'>";
        echo "Seu IMC é: <strong>$imc_formatado</strong><br>";
        echo "Classificação: <strong>$classificacao</strong>";
        echo "</div>";
    }
    ?>


    <form method="post" action="">
        <div>
            <label for="peso">Seu Peso (Kg):</label>
            <input type="text" id="peso" name="peso" placeholder="Ex: 70,5" value="<?= htmlspecialchars($peso) ?>">
        </div>
        <div>
            <label for="altura">Sua Altura (m):</label>
            <input type="text" id="altura" name="altura" placeholder="Ex: 1,75" value="<?= htmlspecialchars($altura) ?>">
        </div>
        <div>
            <input type="submit" value="Calcular IMC">
        </div>
    </form>


</body>
</html>
ee