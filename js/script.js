import { shuffleArray, formatTime, disableAllButtons, createChoiceButton } from './utils.js';
import QuizState from './quiz-state.js';
import Timer from './timer.js';

// État global du quiz
const quizState = new QuizState();
const timer = new Timer(
    30,
    (remaining) => {
        timerElement.textContent = formatTime(remaining);
    },
    handleTimeout
);

// Éléments du DOM
const questionText = document.getElementById('question-text');
const choicesContainer = document.getElementById('choices-container');
const nextButton = document.getElementById('next-btn');
const timerElement = document.getElementById('timer');
const scoreElement = document.getElementById('score');
const currentQuestionElement = document.getElementById('current-question');

// Gestionnaire d'événements pour le bouton suivant
nextButton.addEventListener('click', loadNextQuestion);

// Fonction pour charger une nouvelle question
async function loadNextQuestion() {
    if (quizState.isQuizComplete()) {
        endQuiz();
        return;
    }

    timer.reset();
    resetUI();
    updateQuestionCounter();
    
    try {
        const response = await fetch('php/get_question.php');
        const data = await response.json();
        
        if (!data.success || !data.question) {
            throw new Error('Erreur lors du chargement de la question');
        }
        
        // Vérifie si la question a déjà été utilisée
        if (quizState.isQuestionUsed(data.question)) {
            loadNextQuestion(); // Récursion pour obtenir une nouvelle question
            return;
        }
        
        quizState.currentQuestion = data.question;
        quizState.addUsedQuestion(data.question);
        
        if (data.question.choices && Array.isArray(data.question.choices)) {
            displayQuestion(quizState.currentQuestion);
            timer.start();
        } else {
            throw new Error('Format de question invalide');
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        questionText.textContent = 'Une erreur est survenue lors du chargement de la question.';
    }
}

// Fonction pour mettre à jour le compteur de questions
function updateQuestionCounter() {
    currentQuestionElement.textContent = quizState.getCurrentQuestionNumber();
}

// Fonction pour afficher une question
function displayQuestion(question) {
    if (!question || !question.question || !Array.isArray(question.choices)) {
        console.error('Format de question invalide:', question);
        questionText.textContent = 'Erreur: format de question invalide';
        return;
    }

    questionText.textContent = question.question;
    choicesContainer.innerHTML = '';
    
    question.choices.forEach((choice, index) => {
        const button = createChoiceButton(choice, index, handleAnswer);
        choicesContainer.appendChild(button);
    });
}

// Fonction pour gérer la réponse de l'utilisateur
function handleAnswer(choiceIndex) {
    timer.stop();
    const buttons = choicesContainer.getElementsByClassName('choice-btn');
    disableAllButtons(buttons);
    
    // Affiche la bonne réponse et la réponse de l'utilisateur
    buttons[quizState.currentQuestion.correct].classList.add('correct');
    if (choiceIndex !== quizState.currentQuestion.correct) {
        buttons[choiceIndex].classList.add('incorrect');
        quizState.incrementQuestionsAnswered();
    } else {
        quizState.incrementScore();
    }
    
    scoreElement.textContent = quizState.score;
    nextButton.style.display = 'block';
    
    if (quizState.isQuizComplete()) {
        nextButton.textContent = 'Voir le résultat final';
    }
    
    saveScore();
}

// Fonction pour gérer le timeout
function handleTimeout() {
    const buttons = choicesContainer.getElementsByClassName('choice-btn');
    disableAllButtons(buttons);
    buttons[quizState.currentQuestion.correct].classList.add('correct');
    nextButton.style.display = 'block';
    quizState.incrementQuestionsAnswered();
    
    if (quizState.isQuizComplete()) {
        nextButton.textContent = 'Voir le résultat final';
    }
}

// Fonction pour réinitialiser l'interface
function resetUI() {
    nextButton.style.display = 'none';
    nextButton.textContent = 'Question suivante';
    questionText.textContent = 'Chargement...';
    choicesContainer.innerHTML = '';
}

// Fonction pour terminer le quiz
function endQuiz() {
    questionText.textContent = `Quiz terminé ! Votre score final est de ${quizState.score} points sur 100.`;
    choicesContainer.innerHTML = '';
    nextButton.style.display = 'block';
    nextButton.textContent = 'Recommencer le quiz';
    nextButton.onclick = () => {
        quizState.reset();
        loadNextQuestion();
    };
}

// Fonction pour sauvegarder le score
async function saveScore() {
    try {
        const response = await fetch('php/save_score.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `score=${quizState.score}`
        });
        
        const data = await response.json();
        if (!data.success) {
            console.error('Erreur lors de la sauvegarde du score');
        }
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Charge la première question au chargement de la page
loadNextQuestion();