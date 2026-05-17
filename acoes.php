<?php
require_once 'config.php';

$acao = $_REQUEST['acao'] ?? '';

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
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome) VALUES (:nome)");
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            try {
                $stmt->execute();
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
            $stmt = $pdo->prepare("INSERT INTO tarefas (usuario_id, descricao, setor, prioridade) VALUES (:usuario_id, :descricao, :setor, :prioridade)");
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':setor', $setor, PDO::PARAM_STR);
            $stmt->bindParam(':prioridade', $prioridade, PDO::PARAM_STR);
            $stmt->execute();
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
        $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    header("Location: index.php");
    exit;
}

function alterarStatus($pdo) {
    $id = $_GET['id'] ?? '';
    $status = $_GET['status'] ?? '';
    $valid_status = ['a fazer', 'fazendo', 'concluido'];
    
    if (!empty($id) && in_array($status, $valid_status)) {
        $stmt = $pdo->prepare("UPDATE tarefas SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
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
            $stmt = $pdo->prepare("UPDATE tarefas SET descricao = :descricao, setor = :setor, prioridade = :prioridade, usuario_id = :usuario_id WHERE id = :id");
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':setor', $setor, PDO::PARAM_STR);
            $stmt->bindParam(':prioridade', $prioridade, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        header("Location: index.php");
        exit;
    }
}
?>
