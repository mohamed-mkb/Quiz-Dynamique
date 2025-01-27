<?php
session_start();
require_once '../php/config.php';

// Vérification simple de l'authentification (à améliorer en production)
$isAdmin = true; // À remplacer par une vraie authentification
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Quiz Dynamique</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            padding: 2rem;
        }
        
        .admin-form {
            margin-top: 2rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .admin-btn {
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .admin-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Administration du Quiz</h1>
        
        <?php if ($isAdmin): ?>
            <div class="admin-form">
                <h2>Ajouter une nouvelle question</h2>
                <form action="add_question.php" method="POST">
                    <div class="form-group">
                        <label for="question">Question:</label>
                        <textarea name="question" id="question" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="choice1">Choix 1:</label>
                        <input type="text" name="choices[]" id="choice1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="choice2">Choix 2:</label>
                        <input type="text" name="choices[]" id="choice2" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="choice3">Choix 3:</label>
                        <input type="text" name="choices[]" id="choice3" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="choice4">Choix 4:</label>
                        <input type="text" name="choices[]" id="choice4" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="correct">Réponse correcte (0-3):</label>
                        <input type="number" name="correct" id="correct" min="0" max="3" required>
                    </div>
                    
                    <button type="submit" class="admin-btn">Ajouter la question</button>
                </form>
            </div>
        <?php else: ?>
            <p>Accès non autorisé</p>
        <?php endif; ?>
    </div>
</body>
</html>