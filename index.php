<?php
ini_set("display_errors", 1);
header("Content-Type: text/html; charset=utf-8");

// --- Dados de conexão ---
$servername = "54.234.153.24";
$username   = "root";
$password   = "Senha123";
$database   = "meubanco";

// --- Criar conexão ---
$link = new mysqli($servername, $username, $password, $database);

// Testar conexão
if ($link->connect_error) {
    die("<h3>Falha na conexão: " . $link->connect_error . "</h3>");
}

// --- Gerar valores aleatórios mais realistas ----
$nome       = "Aluno_" . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
$sobrenome  = "Sob_" . rand(100, 999);
$endereco   = "Rua " . rand(1, 300);
$cidade     = "Cidade_" . rand(1, 50);
$host_name  = gethostname();

// --- Usar Prepared Statement (MUITO mais seguro) ---
$stmt = $link->prepare("
    INSERT INTO dados (Nome, Sobrenome, Endereco, Cidade, Host) 
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $nome, $sobrenome, $endereco, $cidade, $host_name);

// Executar
$exec = $stmt->execute();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Status do PHP</title>
</head>
<body>
    <h2>Versão do PHP: <?php echo phpversion(); ?></h2>

    <?php if ($exec): ?>
        <p style="color: green; font-size: 20px;">
            ✔ Registro criado com sucesso!
        </p>
        <p><strong>ID Inserido:</strong> <?php echo $link->insert_id; ?></p>
        <p><strong>Host:</strong> <?php echo $host_name; ?></p>
    <?php else: ?>
        <p style="color: red; font-size: 20px;">
            ❌ Erro ao inserir: <?php echo $stmt->error; ?>
        </p>
    <?php endif; ?>

</body>
</html>
