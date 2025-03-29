    <?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require __DIR__ . '/../vendor/autoload.php';  // Caminho correto para o autoload

    $mail = new PHPMailer(true);

    // Conexão com o banco de dados
    include('conexao.php');

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recuperar todos os e-mails cadastrados
        $query = "SELECT email FROM usuarios";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP do Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'vemprofutsoaslendas@gmail.com';  // Seu e-mail
        $mail->Password = 'wzng qqnp ywhb orgd';  // Senha de app gerada pelo Google

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Usando STARTTLS
        $mail->Port = 587;  // Porta correta para o Gmail

        // Configuração do e-mail enviado
        $mail->setFrom('vemprofutsoaslendas@gmail.com', 'Nome do Site');  // Seu e-mail e nome do site
        $mail->Subject = 'Novo Conteúdo Disponível!';
        $mail->Body    = '<h1>Temos novidades no site!</h1><p>Confira agora!</p>';
        $mail->isHTML(true);

        // Enviar e-mail para cada usuário
        foreach ($emails as $email) {
            $mail->clearAddresses();  // Limpa os endereços anteriores
            $mail->addAddress($email);  // Adiciona o e-mail do destinatário

            if (!$mail->send()) {
                echo "Erro ao enviar para $email: " . $mail->ErrorInfo . "<br>";
            } else {
                echo "E-mail enviado com sucesso para $email.<br>";
            }
        }

    } catch (Exception $e) {
        echo "Erro ao enviar e-mails: {$mail->ErrorInfo}";
    }
    ?>
