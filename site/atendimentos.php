<?php
require_once "../config/conecta_db.php";

$id = '1';
$consulta = $pdo->prepare("SELECT * FROM usuarios WHERE  id_user = :id_user");
$consulta->bindParam(':id_user', $id);
$consulta->execute();
$resultado_user = $consulta->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Barbearia</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Barbearia do <?php echo $resultado_user['nome_user']; ?></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="../assets/img/profile-img.jpg" class="rounded-circle">
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo $resultado_user['nome_user']; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $resultado_user['nome_user']; ?></h6>
                            <span>Barbeiro</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>Meu perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>configurações da conta</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Precisa de ajuda?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sair</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Início</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link" href="atendimentos.php">
                    <i class="bi bi-briefcase"></i>
                    <span>Atendimentos</span>
                </a>
            </li><!-- End Work Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="gerenciar.php">
                    <i class="bi bi-gear"></i>
                    <span>Gerenciar serviços</span>
                </a>
            </li><!-- End config Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="perfil.php">
                    <i class="bi bi-person"></i>
                    <span>Perfil</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="sair.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Sair</span>
                </a>
            </li><!-- End Login Page Nav -->
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Realizar atendimentos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Atendimentos</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <?php
                            $consulta = $pdo->prepare("SELECT * FROM tipos");
                            $consulta->execute();
                            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="atender.php" method="POST" id="form-atendimento">
                                        <input type="hidden" name="id_user" value="<?php echo $resultado_user['id_user']; ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="select-container">
                                                    <div class="form-group">
                                                        <label for="tipo1"
                                                            class="card-title w-100 text-center">Selecione o tipo de
                                                            atendimento</label>
                                                        <select class="form-select" name="tipo[]" id="tipo1">
                                                            <option value="">Serviços oferecidos</option>
                                                            <?php
                                                            do {
                                                                echo '<option value="' . $resultado['id_tipo'] . '">' . $resultado['nome_tipo'] . '</option>';
                                                            } while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC));
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12" style="text-align: center;">
                                                <div id="select-container">
                                                    <label for="pagamento"
                                                        class="card-title w-100 text-center">Selecione o método de
                                                        pagamento</label>
                                                    <select class="form-select" name="pagamento" id="pagamento">
                                                        <option value="">Tipos de pagamentos</option>
                                                        <option value="dinheiro">Dinheiro</option>
                                                        <option value="pix">Pix</option>
                                                        <option value="cartao_credito">Cartão de Crédito</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12 col-md-4 mb-3">
                                                <button type="button" class="btn btn-primary w-100"
                                                    id="add-select">Adicionar campo</button>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <button type="reset" class="btn btn-secondary w-100">Limpar
                                                    campos</button>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <button type="submit" class="btn btn-success w-100">Concluir
                                                    atendimento</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <label class="card-title w-100 text-center mb-2">Tipos e valores de
                                        atendimentos</label>
                                    <?php
                                    $consulta->execute(); // Executar a consulta novamente para listar os tipos de atendimento
                                    while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                        // Determinar o ícone com base no tipo de atendimento
                                        $icon_class = '';
                                        switch ($resultado["nome_tipo"]) {
                                            case 'Cabelo':
                                                $icon_class = 'bi bi-scissors'; // Ícone de tesoura para cabelo
                                                break;
                                            case 'Barba':
                                                $icon_class = 'bi bi-bezier'; // Ícone de barba
                                                break;
                                            case 'Sobrancelha':
                                                $icon_class = 'bi bi-eye'; // Ícone de olho para sobrancelha
                                                break;
                                            default:
                                                $icon_class = 'bi bi-scissors'; // Ícone padrão, caso não haja correspondência
                                                break;
                                        }
                                        ?>
                                        <div class="card mb-3">
                                            <div class="card-body d-flex flex-column flex-md-row align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light p-3 me-md-3 mt-2 mt-md-0"
                                                    style="width: 100px; height: 100px;">
                                                    <i class="<?php echo $icon_class; ?>" style="font-size: 2rem;"></i>
                                                </div>
                                                <div class="col-md-8">
                                                    <h5 class="card-title text-center">
                                                        <?php echo $resultado["nome_tipo"]; ?>
                                                    </h5>
                                                    <p class="card-text"><b>Preço: R$</b>
                                                        <?php echo $resultado["preco_tipo"]; ?></p>
                                                    <p class="card-text mt-3 mt-md-0"><b>Descrição:
                                                        </b><?php echo $resultado["descricao"]; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Sales Card -->
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
    <!-- Script para adicionar e remover campos de seleção -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const addButton = document.getElementById("add-select");
            const selectContainer = document.getElementById("select-container");
            let selectCount = 1; // Contador para os selects adicionados

            addButton.addEventListener("click", function () {
                if (selectCount < 3) { // Limite de 3 selects
                    selectCount++;

                    // Criar novo select
                    const newSelectGroup = document.createElement("div");
                    newSelectGroup.classList.add("form-group");
                    newSelectGroup.style.marginTop = "5px";
                    newSelectGroup.id = "select-group" + selectCount;

                    const newSelectLabel = document.createElement("label");
                    newSelectLabel.setAttribute("for", "tipo" + selectCount);

                    const newSelect = document.createElement("select");
                    newSelect.classList.add("form-select");
                    newSelect.setAttribute("name", "tipo[]");
                    newSelect.setAttribute("id", "tipo" + selectCount);
                    newSelect.innerHTML = `
            <option value="">Serviços oferecidos</option>
            <?php
            // Reiniciar a consulta para exibir todas as opções novamente
            $consulta->execute();
            while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $resultado['id_tipo'] . '">' . $resultado['nome_tipo'] . '</option>';
            }
            ?>
        `;

                    const removeButton = document.createElement("button");
                    removeButton.type = "button";
                    removeButton.classList.add("btn", "btn-danger", "ml-2", "mt-1");
                    removeButton.textContent = "Excluir campo";
                    removeButton.addEventListener("click", function () {
                        selectContainer.removeChild(newSelectGroup);
                        selectCount--;
                    });

                    newSelectGroup.appendChild(newSelectLabel);
                    newSelectGroup.appendChild(newSelect);
                    newSelectGroup.appendChild(removeButton);
                    selectContainer.appendChild(newSelectGroup);
                } else {
                    alert("Você atingiu o máximo de 3 campos de seleção.");
                }
            });
        });
    </script>

</body>
<?php if (isset($_GET['metodo']) && $_GET['metodo'] === 'erro') {
    echo "<script>alert('Erro no metodo de comunicação!');</script>";
}
if (isset($_GET['tipo']) && $_GET['tipo'] === 'erro') {
    echo "<script>alert('Nenhum serviço foi selecionado!');</script>";
}
if (isset($_GET['pagamento']) && $_GET['pagamento'] === 'erro') {
    echo "<script>alert('Nenhum metodo de pagamento foi selecionado!');</script>";
}if (isset($_GET['atendimento']) && $_GET['atendimento'] === 'ok') {
    echo "<script>alert('Atendimento adicionado com sucesso!');</script>";
}
 ?>

</html>