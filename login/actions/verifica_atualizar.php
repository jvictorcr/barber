<?php
require_once '../config/conecta_db.php';

if (isset($_POST['btn-altera'])) {
  $senha = trim($_POST['password']);
  $chave = trim($_POST['chave']);


  $consulta_chave = $pdo->prepare("SELECT COUNT(*) as count FROM login WHERE recuperar_log = :chave");
  $consulta_chave->bindParam(":chave", $chave);
  $consulta_chave->execute();
  $chave_existe = $consulta_chave->fetch(PDO::FETCH_ASSOC);

  if ($chave_existe['count'] > 0) {

    if (strlen($senha) < 8) {
      echo "<script>alert('A senha deve ter pelo menos 8 caracteres.'); document.location='../index.php';</script>";
    } elseif (!preg_match('/[A-Z]/', $senha)) {
      echo "<script>alert('A senha deve conter pelo menos uma letra maiúscula.'); document.location='../atualizar.php?chave=$chave';</script>";
    } elseif (!preg_match('/[a-z]/', $senha)) {
      echo "<script>alert('A senha deve conter pelo menos uma letra minúscula.'); document.location='../atualizar.php?chave=$chave';</script>";
    } elseif (!preg_match('/[0-9]/', $senha)) {
      echo "<script>alert('A senha deve conter pelo menos um número.'); document.location='../atualizar.php?chave=$chave';</script>";
    } elseif (!preg_match('/[\W]/', $senha)) {
      echo "<script>alert('A senha deve conter pelo menos um caractere especial.'); document.location='../atualizar.php?chave=$chave';</script>";
    } else {
      $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

      try {
        $update_senha = $pdo->prepare("UPDATE login SET senha_log = :senha, recuperar_log = NULL, situacao_log = 'Ativo', quant_erros_log = 0, data_bloc_log = NULL WHERE recuperar_log = :chave");
        $update_senha->bindParam(":senha", $senha_cripto);
        $update_senha->bindParam(":chave", $chave);
        $update_senha->execute();

        echo "<script>alert('Senha trocada com sucesso! Faça seu login.'); window.location.href='https://zionx.dev.br/barber/login/'; </script>";
      } catch (PDOException $e) {
        $error = $e->getMessage();
        echo "<script>alert('Oops... Parece que não foi possível atualizar sua senha. Contate o desenvolvedor do sistema pelo número (54) 99926-0755. Erro: $error'); window.location.href='https://zionx.dev.br/barber/login/'; </script>";
      }
    }
  } else {
    echo "<script>alert('Oops... Link inválido, solicite a alteração de senha novamente!'); document.location='../recuperar.php';</script>";
  }
}
