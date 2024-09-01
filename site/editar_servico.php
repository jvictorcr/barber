<?php
require_once "../config/conecta_db.php";
require_once "secure/acesso.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_tipo']) && isset($_POST['nome_tipo']) && isset($_POST['preco_tipo']) && isset($_POST['descricao'])) {
        $ids = $_POST['id_tipo'];
        $nomes = $_POST['nome_tipo'];
        $precos = $_POST['preco_tipo'];
        $descricoes = $_POST['descricao'];

        try {
            $pdo->beginTransaction();

            foreach ($ids as $index => $id) {
                $nome = $nomes[$index];
                $preco = $precos[$index];
                $descricao = $descricoes[$index];

                $sql = "UPDATE tipos SET nome_tipo = ?, preco_tipo = ?, descricao = ? WHERE id_tipo = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $preco, $descricao, $id]);
            }

            $pdo->commit();
            header("Location: gerenciar.php?update_servicos=ok");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            header("Location: gerenciar.php?update_servicos=erro");
            exit();
        }
    } else {
        header("Location: gerenciar.php?update_servicos=erro");
        exit();
    }
}
?>
