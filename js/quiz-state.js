// Gestion de l'état du quiz
export default class QuizState {
    constructor() {
        this.currentQuestion = null;
        this.score = 0;
        this.usedQuestions = new Set();
        this.totalQuestions = 10; // Nombre total de questions par quiz
        this.questionsAnswered = 0;
    }

    reset() {
        this.score = 0;
        this.usedQuestions = new Set();
        this.questionsAnswered = 0;
    }

    addUsedQuestion(question) {
        this.usedQuestions.add(question.question);
    }

    isQuestionUsed(question) {
        return this.usedQuestions.has(question.question);
    }

    incrementScore() {
        this.score += 10;
        this.questionsAnswered++;
    }

    incrementQuestionsAnswered() {
        this.questionsAnswered++;
    }

    getCurrentQuestionNumber() {
        return this.questionsAnswered + 1;
    }

    getRemainingQuestions() {
        return this.totalQuestions - this.questionsAnswered;
    }

    isQuizComplete() {
        return this.questionsAnswered >= this.totalQuestions;
    }
}