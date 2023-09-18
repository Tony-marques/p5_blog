```mermaid

sequenceDiagram
  autonumber
  actor Administrateur

  Note over Administrateur,system: ref: Authentification

    alt création
      Administrateur ->>+ system: ajout titre
      Administrateur ->> system: ajout contenu
      Administrateur ->> system: publication de l'article
      system ->>- Administrateur: Confirmation de publication de l'article
    else erreur
      system ->> Administrateur : erreur, article non publié
    end




# Rajouter intermédiaire (front, back)



```
