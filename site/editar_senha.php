<?php
require_once "../config/conecta_db.php";
require_once "secure/acesso.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_log = $_POST["id_log"];
    $senha_old = $_POST["senha_old"];
    $senha = $_POST["senha"];

    // Hash da nova senha
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

    // Seleciona o usuário com base no CPF
    $select_user = $pdo->prepare("SELECT * FROM login WHERE id_log = :id_log");
    $select_user->bindParam(":id_log", $id_log, PDO::PARAM_STR);
    $select_user->execute();
    $user = $select_user->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário foi encontrado e se a senha antiga está correta
    if ($user && password_verify($senha_old, $user['senha_log'])) {

        echo "Senha antiga correta";
        // Atualiza a senha do usuário
        $update_user = $pdo->prepare("UPDATE login SET senha_log = :senha WHERE id_log = :id_log");
        $update_user->bindParam(":id_log", $id_log, PDO::PARAM_STR);
        $update_user->bindParam(":senha", $senha_hashed, PDO::PARAM_STR);
        $update_user->execute();

        header("Location: perfil.php?update_senha=ok");
        exit();
    } else {
        // Se a senha antiga não for verificada ou o usuário não for encontrado, redireciona para erro
        header("Location: perfil.php?update_senha=erro");
        exit();
    }
} else {
    header("Location: perfil.php?update_senha=erro");
    exit();
}
?>
