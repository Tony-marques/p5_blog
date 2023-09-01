```mermaid

sequenceDiagram
  autonumber
  actor Utilisateur
  Note over Utilisateur,system: ref: Authentification
  actor Administrateur


  loop pour chaque article
    alt création commentaire
      Utilisateur ->>+ system: ajout commentaire
      Utilisateur ->> system: soumettre commentaire
      system ->>- Utilisateur: Confirmation de soumission du commentaire
      system ->> Administrateur: notification commentaire à soummettre
      alt validation commentaire
        Administrateur ->> system: validation du commentaire
        system ->> Utilisateur: rend le commentaire visible
      else suppression commentaire
          Administrateur ->> system: suppression du commentaire
          
      end
    else erreur
      system ->> Utilisateur : erreur, commentaire non soumis
    end
  end




# Rajouter intermédiaire (front, back)



```
