<?php
require_once "../config/conecta_db.php";
require_once "secure/acesso.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_user = $_POST["id_user"];
    $nome = $_POST["fullName"];
    $sobre = $_POST["about"];
    $barbearia = $_POST["company"];
    $profissao = $_POST["job"];
    $pais = $_POST["country"];
    $endereco = $_POST["address"];
    $celular = $_POST["phone"];
    $email = $_POST["email"];
    $twitter = $_POST["twitter"];
    $facebook = $_POST["facebook"];
    $instagram = $_POST["instagram"];
    $linkedin = $_POST["linkedin"];

    $update_user = $pdo->prepare("UPDATE usuarios SET nome_user = :nome, descricao_user = :sobre, barbearia_user = :barbearia, profissao_user = :profissao, pais_user = :pais, endereco_user = :endereco, celular_user = :celular, email_user = :email, twitter_user = :twitter, facebook_user = :facebook, instagram_user = :instagram, linkedin_user = :linkedin WHERE id_user = :id_user");
    $update_user->bindParam(":id_user", $id_user, PDO::PARAM_INT);
    $update_user->bindParam(":nome", $nome, PDO::PARAM_STR);
    $update_user->bindParam(":sobre", $sobre, PDO::PARAM_STR);
    $update_user->bindParam(":barbearia", $barbearia, PDO::PARAM_STR);
    $update_user->bindParam(":profissao", $profissao, PDO::PARAM_STR);
    $update_user->bindParam(":pais", $pais, PDO::PARAM_STR);
    $update_user->bindParam(":endereco", $endereco, PDO::PARAM_STR);
    $update_user->bindParam(":celular", $celular, PDO::PARAM_STR);
    $update_user->bindParam(":email", $email, PDO::PARAM_STR);
    $update_user->bindParam(":twitter", $twitter, PDO::PARAM_STR);
    $update_user->bindParam(":facebook", $facebook, PDO::PARAM_STR);
    $update_user->bindParam(":instagram", $instagram, PDO::PARAM_STR);
    $update_user->bindParam(":linkedin", $linkedin, PDO::PARAM_STR);
    $update_user->execute();

    header("Location: perfil.php?update=ok");
    exit();
} else {
    header("Location: perfil.php?update=erro");
    exit();
}
