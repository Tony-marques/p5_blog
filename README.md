# Projet 5 OpenClassrooms - Blog

### Installation du projet 
1. Cloner le repository.
2. Importer le fichier dump SQL dans votre base de donnée:
   - p5_blog.sql se situe dans le dossier app/.
3. Modifier le fichier .env.dev avec les informations de votre base de donnée.
4. Démarrer le projet en local en pointant bien sur le dossier public/
5. Accès administrateur:
    - Identifiant: admin@gmail.com
    - Mot de passe: Admin75@

### Contexte

Ça y est, vous avez sauté le pas ! Le monde du développement web avec PHP est à portée de main et vous avez besoin de visibilité pour pouvoir convaincre vos futurs employeurs/clients en un seul regard. Vous êtes développeur PHP, il est donc temps de montrer vos talents au travers d’un blog à vos couleurs.

### Description du besoin

Le projet est donc de développer votre blog professionnel. Ce site web se décompose en deux grands groupes de pages :

-   les pages utiles à tous les visiteurs ;
-   les pages permettant d’administrer votre blog.

Voici la liste des pages qui devront être accessibles depuis votre site web :

-   la page d'accueil ;
-   la page listant l’ensemble des blog posts ;
-   la page affichant un blog post ;
-   la page permettant d’ajouter un blog post ;
-   la page permettant de modifier un blog post ;
-   les pages permettant de modifier/supprimer un blog post ;
-   les pages de connexion/enregistrement des utilisateurs.

Vous développerez une partie administration qui devra être accessible uniquement aux utilisateurs inscrits et validés.

Les pages d’administration seront donc accessibles sur conditions et vous veillerez à la sécurité de la partie administration.

Commençons par les pages utiles à tous les internautes.

Sur la page d’accueil, il faudra présenter les informations suivantes :

-   votre nom et votre prénom ;
-   une photo et/ou un logo ;
-   une phrase d’accroche qui vous ressemble (exemple : “Martin Durand, le développeur qu’il vous faut !”) ;
-   un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
-   un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :

-   nom/prénom,
-   e-mail de contact,
-   message,

-   un lien vers votre CV au format PDF ;
-   et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).

Sur la page listant tous les blogs posts (du plus récent au plus ancien), il faut afficher les informations suivantes pour chaque blog post :

-   le titre ;
-   la date de dernière modification ;
-   le chapô ;
-   et un lien vers le blog post.

Sur la page présentant le détail d’un blog post, il faut afficher les informations suivantes :

-   le titre ;
-   le chapô ;
-   le contenu ;
-   l’auteur ;
-   la date de dernière mise à jour ;
-   le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
-   les listes des commentaires validés et publiés.

Sur la page permettant de modifier un blog post, l’utilisateur a la possibilité de modifier les champs titre, chapô, auteur et contenu.

Dans le footer menu, il doit figurer un lien pour accéder à l’administration du blog.

### Contraintes

Cette fois-ci, nous n’utiliserons pas WordPress. Tout sera développé par vos soins. Les seules lignes de code qui pourront provenir d’ailleurs seront celles du thème Bootstrap, que vous prendrez grand soin de choisir. La présentation, ça compte ! Il est également autorisé d’utiliser une ou plusieurs librairies externes à condition qu’elles soient intégrées grâce à  [Composer](https://getcomposer.org/).

Attention, votre blog doit être navigable aisément sur un mobile (téléphone mobile, phablette, tablette…). C’est indispensable ! C’est indispensable ![:D](data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAMAAAEyifZoAAAAYFBMVEX/wWn/+an/6pj/tl3/3Yn/x3D/7p3/2YT/tFr/1X//0Xz/5JH/znf/9KP/+6z/xG3/7Jr/vWX/9qX/umH/uF//4Y3/y3T//7D//a7Xl0v/sliodjrmolD///8AAAD///8Zo1IxAAAAIHRSTlP/////////////////////////////////////////AFxcG+0AAADcSURBVBhXXU9HbgRBEGLybF7H7krw/1/6MFpLdp0QIKAgCmwOuSChL+AJeu8boawCJEpgHyGM7QJiqUpBvlOQOK5fJ0rQs4dZLC5wHjMz3QnxI6vyjYIkkZIESSQPFOu4hQRNvd3nswkc2PrMTyLfWxtOj92Ql8zMdAPPVVXlhOyjqtwEKdwR/5IlkeHucdQe6nQb7sNtnLerHT7GrTfSupHXxxQUGM+hR2utr9s1lsmDYF7Wobd+X7dvYHI3gnGes16XvgchBh75S73F8Tpt98zM/Fzszz4ze+37AYEhIfY+Uk6xAAAAAElFTkSuQmCC ":D")

Nous vous conseillons vivement d’utiliser un moteur de templating tel que Twig, mais ce n’est pas obligatoire.

Sur la partie administration, vous veillerez à ce que seules les personnes ayant le droit “administrateur” aient l’accès ; les autres utilisateurs pourront uniquement commenter les articles (avec validation avant publication).

**Important :**  Vous vous assurerez qu’il n’y a pas de failles de sécurité (XSS, CSRF, SQL Injection, session hijacking, upload possible de script PHP…).

Votre projet doit être poussé et disponible sur GitHub. Je vous conseille de travailler avec des pull requests. Dans la mesure où la majorité des communications concernant les projets sur GitHub se font en anglais, il faut que vos commits soient en anglais.

Vous devrez créer l’ensemble des issues (tickets) correspondant aux tâches que vous aurez à effectuer pour mener à bien le projet.

Veillez à bien valider vos tickets pour vous assurer que ceux-ci couvrent bien toutes les demandes du projet. Donnez une estimation indicative en temps ou en points d’effort (si la méthodologie agile vous est familière) et tentez de tenir cette estimation.

L’écriture de ces tickets vous permettra de vous accorder sur un vocabulaire commun. Il est fortement apprécié qu’ils soient écrits en anglais !

#### Nota Bene

Votre projet devra être suivi via  [SymfonyInsight](https://insight.symfony.com/), ou  [Codacy](https://www.codacy.com/)  pour la qualité du code. Vous veillerez à obtenir une médaille d'argent au minimum (pour SymfonyInsight). En complément, le respect des PSR est recommandé afin de proposer un code compréhensible et facilement évolutif.

Si vous n’arrivez pas à vous décider sur le thème Bootstrap, en voici un qui pourrait vous convenir  [http://bit.ly/2emOTxY](http://bit.ly/2emOTxY)  (source : startbootstrap.com).

Dans le cas où une fonctionnalité vous semblerait mal expliquée ou manquante, parlez-en avec votre mentor afin de prendre une décision ensemble concernant les choix que vous souhaiteriez faire. Ce qui doit prévaloir doit être les délais.