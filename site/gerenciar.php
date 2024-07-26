<?php
require_once "../config/conecta_db.php";
require_once "secure/acesso.php";


date_default_timezone_set('America/Sao_Paulo');  // Configura o fuso horário

$id = $_SESSION['id_log'];
$consulta = $pdo->prepare("SELECT * FROM usuarios WHERE  id_user = :id_user");
$consulta->bindParam(':id_user', $id);
$consulta->execute();
$resultado= $consulta->fetch(PDO::FETCH_ASSOC);
?>

<?php
// Define o período padrão como 'hoje'
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'hoje';

// Data atual
$data_hoje = date('Y-m-d');

// Dados de comparação
$data_inicio = $data_fim = '';
$data_inicio_ano_passado = date('Y-01-01');
$data_fim_ano_passado = date('Y-12-31', strtotime('-1 year'));

// Define as datas com base no período selecionado
switch ($periodo) {
    case 'mensal':
        $data_inicio = date('Y-m-01'); // Primeiro dia do mês
        $data_fim = date('Y-m-t'); // Último dia do mês
        $data_inicio_ano_passado = date('Y-' . date('m') . '-01', strtotime('-1 year')); // Primeiro dia do mês do ano passado
        $data_fim_ano_passado = date('Y-' . date('m') . '-t', strtotime('-1 year')); // Último dia do mês do ano passado
        break;
    case 'anual':
        $data_inicio = date('Y-01-01'); // Primeiro dia do ano
        $data_fim = date('Y-12-31'); // Último dia do ano
        $data_inicio_ano_passado = date('Y-01-01', strtotime('-1 year')); // Primeiro dia do ano passado
        $data_fim_ano_passado = date('Y-12-31', strtotime('-1 year')); // Último dia do ano passado
        break;
    case 'hoje':
    default:
        $data_inicio = $data_hoje;
        $data_fim = $data_hoje;
        break;
}

// Consulta os atendimentos com base no período selecionado
$consulta = $pdo->prepare("SELECT COUNT(*) AS total_atendimentos, SUM(preco_ate) AS total_receita FROM atendimentos WHERE DATE(data_ate) BETWEEN ? AND ?");
$consulta->execute([$data_inicio, $data_fim]);
$resultado_atendimentos = $consulta->fetch(PDO::FETCH_ASSOC);
$total_atendimentos = $resultado_atendimentos['total_atendimentos'];
$total_receita = $resultado_atendimentos['total_receita'];

// Inicializa as variáveis de comparação
$percentual_atendimentos = 0;
$percentual_receita = 0;
$comparacao_atendimentos = '';
$comparacao_receita = '';
$classe_comparacao_atendimentos = '';
$classe_comparacao_receita = '';

