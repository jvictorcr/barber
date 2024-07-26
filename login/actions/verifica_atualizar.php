<?php
require_once '../config/conecta_db.php';

if (isset($_POST['btn-altera'])) {
  $senha = trim($_POST['password']);
  $chave = trim($_POST['chave']);


  $consulta_chave = $pdo->prepare("SELECT COUNT(*) as count FROM login_user WHERE recuperar_user = :chave");
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
        $update_senha = $pdo->prepare("UPDATE login_user SET senha_user = :senha, recuperar_user = NULL, situacao_user = 'Ativo', quant_erros_user = 0, data_bloc = NULL WHERE recuperar_user = :chave");
        $update_senha->bindParam(":senha", $senha_cripto);
        $update_senha->bindParam(":chave", $chave);
        $update_senha->execute();

        echo "<script>alert('Senha trocada com sucesso! Faça seu login.'); window.location.href='https://pmsoledaders.inf.br/cadastro_geral/login'; </script>";
      } catch (PDOException $e) {
        $error = $e->getMessage();
        echo "<script>alert('Oops... Parece que não foi possível atualizar sua senha. Contate o desenvolvedor do sistema pelo número (54) 3381-9040. Erro: $error'); window.location.href='https://pmsoledaders.inf.br/cadastro_geral/login/'; </script>";
      }
    }
  } else {
    echo "<script>alert('Oops... Link inválido, solicite a alteração de senha novamente!'); document.location='../recuperar.php';</script>";
  }
}
