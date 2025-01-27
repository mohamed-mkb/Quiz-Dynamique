<?php
require_once '../php/config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    $question = $_POST['question'] ?? '';
    $choices = $_POST['choices'] ?? [];
    $correct = isset($_POST['correct']) ? (int)$_POST['correct'] : -1;
    
    if (empty($question) || count($choices) !== 4 || $correct < 0 || $correct > 3) {
        throw new Exception('Invalid input data');
    }
    
    // Phase 1: Ajout dans le fichier JSON
    /*
    $jsonFile = __DIR__ . '/../data/questions.json';
    $questions = json_decode(file_get_contents($jsonFile), true);
    
    $newQuestion = [
        'question' => $question,
        'choices' => $choices,
        'correct' => $correct
    ];
    
    $questions[] = $newQuestion;
    
    if (file_put_contents($jsonFile, json_encode($questions, JSON_PRETTY_PRINT)) !== false) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to save question');
    }
    */

    // Phase 2: Ajout dans la base de données
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $stmt = $pdo->prepare("INSERT INTO questions (question, choices, correct_answer) VALUES (?, ?, ?)");
    if ($stmt->execute([$question, json_encode($choices), $correct])) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to save question');
    }
    
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>