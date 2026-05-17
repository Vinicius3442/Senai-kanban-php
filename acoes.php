<?php
// acoes.php
require_once 'config.php';

$acao = $_REQUEST['acao'] ?? '';

// Roteamento de ações
switch ($acao) {
    case 'cadastrar_usuario':
        cadastrarUsuario($pdo);
        break;
    case 'cadastrar_tarefa':
        cadastrarTarefa($pdo);
        break;
    case 'excluir_tarefa':
        excluirTarefa($pdo);
        break;
    case 'alterar_status':
        alterarStatus($pdo);
        break;
    case 'editar_tarefa':
        editarTarefa($pdo);
        break;
    default:
        header("Location: index.php");
        exit;
}

function cadastrarUsuario($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'] ?? '';

        if (!empty($nome)) {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome) VALUES (?)");
            try {
                $stmt->execute([$nome]);
                header("Location: cadastrar_usuario.php?sucesso=1");
            } catch (PDOException $e) {
                header("Location: cadastrar_usuario.php?erro=" . urlencode("Erro ao cadastrar: " . $e->getMessage()));
            }
        } else {
            header("Location: cadastrar_usuario.php?erro=Preencha o nome");
        }
        exit;
    }
}

function cadastrarTarefa($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = $_POST['usuario_id'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $setor = $_POST['setor'] ?? '';
        $prioridade = $_POST['prioridade'] ?? '';
        
        if (!empty($usuario_id) && !empty($descricao) && !empty($setor) && !empty($prioridade)) {
            $stmt = $pdo->prepare("INSERT INTO tarefas (usuario_id, descricao, setor, prioridade) VALUES (?, ?, ?, ?)");
            $stmt->execute([$usuario_id, $descricao, $setor, $prioridade]);
            header("Location: index.php");
        } else {
            header("Location: cadastrar_tarefa.php?erro=Preencha todos os campos");
        }
        exit;
    }
}

function excluirTarefa($pdo) {
    $id = $_GET['id'] ?? '';
    if (!empty($id)) {
        $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: index.php");
    exit;
}

function alterarStatus($pdo) {
    $id = $_GET['id'] ?? '';
    $status = $_GET['status'] ?? '';
    $valid_status = ['a fazer', 'fazendo', 'concluido'];
    
    if (!empty($id) && in_array($status, $valid_status)) {
        $stmt = $pdo->prepare("UPDATE tarefas SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    header("Location: index.php");
    exit;
}

function editarTarefa($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $setor = $_POST['setor'] ?? '';
        $prioridade = $_POST['prioridade'] ?? '';
        $usuario_id = $_POST['usuario_id'] ?? '';

        if (!empty($id) && !empty($descricao) && !empty($setor) && !empty($prioridade) && !empty($usuario_id)) {
            $stmt = $pdo->prepare("UPDATE tarefas SET descricao = ?, setor = ?, prioridade = ?, usuario_id = ? WHERE id = ?");
            $stmt->execute([$descricao, $setor, $prioridade, $usuario_id, $id]);
        }
        header("Location: index.php");
        exit;
    }
}
?>
