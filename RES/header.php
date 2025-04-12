<?php

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light'; 
}

$bodyClass = $_SESSION['theme'] === 'dark' ? 'dark-mode' : 'light-mode';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Adiciona Font Awesome -->
    <title>Listagem de Receitas</title>
    <style>
        body.light-mode {
            background-color: #ffffff; 
            color: #000000; 
        }

        body.dark-mode {
            background-color: #343a40; 
            color: #ffffff; 
        }

        .card.light-mode {
            background-color: #ffffff; 
            color: #000000; 
        }

        .card.dark-mode {
            background-color: #495057; 
            color: #ffffff; 
        }

        .navbar.light-mode {
            background-color: #f8f9fa; 
        }

        .navbar.dark-mode {
            background-color: #212529; 
            color: #ffffff; 
        }

        a {
            color: inherit; 
        }

        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body class="<?= $bodyClass; ?>">
    <nav class="navbar navbar-expand-lg <?= $_SESSION['theme'] === 'dark' ? 'navbar-dark' : 'navbar-light'; ?> <?= $_SESSION['theme'] === 'dark' ? 'dark-mode' : 'light-mode'; ?>">
        <a class="navbar-brand" href="index.php">Receitas</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="filtrar.php">Filtrar</a></li>
                <?php if (!isset($_SESSION['usuario'])): ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
            <a id="theme-toggle" class="nav-link" href="#">
                <i class="fas <?= $_SESSION['theme'] === 'dark' ? 'fa-sun' : 'fa-moon'; ?>"></i>
            </a>
        </div>
    </nav>
    <div class="container mt-4"></div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const icon = themeToggle.querySelector('i');

        themeToggle.addEventListener('click', (event) => {
            event.preventDefault(); 

            document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode');

            const newTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            
            icon.classList.toggle('fa-sun');
            icon.classList.toggle('fa-moon');

            fetch(`set_theme.php?theme=${newTheme}`);
        });
    </script>
</body>
</html>