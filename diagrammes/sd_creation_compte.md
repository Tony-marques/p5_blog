```mermaid

sequenceDiagram
  autonumber
  actor Utilisateur


    alt création du compte
      Utilisateur ->>+ system: ajout prénom
      Utilisateur ->> system: ajout nom
      Utilisateur ->> system: ajout adresse email
      Utilisateur ->> system: ajout mot de passe
      Utilisateur ->> system: clique sur créer
      system ->>- Utilisateur: Confirmation de la création du compte
    else erreur
      system ->> Utilisateur : erreur, compte non créé
    end




# Rajouter intermédiaire (front, back)



```
