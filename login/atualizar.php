<?php $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT); ?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>Barber Shopp - Senha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="assets/images/download.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/control.css">
</head>

<body>
    <section class="ftco-section" style="margin-top: 5px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <img class="img-fluid img-responsive" src="assets/images/download.jpg" alt="Brasão">
                            </div>
                            <div class="d-flex">
                                <div class="w-100" style="padding-top: 50px;">
                                    <h3 class="text-center">Barber Shopp System</h3>
                                </div>
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4 text-center">Atualizar Senha</h3>
                                </div>
                            </div>
                            <div class="w-100">
                                <h5 class="mb-2 text-center">Criar nova senha</h5>
                            </div>
                            <form action="actions/verifica_atualizar.php" class="signin-form" method="POST">
                                <div class="form-group mb-0">
                                    <div class="row align-items-center">
                                        <div class="col-10" style="padding-right: 0px;">
                                            <label class="label" for="password">nova senha</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Coloque uma senha nova" minlength="8" required>
                                        </div>
                                        <div class="col-2" style="padding-left: 5px; padding-top: 34px;">
                                            <a onclick="togglePass()" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="width: 100%; height: 47px; border-color: black; cursor: pointer; background-color: #E8F0FE;">
                                                <i id="eyeIcon" class="far fa-eye-slash" style="color: black;"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row align-items-center ml-1 mb-3">
                                        <small id="passwordHelp" class="form-text" style="font-size: 0.75em; text-align: right; display: block; color: #e57373;">
                                            Caracteres especiais, letras maiúsculas e minúsculas, e números.
                                        </small>
                                    </div>
                                </div>
                                <input type="hidden" name="chave" value="<?php echo $chave; ?>">
                                <div class="form-group">
                                    <button type="submit" name="btn-altera" class="form-control btn btn-primary btn-alter rounded submit px-3">Trocar senha</button>
                                </div>
                            </form>
                            <p class="text-center"><a href="https://zionx.dev.br/barber/login/index.php">Voltar para o login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/control.js"></script>
</body>

</html>