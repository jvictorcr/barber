<?php

require_once '../config/conecta_db.php';

if (isset($_POST['btn-trocar'])) {
    $email = strip_tags($_POST['email']);
    $ip = strip_tags($_POST['ip']);

    $verifica_email = $pdo->prepare("SELECT email_user, nome_user FROM login_user WHERE email_user = :email");
    $verifica_email->bindParam(":email", $email);
    $verifica_email->execute();
    $rowsEmail = $verifica_email->fetch(PDO::FETCH_ASSOC);

    if ($rowsEmail) {
        $nome = $rowsEmail['nome_user'];
        $contra_chave = "@t1c3ntr41#Melancia@13?";
        $chave = password_hash($contra_chave, PASSWORD_DEFAULT);

        $trocar_senha = $pdo->prepare("UPDATE login_user SET recuperar_user = :chave WHERE email_user = :email");
        $trocar_senha->bindValue(":chave", $chave);
        $trocar_senha->bindValue(":email", $email);

        if ($trocar_senha->execute()) {
            require '../../../PHPMailer/PHPMailerAutoload.php';

            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isSMTP();
            $mail->Timeout = 15;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Username = 'soledadedti@gmail.com';
            $mail->Password = 'fritufewgnrzpyci';
            $mail->Port = 587;

            $mail->setFrom('soledadedti@gmail.com', 'Departamento de TI – Prefeitura Municipal de Soledade/RS');
            $mail->addReplyTo('soledadedti@gmail.com', 'Departamento de TI – Prefeitura Municipal de Soledade/RS');
            $mail->addAddress($email);
            $mail->addAddress('ti@soledade.rs.gov.br');
            $mail->addCC($email, 'Cópia');
            $mail->addBCC($email, 'Cópia Oculta');

            $mail->isHTML(true);
            $mail->Subject = 'Alteração de Senha';
            $mail->Body = "
                
                <p>Olá, <b>$nome</b>!</p>               
                <p><a href='https://pmsoledaders.inf.br/cadastro_geral/login/atualizar.php?chave=$chave'>Clique aqui</a> para alterar sua senha.</p>
                <br>
                <span><i>Caso você não tenha solicitado a alteração de senha, ignore este e-mail.</i></span>
                <br><br>
                <span>---------</span>
                <br>
                <span><b>Departamento de TI - Prefeitura Municipal de Soledade/RS</b></span>
                <br>
                <span>E-mail: <a href='mailto:ti@soledade.rs.gov.br'><i>ti@soledade.rs.gov.br</i></a></span>
                <br>
                <span>Telefone: <i>+55 (54) 3381-9040</i></span>
                <br><br>
                <span><i>E-mail gerado automaticamente, não responda.</i></span>
            ";

            if (!$mail->send()) {
                echo "<script>alert('Erro na solicitação: " . $mail->ErrorInfo . ". Entre em contato com o suporte através do telefone (54) 3381-9040.'); document.location='../index.php';</script>";
            } else {

                $sql = $pdo->prepare("SELECT * FROM login_user WHERE email_user = :email");
                $sql->bindParam(":email", $email);
                $sql->execute();
                $resultado = $sql->fetch(PDO::FETCH_ASSOC);

                $data = date('Y-m-d H:i:s');
                $acao = "Usuário solicitou a troca da senha";
                $inserir_logs_user = $pdo->prepare("INSERT INTO logs_user (data_logs, acao_logs, user_logs, cpf_logs, nivel_logs, ip_logs) VALUES (:data, :acao, :user, :cpf, :nivel, :ip)");

                $inserir_logs_user->bindParam(':data', $data);
                $inserir_logs_user->bindParam(':acao', $acao);
                $inserir_logs_user->bindParam(':user', $resultado['nome_user']);
                $inserir_logs_user->bindParam(':cpf', $resultado['cpf_user']);
                $inserir_logs_user->bindParam(':nivel', $resultado['nivel_user']);
                $inserir_logs_user->bindParam(':ip', $ip);
                $inserir_logs_user->execute();

                echo "<script>alert('Um e-mail foi enviado com o link de alteração de senha, verifique sua caixa de entrada e/ou spam.'); document.location='../index.php';</script>";
            }
        } else {
            echo "<script>alert('Oops... Ocorreu algum erro com a solicitação. Tente novamente.'); document.location='../index.php';</script>";
        }
    } else {
        echo "<script>alert('Oops... Parece que esse e-mail não foi encontrado. Tente novamente ou crie uma conta.'); document.location='../recuperar.php';</script>";
    }
}
