<?php
session_start();
include 'RES/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($usuario) || empty($senha)) {
        echo '<p class="text-danger">Por favor, preencha todos os campos.</p>';
    } else {
        $usuarioValido = 'administrador';
        $senhaHash = md5('4451');

        if ($usuario === $usuarioValido && md5($senha, $senhaHash)) {
            $_SESSION['usuario'] = $usuario;
            header('Location: protegido.php');
            exit;
        } else {
            echo '<p class="text-danger">Usuário ou senha inválidos.</p>';
        }
    }
}
?>

<form method="POST" action="login.php">
    <div class="container">
        <div class="card text-dark">
            <div class="card-body">
                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" class="form-control" name="usuario" placeholder="Nome do usuario" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" name="senha" placeholder="Senha do usuario" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</form>

<?php include 'RES/footer.php'; ?>