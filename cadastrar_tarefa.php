<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome ASC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastrar Tarefa</title>
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
            <li><a href="cadastrar_usuario.php">Cadastrar Usuário</a></li>
            <li><a href="cadastrar_tarefa.php" class="active">Nova Tarefa</a></li>
        </ul>
    </nav>

    <div class="container form-container">
        <h2>Cadastrar Nova Tarefa</h2>
        
        <?php if(isset($_GET['erro'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['erro']) ?></div>
        <?php endif; ?>

        <form action="acoes.php?acao=cadastrar_tarefa" method="POST" class="form-card">
            <div class="form-group">
                <label for="usuario_id">Usuário Responsável</label>
                <select id="usuario_id" name="usuario_id" required>
                    <option value="">Selecione um usuário...</option>
                    <?php foreach($usuarios as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição da Tarefa</label>
                <textarea id="descricao" name="descricao" rows="4" required placeholder="Descreva a tarefa a ser realizada..."></textarea>
            </div>

            <div class="form-group">
                <label for="setor">Setor da Empresa</label>
                <input type="text" id="setor" name="setor" required placeholder="Ex: TI, Marketing, RH...">
            </div>

            <div class="form-group">
                <label for="prioridade">Prioridade</label>
                <select id="prioridade" name="prioridade" required>
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
        </form>
    </div>
</body>
</html>
