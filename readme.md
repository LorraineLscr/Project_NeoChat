<h1 align="center">Bienvenue sur notre projet NeoChat 👋</h1>
<h2 align="center">Lorraine et Enzo</h2>


<h3 align="left">Langages et Frameworks utilisés :</h3>
  <div align="left">
<img src="https://www.logiciel-libre.org/stock/img/product/logo-twig.png" jsaction="load:XAeZkd;" jsname="HiaYvf" class="n3VNCb KAlRDb" alt="Twig - Guide Logiciel-Libre" data-noaft="1" style="width: 40px; height: 50px; margin: 0px;">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" height="40" width="52" alt="javascript logo"  />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" height="40" width="52" alt="php logo"  />
    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" height="40" width="52" alt="css3 logo"  />
  <img src="https://symfony.com/logos/symfony_white_03.png" jsaction="load:XAeZkd;" jsname="HiaYvf" class="n3VNCb KAlRDb" alt="Symfony, High Performance PHP Framework for Web Development" data-noaft="1" style="width: 40px; height: 50px; margin: 0px;">
 <img src="https://www.stackhero.io/assets/src/images/servicesLogos/openGraphVersions/mercure-hub.png?1c18600b" jsaction="load:XAeZkd;" jsname="HiaYvf" class="n3VNCb KAlRDb" alt="Mercure-Hub : Pour commencer" data-noaft="1" style="width="40 height="40">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" height="40" width="52" alt="bootstrap logo"  />
</div>
<br><br><br>

<h2>🔥 Pour récupérer et démarrer le projet suivre ces instructions : </h2>

> Ouvrir un nouveau dossier sur le desktop  <br>
> Ouvrir avec *VsCode* <br>
> Ouvrir le terminal <br>
> Récupérer le projet : `git clone https://github.com/LorraineLscr/Project_NeoChat.git` <br>
> Faire un update : `composer update` <br>
> Modifier si besoin le fichier .env (mot de passe et nom de la base de données) <br>
> Créer la base de données : `php bin/console doctrine:database create` <br>
> Et enfin lancer les migrations : `php bin/console doctrine:migrations:migrate` 

<br>

<h2>🚀 Pour lancer le projet sur le serveur : </h2>

> Ouvrir un second terminal pour lancer le serveur *Symfony* : `symfony server:start` <br>
> Ouvrir un troisième terminal lancer le *Mercure Hub* : <br>
> `$env:SERVER_NAME=':3000'; $env:MERCURE_PUBLISHER_JWT_KEY='!ChangeMe!'; $env:MERCURE_SUBSCRIBER_JWT_KEY='!ChangeMe!';$env:MERCURE_JWT_KEY='!ChangeMe!'; ./mercure.exe run -config Caddyfile.dev` <br>
> Dans un quatrième terminal ouvrir le *Mailer* : `php bin/console messenger:consume async`

<br>

<h2>🚨 Attention :</h2>

📨 Récupérer le __Mailer Symfony__ (Intégrations *Symfony 5+*) sur __Mailtrap__ et le coller dans le fichier .env

> https://mailtrap.io/inboxes/

`###> symfony/mailer ###`<br>
`MAILER_DSN=smtp://**********************@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login` <br>
`###< symfony/mailer ###` <br>

💬 Pour avoir des __channels__ de conversations dans le *NeoChat* pensez à insérer des noms de channels dans la table *channel* de la base de données !

<br>

<h2> <img src="https://www.stackhero.io/assets/src/images/servicesLogos/openGraphVersions/mercure-hub.png?1c18600b" jsaction="load:XAeZkd;" jsname="HiaYvf" class="n3VNCb KAlRDb" alt="Mercure-Hub : Pour commencer" data-noaft="1" style="width="20 height="20"> Mercure : </h2>

Pouvoir __diffuser des données en temps réel des serveurs aux clients__ est une exigence pour de nombreuses applications Web et mobiles modernes.

Créer une UI réagissant en direct aux changements effectués par d'autres utilisateurs (ex. un utilisateur modifie les données actuellement parcourues par plusieurs autres utilisateurs, toutes les UI sont instantanément mises à jour), avertir l'utilisateur lorsqu'une tâche asynchrone est terminée ou __créer des applications de chat__ sont parmi les cas d'utilisation typiques nécessitant des capacités "push".

*Symfony* fournit un composant simple, construit sur le protocole *Mercure* , spécialement conçu pour cette classe de cas d'utilisation.

*Mercure* est un protocole ouvert conçu dès le départ pour publier des mises à jour du serveur aux clients. C'est une alternative moderne et efficace à l'interrogation basée sur la minuterie et à *WebSocket*.

Parce qu'il est construit sur les meilleurs événements envoyés par le serveur (SSE) , *Mercure* est pris en charge par défaut dans les navigateurs modernes (les anciennes versions d'Edge et d'IE nécessitent un polyfill ) et dispose d'implémentations de haut niveau dans de nombreux langages de programmation.

*Mercure* est livré avec un mécanisme d'autorisation, une reconnexion automatique en cas de problèmes de réseau avec récupération des mises à jour perdues, une API de présence, un push "sans connexion" pour les smartphones et une auto-découvertabilité (un client pris en charge peut automatiquement découvrir et s'abonner aux mises à jour d'un ressource grâce à un en-tête HTTP spécifique).

✅ prise en charge du navigateur natif, aucune bibliothèque ni SDK requis (construit sur HTTP et les événements envoyés par le serveur )

✅ compatible avec tous les serveurs existants, même ceux qui ne supportent pas les connexions persistantes (architecture sans serveur, PHP, FastCGI...)

✅ rétablissement de connexion intégré et réconciliation d'état

✅ Mécanisme d'autorisation basé sur JWT (envoi sécurisé d'une mise à jour à certains abonnés sélectionnés)

✅ performant, exploite le multiplexage HTTP/2

✅ conçu avec l'hypermédia à l'esprit , prend également en charge GraphQL

✅ auto-découverte via un lien Web

✅ prise en charge du chiffrement des messages

✅ peut fonctionner avec les anciens navigateurs (IE7+) en utilisant un EventSourcepolyfill

✅ poussée sans connexion dans des environnements contrôlés (par exemple, les navigateurs sur les téléphones mobiles liés à des opérateurs spécifiques)

<br>

<h2> <img src="https://www.stackhero.io/assets/src/images/servicesLogos/openGraphVersions/mercure-hub.png?1c18600b" jsaction="load:XAeZkd;" jsname="HiaYvf" class="n3VNCb KAlRDb" alt="Mercure-Hub : Pour commencer" data-noaft="1" style="width="20 height="20"> Mercure Hub : </h2>

Pour gérer les connexions persistantes, *Mercure* s'appuie sur un Hub : un serveur dédié qui __gère les connexions SSE persistantes avec les clients__. L'application *Symfony* publie les mises à jour sur le hub, qui les diffusera aux clients.

Un hub officiel et open source (AGPL) basé sur le serveur *Web Caddy* peut être téléchargé sous forme de binaire statique à partir de *Mercure.rocks*. Une image Docker, un graphique Helm pour Kubernetes et un hub haute disponibilité géré sont également fournis.

✅ Rapide, écrit en Go

✅ Fonctionne partout : fichiers binaires statiques et images Docker disponibles

✅ Prise en charge automatique de HTTP/2 et HTTPS (à l'aide de Let's Encrypt)

✅ Prise en charge de CORS, mécanisme de protection CSRF

✅ Cloud Native, suit la méthodologie Twelve-Factor App

✅ Open source (AGPL)