<?php
session_start();
include 'dados/receitas.php';
include 'RES/header.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; 
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    if (isset($_SESSION['receitas']) && is_array($_SESSION['receitas'])) {
        foreach ($_SESSION['receitas'] as $key => $receita) {
            if ($receita['id'] == $deleteId) {
                $filePath = $receita['imagem']; 

                unset($_SESSION['receitas'][$key]);
                $_SESSION['receitas'] = array_values($_SESSION['receitas']); 

                if (file_exists($filePath)) {
                    unlink($filePath); 
                }
                break;
            }
        }
    }
}
?>

<div class="container mt-4">
    <div class="mb-2">
        <div class="card text-center text-dark">
            <div class="card-body">
                <h1 class="card-title">Receitas</h1>
                <p class="card-text">Descubra deliciosas receitas para todos os gostos!</p>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <div class="card text-center >">
            <div class="card-body">
                <div class="row">
                    <?php if (isset($_SESSION['receitas']) && is_array($_SESSION['receitas']) && count($_SESSION['receitas']) > 0): ?>
                        <?php foreach ($_SESSION['receitas'] as $receita): ?>
                            <div class="col-md-3 mb-5">
                                <div class="card text-dark ">
                                    <div class="card-body">
                                        <img src="<?= htmlspecialchars($receita['imagem']) ?>" class="img-thumbnail" alt="<?= htmlspecialchars($receita['titulo']) ?>">
                                        <h5 class="card-title">Título: <?= htmlspecialchars($receita['titulo']) ?></h5>
                                        <a href="detalhes.php?id=<?= $receita['id'] ?>" class="btn btn-primary">Ver mais</a>
                                        <a href="?delete_id=<?= $receita['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta receita?');">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <h4>
                                <span class="text-danger">
                                    Nenhuma receita cadastrada.
                                </span> 
                            </h4>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="protegido.php" class="btn btn-success mb-3">Adicionar Nova Receita</a>
            </div>
        </div>
    </div>
</div>
<?php include 'RES/footer.php'; ?>