// Calcula a comparação apenas para o filtro diário
if ($periodo === 'hoje') {
    // Data do dia anterior
    $data_ontem = date('Y-m-d', strtotime('-1 day', strtotime($data_hoje)));

    // Consulta os atendimentos do dia anterior
    $consulta_ontem = $pdo->prepare("SELECT COUNT(*) AS total_atendimentos, SUM(preco_ate) AS total_receita FROM atendimentos WHERE DATE(data_ate) = ?");
    $consulta_ontem->execute([$data_ontem]);
    $resultado_ontem = $consulta_ontem->fetch(PDO::FETCH_ASSOC);
    $total_atendimentos_ontem = $resultado_ontem['total_atendimentos'];
    $total_receita_ontem = $resultado_ontem['total_receita'];

    // Cálculo da variação percentual
    if ($total_atendimentos_ontem > 0) {
        $percentual_atendimentos = (($total_atendimentos - $total_atendimentos_ontem) / $total_atendimentos_ontem) * 100;
        if ($total_atendimentos > $total_atendimentos_ontem) {
            $classe_comparacao_atendimentos = 'text-success'; // Verde
            $comparacao_atendimentos = '+' . number_format($percentual_atendimentos, 2) . '%' . ' maior que ontem';
        } elseif ($total_atendimentos < $total_atendimentos_ontem) {
            $classe_comparacao_atendimentos = 'text-danger'; // Vermelho
            $comparacao_atendimentos = number_format($percentual_atendimentos, 2) . '%' . ' menor que ontem';
        } else {
            $classe_comparacao_atendimentos = 'text-warning'; // Laranja
            $comparacao_atendimentos = 'Nenhuma variação em relação a ontem';
        }
    } else {
        $classe_comparacao_atendimentos = $total_atendimentos > 0 ? 'text-success' : 'text-muted';
        $comparacao_atendimentos = $total_atendimentos > 0 ? 'Hoje teve atendimentos, mas ontem não.' : 'Sem dados de ontem';
    }

    if ($total_receita_ontem > 0) {
        $percentual_receita = (($total_receita - $total_receita_ontem) / $total_receita_ontem) * 100;
        if ($total_receita > $total_receita_ontem) {
            $classe_comparacao_receita = 'text-success'; // Verde
            $comparacao_receita = '+' . number_format($percentual_receita, 2) . '%' . ' maior que ontem';
        } elseif ($total_receita < $total_receita_ontem) {
            $classe_comparacao_receita = 'text-danger'; // Vermelho
            $comparacao_receita = number_format($percentual_receita, 2) . '%' . ' menor que ontem';
        } else {
            $classe_comparacao_receita = 'text-warning'; // Laranja
            $comparacao_receita = 'Nenhuma variação em relação a ontem';
        }
    } else {
        $classe_comparacao_receita = $total_receita > 0 ? 'text-success' : 'text-muted';
        $comparacao_receita = $total_receita > 0 ? 'Hoje teve receita, mas ontem não.' : 'Sem dados de ontem';
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">

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
                <span class="d-none d-lg-block">Barbearia do <?php echo $resultado['nome_user']; ?></span>
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
                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo $resultado['nome_user']; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $resultado['nome_user']; ?></h6>
                            <span>Barbeiro</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="perfil.php#profile-edit">
                                <i class="bi bi-gear"></i>
                                <span>configurações da conta</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-question-circle"></i>
                                <span>Precisa de ajuda?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="secure/sair.php">
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
                <a class="nav-link collapsed" href="atendimentos.php">
                    <i class="bi bi-briefcase"></i>
                    <span>Atendimentos</span>
                </a>
            </li><!-- End Work Page Nav -->
            <li class="nav-item">
                <a class="nav-link" href="gerenciar.php">
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
        <?php
        $consulta = $pdo->prepare("SELECT * FROM tipos");
        $consulta->execute();
        ?>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <div class="col-md-12">
                        <label class="card-title w-100 text-center mb-2">Tipos e valores de atendimentos</label>
                        <form action="editar_servico.php" method="POST">
                            <div class="row">
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
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body d-flex flex-column flex-md-row align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light p-3 me-md-3 mt-2 mt-md-0"
                                                    style="width: 100px; height: 100px;">
                                                    <i class="<?php echo $icon_class; ?>" style="font-size: 2rem;"></i>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="hidden" name="id_tipo[]"
                                                        value="<?php echo $resultado["id_tipo"]; ?>">
                                                    <div class="mb-2">
                                                        <label for="nome_tipo_<?php echo $resultado["id_tipo"]; ?>">Nome do
                                                            Tipo</label>
                                                        <input type="text" class="form-control"
                                                            id="nome_tipo_<?php echo $resultado["id_tipo"]; ?>"
                                                            name="nome_tipo[]"
                                                            value="<?php echo $resultado["nome_tipo"]; ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label
                                                            for="preco_tipo_<?php echo $resultado["id_tipo"]; ?>">Preço</label>
                                                        <input type="text" class="form-control"
                                                            id="preco_tipo_<?php echo $resultado["id_tipo"]; ?>"
                                                            name="preco_tipo[]"
                                                            value="<?php echo $resultado["preco_tipo"]; ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label
                                                            for="descricao_<?php echo $resultado["id_tipo"]; ?>">Descrição</label>
                                                        <textarea class="form-control"
                                                            id="descricao_<?php echo $resultado["id_tipo"]; ?>"
                                                            name="descricao[]"><?php echo $resultado["descricao"]; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

</body>
<?php if (isset($_GET['update_servicos']) && $_GET['update_servicos'] === 'erro') {
    echo "<script>alert('Erro ao atualizar os serviços, tente novamente!');</script>";
}
if (isset($_GET['update_servicos']) && $_GET['update_servicos'] === 'ok') {
    echo "<script>alert('Serviços atualizados com sucesso!');</script>";
}
?>

</html>