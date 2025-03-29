<?php
session_start(); // Iniciar a sessão

// Conectar ao banco de dados
// Incluir a conexão com o banco de dados
include('conexao.php');  // Altere o caminho conforme necessário

// Verificar se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    // Usar bindParam para PDO
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Verificar se a senha está correta
        if (password_verify($senha, $result['senha'])) {
            // Armazenar os dados do usuário na sessão
            $_SESSION['usuario_id'] = $result['id'];
            $_SESSION['nome'] = $result['nome']; // Alterei de usuario_nome para nome
            $_SESSION['email'] = $result['email']; // Alterei de usuario_email para email

            // Redirecionar para a página principal (fy.php)
            header("Location: ../home.html");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "E-mail não encontrado.";
    }
}
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1):
    ?>
    
    <!-- Exibir a mensagem de sucesso -->
    <div class="success-message">
        <p>Usuário criado com sucesso!</p>
    </div>
    
    <script>
        // Esconder a mensagem após 3 segundos
        setTimeout(function() {
            document.querySelector('.success-message').style.display = 'none';
        }, 3000);
    </script>
    
    <?php endif; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6D00">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
   
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-user-circle"></i> Bem-vindo de volta!</h2>
            <p>Faça login para continuar</p>
        </div>

        <!-- Exibe mensagens de erro, se houver -->
        <?php if (isset($erro)): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($erro); ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulário de Login -->
        <form action="login.php" method="POST" class="form-container">
            <div class="input-group">
                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Digite seu email" required>
            </div>
            <div class="input-group">
                <label for="senha" class="form-label"><i class="fas fa-lock"></i> Senha:</label>
                <input type="password" id="senha" name="senha" class="form-input" placeholder="Digite sua senha" required>
            </div>
            <div class="password-options">
                <div class="remember-me">
                    <input type="checkbox" id="lembrar" name="lembrar">
                    <label for="lembrar">Lembrar-me</label>
                </div>
                <a href="#" class="forgot-password">Esqueceu sua senha?</a>
            </div>
            <button type="submit" class="btn-submit">Entrar <i class="fas fa-sign-in-alt"></i></button>
        </form>

        <!-- Link para criar conta -->
        <div class="register-link">
            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
        </div>
    </div>

  <style>
   body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f7fa; /* Cor suave de fundo */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    text-align: center;
}

.login-header h2 {
    margin-bottom: 0.5rem;
    color: #333; /* Cor mais sóbria */
    font-size: 1.5rem;
}

.login-header p {
    color: #777; /* Cor neutra para o subtítulo */
    margin-bottom: 2rem;
    font-size: 1rem;
}

.input-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    color: #333;
    font-weight: 500;
    text-align: left;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ccc; /* Cor de borda suave */
    border-radius: 5px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-input:focus {
    border-color: #5c6bc0; /* Cor mais sóbria para o foco */
    outline: none;
}

.password-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.remember-me input {
    margin-right: 0.5rem;
}

.forgot-password {
    color: #5c6bc0; /* Cor suave para o link */
    text-decoration: none;
}

.forgot-password:hover {
    text-decoration: underline;
}

.btn-submit {
    background-color: #5c6bc0; /* Cor neutra, mas elegante */
    color: #fff;
    padding: 0.75rem;
    width: 100%;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #3f4b8d; /* Cor mais escura no hover */
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border-radius: 5px;
    text-align: left;
}

.register-link {
    margin-top: 2rem;
}

.register-link a {
    color: #5c6bc0; /* Cor neutra para o link */
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}


  </style>
</body>
</html>

    
