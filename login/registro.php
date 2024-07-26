<!doctype html>
<html lang="pt-br">

<head>
    <title>Barber Shopp - Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="assets/images/download.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/control.css">
    <script>
        // Função para obter o IP do navegador
        function getIP() {
            fetch('https://api.ipify.org?format=json')
                .then(response => response.json())
                .then(data => {
                    var ip = data.ip;
                    document.getElementById('ip').value = ip; // Preenche o campo oculto com o IP
                })
                .catch(error => {
                    console.log(error);
                });
        }
        // Chama a função para obter o IP
        getIP();
    </script>
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
                                <div class="w-100" style="padding-top: 15px;">
                                    <h3 class="text-center">Barber Shopp</h3>
                                </div>
                            </div>
                            <div id="card-nome" class="w-100">
                                <h5 class="mb-2 text-center">Developed by ZionX</h5>
                            </div>
                        </div>
                        <div id="card-form" class="login-wrap p-4 p-md-5">
                            <form action="actions/verifica_registro.php" class="signin-form" method="POST">
                                <input type="hidden" name="ip" id="ip">

                                <div class="w-100">
                                    <h5 class="mb-2 text-center">Criar conta</h5>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="label" for="cpf">Nome do cidadão</label>
                                    <input id="nome" name="nome" type="text" class="form-control" placeholder="Coloque seu nome" maxlength="100" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="label" for="cpf">cpf do cidadão</label>
                                    <input id="cpf" name="cpf" type="text" class="form-control" placeholder="Coloque seu cpf" maxlength="14" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="label" for="email">Email pessoal</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Coloque seu email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-10" style="padding-right: 0px;">
                                            <label class="label" for="password">crie uma senha forte</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Coloque sua senha" minlength="8" required>
                                        </div>
                                        <div class="col-2" style="padding-left: 5px; padding-top: 34px;">
                                            <a onclick="togglePass()" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="width: 100%; height: 47px; border-color: black; cursor: pointer; background-color: #E8F0FE;">
                                                <i id="eyeIcon" class="far fa-eye-slash" style="color: black;"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <small id="passwordHelp" class="form-text" style="font-size: 0.75em; text-align: right; display: block; color: #e57373;">
                                            Caracteres especiais, letras maiúsculas e minúsculas, e números.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="aceito" name="termos" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault" align="justify">
                                        Eu li e aceito a <a href="https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm" target="_blank" style="color: #e62e05"><i>Lei Geral de Proteção de Dados (LGPD)</i></a></i>.
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btn-login" class="form-control btn btn-primary btn-register rounded submit px-3">Criar conta</button>
                                </div>
                            </form>
                            <p class="text-center" style="margin-bottom: 0px;"><a href="../login/">Voltar para o login</a></p>
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