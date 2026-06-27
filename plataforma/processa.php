<?php
// 1. Configurações de conexão
$host     = "db001";
$user     = "root";
$password = "123456";
$database = "cadastro";

// 2. Conecta ao banco de dados
$conn = new mysqli($host, $user, $password, $database);

// 3. Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// 4. Inicializa variáveis de controle para o HTML
$sucesso = false;
$erro_mensagem = "";

// 5. Só processa se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Captura os dados e remove espaços extras
    $nome     = trim($_POST["nome"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");

    // Validação simples: não permite campos vazios
    if (!empty($nome) && !empty($email)) {
        
        // Proteção: Prepara a query com placeholders (?)
        $stmt = $conn->prepare("INSERT INTO pessoas (nome, email, telefone) VALUES (?, ?, ?)");
        
        if ($stmt) {
            // Vincula os parâmetros reais de forma segura ("sss" significa 3 strings)
            $stmt->bind_param("sss", $nome, $email, $telefone);
            
            // Executa a query de forma segura
            if ($stmt->execute()) {
                $sucesso = true;
            } else {
                $erro_mensagem = "Erro ao executar comando: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $erro_mensagem = "Erro na preparação do banco: " . $conn->error;
        }
    } else {
        $erro_mensagem = "Por favor, preencha os campos obrigatórios (Nome e E-mail).";
    }
} else {
    $erro_mensagem = "Nenhum dado foi enviado.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <?php if ($sucesso): ?>
        <h2>Cadastro realizado com sucesso!</h2>
    <?php else: ?>
        <h2>Erro ao cadastrar!</h2>
        <p><?php echo htmlspecialchars($erro_mensagem); ?></p>
    <?php endif; ?>

    <br>

    <a href="index.html">Voltar</a>

</div>

</body>
</html>
