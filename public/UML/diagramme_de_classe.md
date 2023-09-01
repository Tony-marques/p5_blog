```mermaid

---
title: Diagramme de classe blog PHP
---

classDiagram
  class Utilisateurs{
    prenom: string
    nom: string
    age: int
    avatar: string
    role: array
    email: string
    password: string
  }

  class Articles{
    titre: string
    contenu: string
    image: string
    auteur: string
  }

  class Commentaires{
    contenu: string
    publié: bool
  }

  Utilisateurs "1"--"1..n" Commentaires
  Articles "1"--"1..n" Commentaires
  Utilisateurs "1"--"1..n" Articles

```
