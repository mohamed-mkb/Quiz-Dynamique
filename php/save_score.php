<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $score = isset($_POST['score']) ? (int)$_POST['score'] : 0;
    
    // Phase 1: Sauvegarde dans un fichier
    /*
    $scoreFile = __DIR__ . '/../data/scores.txt';
    $date = date('Y-m-d H:i:s');
    $scoreData = "$date - Score: $score\n";
    
    if (file_put_contents($scoreFile, $scoreData, FILE_APPEND) !== false) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to save score');
    }
    */

    // Phase 2: Sauvegarde dans la base de données
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $stmt = $pdo->prepare("INSERT INTO scores (score, created_at) VALUES (?, NOW())");
    if ($stmt->execute([$score])) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to save score');
    }
    
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}