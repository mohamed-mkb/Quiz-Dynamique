<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    // Phase 1: Utilisation du fichier JSON
    /*
    $jsonFile = __DIR__ . '/../data/questions.json';
    
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);
        $questions = $data['questions'];
        $randomQuestion = $questions[array_rand($questions)];
        
        echo json_encode([
            'success' => true,
            'question' => $randomQuestion
        ]);
    } else {
        throw new Exception('Questions file not found');
    }
    */
    // Phase 2: Utilisation de la base de données
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY RAND() LIMIT 1");
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($question) {
        echo json_encode([
            'success' => true,
            'question' => [
                'question' => $question['question'],
                'choices' => json_decode($question['choices']),
                'correct' => $question['correct_answer']
            ]
        ]);
    } else {
        throw new Exception('No questions found');
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}