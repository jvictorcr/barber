<?php
session_start();

include_once '../config/conecta_db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cpf = strip_tags(trim($_POST['cpf']));
    $senha = strip_tags(trim($_POST['password']));
    $ip = strip_tags(trim($_POST['ip']));

    if (empty($cpf) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); document.location='../index.php';</script>";
    } else {
        $sql = $pdo->prepare("SELECT * FROM login WHERE cpf_log = :cpf");
        $sql->bindParam(":cpf", $cpf);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        if ($resultado > 0) {

            if ($resultado['situacao_log'] == 'Inativo') {
                echo "<script>alert('Usuário bloqueado! recupere sua senha ou entre em contato com o suporte pelo telefone (54) 3381-9040. Se for seu primeiro acesso, verifique seu Email.'); document.location='../index.php';</script>";
            } else {
                if (password_verify($senha, $resultado['senha_log'])) {
                    $update_erro = $pdo->prepare("UPDATE login SET quant_erros_log = 0 WHERE cpf_log = :cpf");
                    $update_erro->bindParam(":cpf", $cpf);
                    $update_erro->execute();
                    $data = date('Y-m-d H:i:s');
                    
                    $acao = "Usuário entrou no sistema";
                    $inserir_logs_log = $pdo->prepare("INSERT INTO logs (data_logs, acao_logs, user_logs, cpf_logs, nivel_logs, ip_logs) VALUES (:data, :acao, :log, :cpf, :nivel, :ip)");

                    $inserir_logs_log->bindParam(':data', $data);
                    $inserir_logs_log->bindParam(':acao', $acao);
                    $inserir_logs_log->bindParam(':log', $resultado['nome_log']);
                    $inserir_logs_log->bindParam(':cpf', $cpf);
                    $inserir_logs_log->bindParam(':nivel', $resultado['nivel_log']);
                    $inserir_logs_log->bindParam(':ip', $ip);
                    $inserir_logs_log->execute();


                    $consulta_log = $pdo->prepare("SELECT * FROM usuarios WHERE cpf_user = :cpf");
                    $consulta_log->bindParam(":cpf", $cpf); 
                    $consulta_log->execute();
                    $resultado_log = $consulta_log->fetch(PDO::FETCH_ASSOC);
                    
                    session_start();

                    $_SESSION['logado'] = true;
                    $_SESSION['id_log'] = $resultado_log['id_user'];
                    $_SESSION['nome_log'] = $resultado_log['nome_user'];
                    $_SESSION['cpf_log'] = $resultado_log['cpf_user'];
                    $_SESSION['email_log'] = $resultado_log['email_user'];
                    $_SESSION['nivel_log'] = $resultado_log['nivel_user'];

                    header('Location: ../../site/');
                } else {

                    $update_erro = $pdo->prepare("UPDATE login SET quant_erros_log = quant_erros_log + 1 WHERE cpf_log = :cpf");
                    $update_erro->bindParam(":cpf", $cpf);
                    $update_erro->execute();

                    $consulta_erro = $pdo->prepare("SELECT quant_erros_log FROM login WHERE cpf_log = :cpf");
                    $consulta_erro->bindParam(":cpf", $cpf);
                    $consulta_erro->execute();
                    $consulta = $consulta_erro->fetch(PDO::FETCH_ASSOC);
                    $erros = $consulta["quant_erros_log"];

                    if ($erros <= 4) {
                        echo "<script>alert('A senha não confere! Tente novamente. (Tentativa $erros de 5)'); document.location='../index.php';</script>";
                    } else {
                        $data_bloq = date('Y-m-d H:i:s');

                        $update_bloc = $pdo->prepare("UPDATE login SET situacao_log = 'Inativo', data_bloc_log = :data_bloc WHERE cpf_log = :cpf");
                        $update_bloc->bindParam(":cpf", $cpf);
                        $update_bloc->bindParam(":data_bloc", $data_bloq);
                        $update_bloc->execute();

                        echo "<script>alert('Sua Conta foi Bloqueada por mais de 5 tentativas de Login'); document.location='../index.php';</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Oops... O CPF não foi encontrado! Tente novamente ou faça o primeiro acesso.'); document.location='../index.php';</script>";
        }
    }
}
