```mermaid
sequenceDiagram
    autonumber
    actor Personne 

    Personne->>+system: La personne se rend sur l'application
    system-->>-Personne: Le système affiche l'interface de connexion

    Personne->>system: Renseigne son email, mot de passe, clique sur connexion

    alt Connexion réussie

    system-->>Personne: Donne l'accès à l'application

    else Connexion echouée
      loop Tant que les identifiants sont incorrects
      system-->>Personne: Renvoie un message d'erreur
    end
end

```
