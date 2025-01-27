# Quiz Dynamique

Un jeu de quiz interactif développé avec PHP, MySQL, HTML, CSS et JavaScript.

## Fonctionnalités

- Questions à choix multiples
- Timer pour chaque question
- Calcul et sauvegarde des scores
- Interface d'administration pour gérer les questions
- Responsive design

## Installation

1. Clonez le dépôt
2. Configurez votre serveur web pour pointer vers le dossier du projet
3. Importez la base de données en utilisant le fichier `db/init_db.sql`
4. Configurez les paramètres de connexion dans `php/config.php`
5. Accédez au quiz via votre navigateur

## Structure du projet

```
/
├── admin/              # Interface d'administration
├── assets/            # Images et ressources statiques
├── css/              # Fichiers CSS
├── data/             # Données JSON (Phase 1)
├── db/               # Scripts SQL
├── js/               # Scripts JavaScript
├── php/             # Scripts PHP
└── index.php        # Page principale
```

## Développement

Le projet est développé en deux phases :

1. Utilisation de fichiers JSON pour le stockage des données
2. Migration vers une base de données MySQL

## Sécurité

- Validation des entrées utilisateur
- Protection contre les injections SQL
- Sessions sécurisées