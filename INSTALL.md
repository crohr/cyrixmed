# INSTALLATION de CyrixMED
* Depuis la version 1.4, l'installation du script est totalement automatisée (pour Windows uniquement) grâce à un installeur qui installe
un serveur (`ZazouMiniWebServer` http://www.xgarreau.org) comprenant PHP et MySQL et qui contient le script en lui-même.
Pour lancer CyrixMED, il vous suffit simplement de double-cliquer sur l'icône de lancement créée sur votre bureau !
* pour ceux qui toutefois passeraient par une installation manuelle, il vous suffit de modifier le fichier config.inc.php avec vos
paramètres de base de données et d'importer les tables qui se trouvent dans le fichier `tablesMySQL.sql`

# UTILISATION
* Lors de votre premier lancement, il vous faudra utiliser des login et mot de passe génériques afin d'accéder au logiciel :
login : docteur
Mot de passe : docteur
et ceci afin de pouvoir accéder à l'interface d'administration (lien en bas de page après identification) afin de pouvoir 
configurer les différents comptes pour les docteurs (entêtes des ordonnances/nom/mot de passe...) et le compte secretaire (facultatif).
* Concernant les ordonnances, pour imprimer les duplicata, vous devez activer l'option de votre navigateur qui
permet d'imprimer les images d'arrière-plan. Pour ce faire, suivez la procédure suivante (avec Internet Explorer) :
ouvrez une fenêtre d'internet explorer et choisissez ensuite le menu "outils">"options internet">"Avancé">"Imprimer les 
couleurs et les images d'arrière-plan". Dans la même idée, vous pouvez également enlever les textes qui se mettent 
automatiquement en bas et haut de page (adresse de la page, date etc...) en vous rendant dans "fichier">"mise en page".

# LISTES
* Dans ce logiciel vous pouvez remplir des listes de médicament/vaccins/correspondants/etc... afin d'avoir à éviter de
retaper à chaque fois des mots que vous utilisez souvent. De plus, un clic sur le bouton "insérer" insére 
directement la ligne ou le mot choisi à l'emplacement le plus probable dans le dossier. Plus besoin de se fatiguer !
D'ailleurs, si vous avez rempli une liste ou que vous disposez de listes facilement importable (fichier excel ou autre) 
et que vous souhaitez la faire partager au plus grand nombre, n'hésitez pas à me l'envoyer afin que je l'ajoute sur le site 
et que chacun puisse ainsi étoffer ses bases de donées !
