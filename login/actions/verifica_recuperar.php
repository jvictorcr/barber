<?php

require_once '../config/conecta_db.php';

if (isset($_POST['btn-trocar'])) {
    $email = strip_tags($_POST['email']);
    $ip = strip_tags($_POST['ip']);

    $verifica_email = $pdo->prepare("SELECT email_log, nome_log FROM login WHERE email_log = :email");
    $verifica_email->bindParam(":email", $email);
    $verifica_email->execute();
    $rowsEmail = $verifica_email->fetch(PDO::FETCH_ASSOC);

    if ($rowsEmail) {
        $nome = $rowsEmail['nome_log'];
        $contra_chave = "ZionX-barber-recuper";
        $chave = password_hash($contra_chave, PASSWORD_DEFAULT);

        $trocar_senha = $pdo->prepare("UPDATE login SET recuperar_log = :chave WHERE email_log = :email");
        $trocar_senha->bindValue(":chave", $chave);
        $trocar_senha->bindValue(":email", $email);

        if ($trocar_senha->execute()) {
            require '../assets/PHPMailer/PHPMailerAutoload.php';

            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isSMTP();
            $mail->Timeout = 15;
            $mail->Host = 'mail.zionx.dev.br';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'admin@zionx.dev.br';
            $mail->Password = 'Andreia8899#';
            $mail->Port = 465;

            $mail->setFrom('admin@zionx.dev.br', 'Barber Shopp System - By ZionX Technology de Soledade/RS');
            $mail->addReplyTo('jvictorcrs2@gmail.com', 'Admin');
            $mail->addAddress($email);
            $mail->addAddress('admin@zionx.dev.br');
            $mail->addCC($email, 'Cópia');
            $mail->addBCC($email, 'Cópia Oculta');

            $mail->isHTML(true);
            $mail->Subject = 'Alteração de Senha';
            $mail->Body = "
                
                <p>Olá, <b>$nome</b>! Obrigado por usar nossos serviços, ficamos felizes em poder te ajudar.</p>               
                <p><a href='https://zionx.dev.br/barber/login/atualizar.php?chave=$chave'>Clique aqui</a> para alterar sua senha.</p>
                <br>
                <span><i>Caso você não tenha solicitado a alteração de senha, ignore este e-mail.</i></span>
                <br><br>
                <span>---------</span>
                <br>
                <span><b>Administração - ZionX Technology</b></span>
                <br>
                <span>E-mail: <a href='mailto:admin@zionx.dev.br'><i>admin@zionx.dev.br</i></a></span>
                <br>
                <span>Telefone: <i>+55 (54) 99926-0755</i></span>
                <br><br>
                <span><i>E-mail gerado automaticamente, não responda.</i></span>
            ";

            if (!$mail->send()) {
                echo "<script>alert('Erro na solicitação: " . $mail->ErrorInfo . ". Entre em contato com o suporte através do telefone (54) 99926-0755.'); document.location='../index.php';</script>";
            } else {

                $sql = $pdo->prepare("SELECT * FROM login WHERE email_log = :email");
                $sql->bindParam(":email", $email);
                $sql->execute();
                $resultado = $sql->fetch(PDO::FETCH_ASSOC);

                $data = date('Y-m-d H:i:s');
                $acao = "Usuário solicitou a troca da senha";
                $inserir_logs_user = $pdo->prepare("INSERT INTO logs (data_logs, acao_logs, user_logs, cpf_logs, nivel_logs, ip_logs) VALUES (:data, :acao, :user, :cpf, :nivel, :ip)");

                $inserir_logs_user->bindParam(':data', $data);
                $inserir_logs_user->bindParam(':acao', $acao);
                $inserir_logs_user->bindParam(':user', $resultado['nome_log']);
                $inserir_logs_user->bindParam(':cpf', $resultado['cpf_log']);
                $inserir_logs_user->bindParam(':nivel', $resultado['nivel_log']);
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
