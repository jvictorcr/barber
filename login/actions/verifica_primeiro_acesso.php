<?php
require_once '../config/conecta_db.php';

if (isset($_GET['chave']) || isset($_GET['cpf'])) {
    $chave = trim($_GET['chave']);
    $cpf = trim($_GET['cpf']);
    $ip = trim($_GET['ip']);

    $consulta_chave = $pdo->prepare("SELECT COUNT(*) as count FROM login_user WHERE primeiro_acesso = :chave");
    $consulta_chave->bindParam(":chave", $chave);
    $consulta_chave->execute();
    $chave_existe = $consulta_chave->fetch(PDO::FETCH_ASSOC);

    if ($chave_existe['count'] > 0) {

        $situacao = "Ativo";
        $primeiro_acesso = $pdo->prepare("UPDATE login_user SET situacao_user = :situacao , primeiro_acesso = NULL WHERE cpf_user = :cpf");
        $primeiro_acesso->bindValue(":situacao", $situacao);
        $primeiro_acesso->bindValue(":cpf", $cpf);
        $primeiro_acesso->execute();

        $consulta_user = $pdo->prepare("SELECT * FROM cadastro_geral_cidadao WHERE cpf_user = :cpf");
        $consulta_user->bindParam(":cpf", $cpf);
        $consulta_user->execute();
        $resultado_user = $consulta_user->fetch(PDO::FETCH_ASSOC);

        $data = date('Y-m-d H:i:s');
        $acao = "Usuário entrou no sistema";
        $inserir_logs_user = $pdo->prepare("INSERT INTO logs_user (data_logs, acao_logs, user_logs, cpf_logs, nivel_logs, ip_logs) VALUES (:data, :acao, :user, :cpf, :nivel, :ip)");

        $inserir_logs_user->bindParam(':data', $data);
        $inserir_logs_user->bindParam(':acao', $acao);
        $inserir_logs_user->bindParam(':user', $resultado_user['nome_user']);
        $inserir_logs_user->bindParam(':cpf', $cpf);
        $inserir_logs_user->bindParam(':nivel', $resultado_user['nivel_user']);
        $inserir_logs_user->bindParam(':ip', $ip);
        $inserir_logs_user->execute();
        session_start();

        $_SESSION['logado'] = true;
        $_SESSION['id_user'] = $resultado_user['id_user'];
        $_SESSION['nome_user'] = $resultado_user['nome_user'];
        $_SESSION['cpf_user'] = $resultado_user['cpf_user'];
        $_SESSION['email_user'] = $resultado_user['email_user'];
        $_SESSION['nivel_user'] = $resultado_user['nivel_user'];
        $_SESSION['perfil_user_completo'] = $resultado_user['perfil_user_completo'];

        header('Location: ../../site/');
    } else {
        echo "<script>alert('Oops... Link inválido!'); document.location='../index.php';</script>";
    }
} else {
    echo "<script>alert('Oops... Link inválido!'); document.location='../index.php';</script>";
}
