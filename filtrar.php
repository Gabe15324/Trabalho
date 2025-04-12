<?php
session_start();
include 'dados/receitas.php';
include 'funcoes/funcoes.php';
include 'RES/header.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit; 
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

$receitas = isset($_SESSION['receitas']) && is_array($_SESSION['receitas']) ? $_SESSION['receitas'] : [];

$receitasFiltradas = $categoria ? filtrarReceitasPorCategoria($receitas, $categoria) : $receitas;

$categorias = isset($_SESSION['categorias']) ? $_SESSION['categorias'] : [];
$categoriasValidas = [];

foreach ($categorias as $cat) {
    foreach ($receitas as $receita) {
        if ($receita['categoria'] === $cat) {
            $categoriasValidas[] = $cat;
            break; 
        }
    }
}

$categoriasValidas = array_unique($categoriasValidas);
?>

<div class="container">
    <div class="card text-dark  mb-3">
        <div class="card-body text-center">
            <h1 >Receitas</h1>
            <p >Descubra deliciosas receitas para todos os gostos!</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="filtrar.php" class="mb-4">
                <div class="form-group">
                    <label for="categoria" class=" text-dark">Filtrar por Categoria</label>
                    <select name="categoria" class="form-control" onchange="this.form.submit()">
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categoriasValidas as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($categoria == $cat ? 'selected' : ''); ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <div class="row">
                <?php if (!empty($receitasFiltradas)): ?>
                    <?php foreach ($receitasFiltradas as $receita): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-light shadow-sm">
                                <img src="<?php echo htmlspecialchars($receita['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($receita['titulo']); ?>">
                                <div class="card-body text-dark">
                                    <h5 class="card-title"><?php echo htmlspecialchars($receita['titulo']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($receita['descricao']); ?></p>
                                    <a href="detalhes.php?id=<?php echo $receita['id']; ?>" class="btn btn-primary">Ver mais</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <h4 class="text-center">
                            <span class="text-danger"> 
                                Nenhuma receita encontrada.
                            </span>
                        </h4>
                    </div>
                <?php endif; ?>
            </div>  
        </div>
    </div>
</div>

<?php include 'RES/footer.php'; ?>

<br>