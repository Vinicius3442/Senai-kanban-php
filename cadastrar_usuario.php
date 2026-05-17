<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastrar Usuário</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <nav class="navbar">
        <div class="logo paper-logo">
            <?= getPinSvg('blue') ?>
            Task<span>Sync</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Kanban Board</a></li>
            <li><a href="cadastrar_usuario.php" class="active">Cadastrar Usuário</a></li>
            <li><a href="cadastrar_tarefa.php">Nova Tarefa</a></li>
        </ul>
    </nav>

    <div class="container form-container">
        <h2>Cadastrar Novo Usuário</h2>
        
        <?php if(isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Usuário cadastrado com sucesso!</div>
        <?php endif; ?>
        
        <?php if(isset($_GET['erro'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['erro']) ?></div>
        <?php endif; ?>

        <form action="acoes.php?acao=cadastrar_usuario" method="POST" class="form-card">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required placeholder="Digite o nome do usuário">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
