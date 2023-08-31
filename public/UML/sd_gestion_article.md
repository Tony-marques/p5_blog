```mermaid

sequenceDiagram
  autonumber
  actor Administrateur

  Note over Administrateur,system: Authentification

  loop pour chaque article
    alt création
      Administrateur ->>+ system: ajout titre
      Administrateur ->> system: ajout contenu
      Administrateur ->> system: ajout image
      Administrateur ->> system: publication de l'article
      system ->>- Administrateur: Confirmation de publication de l'article
    else erreur
      Administrateur ->> system: Article non publié, erreur
    end
  end




# Rajouter intermédiaire (front, back)



```
