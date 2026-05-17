<?php
$host = 'localhost';
$dbname = 'tasksync';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Global UI Function for Realistic Pushpin
function getPinSvg($color = 'red') {
    $colors = [
        'red' => ['#ef4444', '#b91c1c', '#fca5a5'],
        'blue' => ['#3b82f6', '#1d4ed8', '#93c5fd'],
        'green' => ['#22c55e', '#15803d', '#86efac'],
        'yellow' => ['#eab308', '#a16207', '#fde047'],
        'purple' => ['#a855f7', '#7e22ce', '#d8b4fe']
    ];
    $c = $colors[$color] ?? $colors['red'];
    return '
    <svg class="pushpin" viewBox="0 0 100 100" width="30" height="30">
        <path d="M50,60 L50,98" stroke="#cbd5e1" stroke-width="4" stroke-linecap="round" filter="drop-shadow(2px 2px 1px rgba(0,0,0,0.3))" />
        <path d="M35,60 L65,60 L58,35 L42,35 Z" fill="'.$c[1].'"/>
        <circle cx="50" cy="28" r="18" fill="'.$c[0].'"/>
        <circle cx="43" cy="20" r="6" fill="'.$c[2].'"/>
    </svg>';
}
?>
