<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Dynamique</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="quiz-container">
        <div id="progress-container">
            <div id="timer-container">
                <span id="timer">30</span> secondes restantes
            </div>
            <div id="questions-remaining">
                Question <span id="current-question">1</span>/10
            </div>
        </div>
        
        <div id="question-container">
            <h2 id="question-text"></h2>
            <div id="choices-container"></div>
        </div>

        <button id="next-btn" style="display: none;">Question suivante</button>
        
        <div id="score-container">
            Score: <span id="score">0</span>
        </div>
    </div>

    <script src="js/utils.js" type="module"></script>
    <script src="js/quiz-state.js" type="module"></script>
    <script src="js/timer.js" type="module"></script>
    <script src="js/script.js" type="module"></script>
</body>
</html>