<?php
function filtrarReceitasPorCategoria($receitas, $categoria) {
    return array_filter($receitas, function($receita) use ($categoria) {
        return $receita['categoria'] === $categoria;
    });
}

function salvarReceitas($receitas) {
    file_put_contents('dados/receitas.txt', json_encode($receitas));
}

function carregarReceitas() {
    if (file_exists('dados/receitas.txt')) {
        $conteudo = file_get_contents('dados/receitas.txt');
        return json_decode($conteudo, true); 
    }
    return []; 
}


?>