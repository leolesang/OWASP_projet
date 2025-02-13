# **OWASP Projet**

Ce projet est une plateforme pédagogique permettant aux étudiants de s'exercer sur des vulnérabilités web courantes, comme l'injection SQL, XSS, etc. Les exercices sont classés par niveau de difficulté le but étant de récupérer des flags pour valider les exercices.

## **🚀 Description**

Chaque exercice simule une vulnérabilité différente de l'OWASP Top 10 et permet aux utilisateurs de tester leurs compétences en exploitation de failles. L'étudiant peut avant de d'exercer apprendre les vulnérabilités sur les pages explications, un qcm est mit à disposition pour chaque type d'exercice. Si l'étudiant est bloqué il peut alors regarder la solution de l'exercice.

## **📦 Installation**

### Prérequis

- [Docker](https://www.docker.com/get-started) - Pour l'exécution des containers
- [Docker Compose](https://docs.docker.com/compose/install/) - Pour la gestion multi-container

### Étapes d'installation

1. Clone le projet :

```bash
git clone --single-branch --branch download https://github.com/leolesang/OWASP_projet.git
cd OWASP_projet
```

2. Construire les containers Docker :

```bash
docker-compose up -d
```

Le projet sera accessible sur `http://localhost:8080/login.php`

## **📖 Usage**

Une fois l'installation terminée, voici comment utiliser le projet.

1. Accède à l'interface web via `http://localhost:8080/login.php`.
2. Création d'un compte pour accéder à l'accueil.
3. Chaque section est un exercice interactif permettant de tester différentes vulnérabilités.
4. Suis les instructions sur chaque page pour résoudre les défis et récupérer les flags.
5. Si tu es bloqué il y a les solutions et des pages explications / qcm pour t'aider.

## **📂 Structure du Projet**

```plaintext
OWASP_projet/
├──  docker-compose.yml # Docker-compose pour le lancement du projet
├──  nginx.conf # Reverse-proxy
├──  owasp.sql # Base de données
└── README.md
```         

## **🛠 Technologies**

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-009639?logo=nginx&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)
![HTML](https://img.shields.io/badge/HTML-E34F26?logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?logo=css3&logoColor=white)

## **📧  Contact**

- **Email** : leovallee02@gmail.com



