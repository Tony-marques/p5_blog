```mermaid

sequenceDiagram
  autonumber
  actor Utilisateur
  Note over Utilisateur,system: ref: Authentification
  actor Administrateur


      Utilisateur ->>+ system: Demande d'accès à la page
      Utilisateur ->> system: remplir et soumettre commentaire
    alt création commentaire

      system ->> Administrateur: notification commentaire à soumettre
      alt validation commentaire
        Administrateur ->> system: validation du commentaire
        system ->> Utilisateur: rend le commentaire visible
      else suppression commentaire
          Administrateur ->> system: suppression du commentaire
          
      end
    else erreur
      system ->> Utilisateur : erreur, commentaire non soumis
    end




# Rajouter intermédiaire (front, back)



```
