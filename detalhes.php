<?php
session_start();
include 'dados/receitas.php';
include 'RES/header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$receita = null;

foreach ($_SESSION['receitas'] as $item) {
    if ($item['id'] == $id) {
        $receita = $item;
        break;
    }
}

if (!$receita) {
    echo '<p>Receita não encontrada.</p>';
    include 'RES/footer.php';
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8"> 
            <div class="mb-4">
                <div class="card shadow-lg"> 
                    <div class="card-body text-center">
                        <h1 class="card-title text-dark mb-3"> Titulo: 
                            <?php echo htmlspecialchars($receita['titulo']); ?>
                        </h1>
                        <img class="img-fluid rounded mb-3" src="<?php echo htmlspecialchars($receita['imagem']); ?>" alt="<?php echo htmlspecialchars($receita['titulo']); ?>">
                        <h5 class="card-subtitle text-muted mb-3"> 
                            Categoria: <?php echo htmlspecialchars($receita['categoria']); ?>
                        </h5>
                        <div class="card w-100 mx-auto mb-3"> 
                            <div class="card-body">
                                <h6 class="card-title">Descrição:</h6> 
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($receita['descricao'])); ?></p> 
                            </div>
                        </div>
                        <a href="editar.php?id=<?php echo $id; ?>" class="btn btn-success mt-2">Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'RES/footer.php'; ?>