<?php
require_once 'config.php';

// Fetch users for the edit modal
$stmtUsers = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome ASC");
$usuarios = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// Fetch tasks with user names
$query = "
    SELECT t.*, u.nome as usuario_nome 
    FROM tarefas t 
    JOIN usuarios u ON t.usuario_id = u.id 
    ORDER BY t.data_cadastro DESC
";
$stmt = $pdo->query($query);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$colunas = [
    'a fazer' => [],
    'fazendo' => [],
    'concluido' => []
];

foreach ($tarefas as $tarefa) {
    $colunas[$tarefa['status']][] = $tarefa;
}

// Function to determine next/prev status
function getNextStatus($current) {
    if ($current === 'a fazer') return 'fazendo';
    if ($current === 'fazendo') return 'concluido';
    return '';
}
function getPrevStatus($current) {
    if ($current === 'concluido') return 'fazendo';
    if ($current === 'fazendo') return 'a fazer';
    return '';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Gerenciamento Kanban</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Task<span>Sync</span></div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Kanban Board</a></li>
            <li><a href="cadastrar_usuario.php">Cadastrar Usuário</a></li>
            <li><a href="cadastrar_tarefa.php">Nova Tarefa</a></li>
        </ul>
    </nav>

    <div class="container">
        <header class="page-header">
            <h1>Quadro Kanban de Tarefas</h1>
            <p>Gerencie suas tarefas de forma visual e intuitiva.</p>
        </header>

        <div class="kanban-board">
            <!-- Coluna: A Fazer (Rosa) -->
            <div class="kanban-col" id="col-todo">
                <div class="col-header">
                    <h2>A Fazer</h2>
                    <span class="count"><?= count($colunas['a fazer']) ?></span>
                </div>
                <div class="cards-container">
                    <?php foreach($colunas['a fazer'] as $t): ?>
                        <?= renderCard($t) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Coluna: Fazendo (Amarelo) -->
            <div class="kanban-col" id="col-doing">
                <div class="col-header">
                    <h2>Fazendo</h2>
                    <span class="count"><?= count($colunas['fazendo']) ?></span>
                </div>
                <div class="cards-container">
                    <?php foreach($colunas['fazendo'] as $t): ?>
                        <?= renderCard($t) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Coluna: Concluído (Verde) -->
            <div class="kanban-col" id="col-done">
                <div class="col-header">
                    <h2>Concluído</h2>
                    <span class="count"><?= count($colunas['concluido']) ?></span>
                </div>
                <div class="cards-container">
                    <?php foreach($colunas['concluido'] as $t): ?>
                        <?= renderCard($t) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Editar Tarefa</h2>
            <form action="acoes.php?acao=editar_tarefa" method="POST">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label>Responsável</label>
                    <select name="usuario_id" id="edit_usuario_id" required>
                        <?php foreach($usuarios as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" id="edit_descricao" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Setor</label>
                    <input type="text" name="setor" id="edit_setor" required>
                </div>
                
                <div class="form-group">
                    <label>Prioridade</label>
                    <select name="prioridade" id="edit_prioridade" required>
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, usuario_id, descricao, setor, prioridade) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_usuario_id').value = usuario_id;
            document.getElementById('edit_descricao').value = descricao;
            document.getElementById('edit_setor').value = setor;
            document.getElementById('edit_prioridade').value = prioridade;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            let modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
function renderCard($t) {
    $prioridadeClass = 'badge-' . $t['prioridade'];
    $prev = getPrevStatus($t['status']);
    $next = getNextStatus($t['status']);
    
    // Format date
    $date = new DateTime($t['data_cadastro']);
    $formattedDate = $date->format('d/m/Y');

    // Encode for JS
    $jsDesc = htmlspecialchars($t['descricao'], ENT_QUOTES);
    $jsSetor = htmlspecialchars($t['setor'], ENT_QUOTES);

    // Generate a random rotation between -3 and 3 degrees
    $randomRot = rand(-30, 30) / 10; // e.g. -2.5 to 3.0

    $html = "<div class='kanban-card' style='--rotate: {$randomRot}deg;'>";
    $html .= "  <div class='card-header'>";
    $html .= "      <span class='badge {$prioridadeClass}'>" . ucfirst($t['prioridade']) . "</span>";
    $html .= "      <span class='date'>{$formattedDate}</span>";
    $html .= "  </div>";
    $html .= "  <p class='desc'>" . htmlspecialchars($t['descricao']) . "</p>";
    $html .= "  <div class='meta'>";
    $html .= "      <div class='meta-item'><strong>👤</strong> " . htmlspecialchars($t['usuario_nome']) . "</div>";
    $html .= "      <div class='meta-item'><strong>🏢</strong> " . htmlspecialchars($t['setor']) . "</div>";
    $html .= "  </div>";
    
    $html .= "  <div class='card-actions'>";
    if ($prev) {
        $html .= "      <a href='acoes.php?acao=alterar_status&id={$t['id']}&status={$prev}' class='btn-icon' title='Mover Anterior'>⬅️</a>";
    }
    
    $html .= "      <div class='center-actions'>";
    $html .= "          <button onclick=\"openEditModal({$t['id']}, {$t['usuario_id']}, '{$jsDesc}', '{$jsSetor}', '{$t['prioridade']}')\" class='btn-edit'>Editar</button>";
    $html .= "          <a href='acoes.php?acao=excluir_tarefa&id={$t['id']}' onclick=\"return confirm('Tem certeza que deseja excluir esta tarefa?')\" class='btn-delete'>Excluir</a>";
    $html .= "      </div>";

    if ($next) {
        $html .= "      <a href='acoes.php?acao=alterar_status&id={$t['id']}&status={$next}' class='btn-icon' title='Mover Próximo'>➡️</a>";
    }
    $html .= "  </div>";
    $html .= "</div>";

    return $html;
}
?>
