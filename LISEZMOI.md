# GraphicObjectTemplating Theme MetroUI (zf-got-theme-metroui)

Ce thème graphique pour **GraphicObjectTemplating** vous fournit les briques utiles pour construire et gérer votre propre interface utilisateur Metro UI.

## Avant toute installation ##

Vous devez avoir installé les paquets : *celtic34fr/zf-graphic-object-templating* et *celtic34fr/zf-got-twig-extension*, version de développement avec les commandes suivantes :

    composer.phar require celtic34fr/zf-graphic-object-templating @dev 
    composer.phar require celtic34fr/zf-got-twig-extension @dev 

## Installation avec Composer

Après cela, vous pouvez installer le paquet avec :

    composer.phar require celtic34fr/zf-got-theme-metroui @dev
    
Afin de rendre fonctionnel le module installé, vous devez configurer votre application comme suit :

En premier, dans le fichier **config/modules.config.php**, ajoutez la ligne suivante :

    ...
    'MetroUI_GET',
    ...

Dans le dossier *public* de votre projet, en premier créez un répertoire nommé *gotextensions*.
Dans ce répertoire, créez un répertoire lié au répertoire **vendor/celtic34fr/zf-got-theme-metroui/public** que vous nommerez **metroui** avec la commande suivante sous Linux :

    cd public
    mkdir gotextension
    cd gotextension
    ln -s ../../vendor/celtic34fr/zf-got-theme-metroui/public metroui

Dans un environnement **Windows** utiliser seulement **cmd.exe** pour lancer la commande à exécuter en tant qu'administrateur, dans le répertoire public du projet :

    cd public
    mkdir gotextension
    cd gotextension
    mklink /D metroui ..\..\vendor\celtic34fr\zf-got-theme-metroui\public


Maintenant, tout est en ordre pour fonctionner. Vous pouvez commencer à développer votre propre extension en ajoutant un nouveau module à votre projet, votre application.
