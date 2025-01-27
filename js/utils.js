// Utilitaires pour le quiz
export function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

export function formatTime(seconds) {
    return seconds < 10 ? `0${seconds}` : seconds;
}

export function disableAllButtons(buttons) {
    Array.from(buttons).forEach(button => {
        button.disabled = true;
    });
}

export function createChoiceButton(choice, index, handleAnswer) {
    const button = document.createElement('button');
    button.className = 'choice-btn';
    button.textContent = choice;
    button.addEventListener('click', () => handleAnswer(index));
    return button;
}