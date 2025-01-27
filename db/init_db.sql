-- Création de la base de données
CREATE DATABASE IF NOT EXISTS quiz;
USE quiz;

-- Table des questions
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    choices JSON NOT NULL,
    correct_answer INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des scores
CREATE TABLE IF NOT EXISTS scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion de quelques questions d'exemple
INSERT INTO questions (question, choices, correct_answer) VALUES
('Quelle est la capitale de la France ?', '["Paris", "Londres", "Berlin", "Madrid"]', 0),
('Quel est le plus grand océan du monde ?', '["Océan Atlantique", "Océan Indien", "Océan Pacifique", "Océan Arctique"]', 2),
('Qui a peint la Joconde ?', '["Vincent van Gogh", "Leonardo da Vinci", "Pablo Picasso", "Claude Monet"]', 1);