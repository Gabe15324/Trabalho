<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Inicializa a chave 'receitas' se não estiver definida
if (!isset($_SESSION['receitas'])) {
    $_SESSION['receitas'] = [];
}

include 'RES/header.php';

if (!isset($_SESSION['categorias'])) {
    $_SESSION['categorias'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';

    if (!in_array($categoria, $_SESSION['categorias'])) {
        $_SESSION['categorias'][] = $categoria; 
    }

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTemp = $_FILES['imagem']['tmp_name'];
        $imagemNome = basename($_FILES['imagem']['name']);
        $imagemDestino = 'uploads/' . $imagemNome;

        if (move_uploaded_file($imagemTemp, $imagemDestino)) {
            $novoItem = [
                'id' => count($_SESSION['receitas']) + 1,
                'titulo' => $titulo,
                'categoria' => $categoria,
                'imagem' => $imagemDestino,
                'descricao' => $descricao
            ];
            $_SESSION['receitas'][] = $novoItem;
            header('Location: index.php');
            exit;
        } else {
            echo '<p class="text-danger">Erro ao mover o arquivo para o diretório de uploads.</p>';
        }
    } else {
        echo '<p class="text-danger">Por favor, envie uma imagem válida.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Item</title>
</head>
<body>
    
    <div class="container text-dark">
        <div class="mb-2">
            <div class="card text-center">
                <div class="card-body"> 
                    <h2>Cadastrar Novo Item</h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body"> 
                <form method="POST" action="protegido.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <input type="text" class="form-control" name="categoria" placeholder="Categoria" required>
                    </div>
                    <div class="form-group">
                        <label for="imagem">Imagem</label>
                        <input type="file" class="form-control" name="imagem" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" name="descricao" placeholder="Descreva a sua receita" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<br>

<?php include 'RES/footer.php'; ?>