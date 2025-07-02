<!DOCTYPE html>
<html lang="pt">
<head><meta charset="UTF-8"><title>Formulário de Teste</title></head>
<body>
    <form action="formTeste.php" method="post">
        <label>Nome:</label><input type="text" name="nome" required><br>
        <label>Idade:</label><input type="number" name="idade" required><br>
        <button type="submit">Enviar</button>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = htmlspecialchars($_POST['nome']);
    $idade = (int)$_POST['idade'];

    echo "<h2>Dados recebidos:</h2>";
    echo "Nome: $nome<br>";
    echo "Idade: $idade<br>";
}
?>
</body>
</html>
