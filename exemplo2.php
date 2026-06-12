<?php
// --- BLOCO DE PROCESSAMENTO (PHP) ---
$numero = "";
$resultado_tabuada = ""; // Variável para guardar o HTML da tabuada
$erros = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['numero']) && $_POST['numero'] !== '') {
        $numero_filtrado = filter_var($_POST['numero'], FILTER_VALIDATE_INT);
        
        if ($numero_filtrado === false) {
            $erros[] = "Por favor, digite um número inteiro válido.";
            $numero = htmlspecialchars($_POST['numero']); // Repopula
        } else {
            $numero = $numero_filtrado;
            
            // Lógica do Algoritmo (Laço de Repetição)
            $resultado_tabuada = "<h3>Tabuada do $numero:</h3><ul>";
            for ($i = 1; $i <= 10; $i++) {
                $resultado = $numero * $i;
                $resultado_tabuada .= "<li>$numero x $i = <strong>$resultado</strong></li>";
            }
            $resultado_tabuada .= "</ul>";
        }
    } else {
        $erros[] = "O campo número é obrigatório.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ex. 2: Tabuada (Laço For)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .erro { color: red; background-color: #ffe8e8; padding: 10px; }
        .resultado { background-color: #f4f4f4; border: 1px solid #ccc; padding: 15px; margin-top: 20px; }
        ul { list-style: none; padding-left: 0; }
        li { font-size: 1.1em; margin-bottom: 5px; }
    </style>
</head>
<body>


    <h2>Gerador de Tabuada</h2>
    
    <?php
    // Exibe erros
    if (count($erros) > 0) {
        echo "<div class='erro'><ul>";
        foreach ($erros as $erro) { echo "<li>$erro</li>"; }
        echo "</ul></div>";
    }
    ?>


    <form method="post" action="">
        <div>
            <label for="numero">Digite um número:</label>
            <input type="text" id="numero" name="numero" value="<?= htmlspecialchars($numero) ?>">
        </div>
        <div>
            <input type="submit" value="Gerar Tabuada">
        </div>
    </form>


    <?php
    // Exibe o resultado (se houver)
    if (!empty($resultado_tabuada)) {
        echo "<div class='resultado'>$resultado_tabuada</div>";
    }
    ?>


</body>
</html>
