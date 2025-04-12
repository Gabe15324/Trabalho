<?php
session_start();
include 'dados/receitas.php';
include 'RES/header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$receita = null;

// Busca a receita na sessão
foreach ($_SESSION['receitas'] as $item) {
    if ($item['id'] == $id) {
        $receita = $item;
        break;
    }
}

// Se a receita não for encontrada, exibe uma mensagem
if (!$receita) {
    echo '<p>Receita n�o encontrada.</p>';
    include 'RES/footer.php';
    exit;
}

// Se a requisição for para editar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualiza os dados da receita
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : $receita['titulo'];
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : $receita['categoria'];
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : $receita['descricao'];
    
    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // Remove a imagem antiga
        if (file_exists($receita['imagem'])) {
            unlink($receita['imagem']);
        }
        
        // Processa a nova imagem
        $imagemTemp = $_FILES['imagem']['tmp_name'];
        $imagemNome = basename($_FILES['imagem']['name']);
        $imagemDestino = 'uploads/' . $imagemNome; // Ajuste o caminho conforme necess�rio

        // Move o arquivo para o diret�rio de uploads
        if (move_uploaded_file($imagemTemp, $imagemDestino)) {
            $receita['imagem'] = $imagemDestino; // Atualiza o caminho da imagem
        } else {
            echo '<p class="text-danger">Erro ao mover o arquivo para o diretório de uploads.</p>';
        }
    }

    // Atualiza os dados da receita
    $receita['titulo'] = $titulo;
    $receita['categoria'] = $categoria;
    $receita['descricao'] = $descricao;

    // Atualiza a receita na sessão
    foreach ($_SESSION['receitas'] as &$item) {
        if ($item['id'] == $id) { // Corrigido aqui
            $item = $receita;
            break;
        }
    }

    // Redireciona após a edição
    header('Location: detalhes.php?id=' . $id);
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h2>Editar Receita</h2>
                    <form method="POST" action="editar.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" name="titulo" value="<?php echo htmlspecialchars($receita['titulo']); ?>" placeholder="T�tulo" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoria</label>
                            <input type="text" class="form-control" name="categoria" value="<?php echo htmlspecialchars($receita['categoria']); ?>" placeholder="Categoria" required>
                        </div>
                        <div class="form-group">
                            <label for="imagem">Nova Imagem (opcional)</label>
                            <input type="file" class="form-control" name="imagem" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrção</label>
                            <textarea class="form-control" name="descricao" rows="3" placeholder="descreva a sua receita" required><?php echo htmlspecialchars($receita['descricao']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'RES/footer.php'; ?>