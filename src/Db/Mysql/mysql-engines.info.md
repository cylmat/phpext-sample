<?php

## InnoDB

- Application nécessitant une fiabilité de l'information avec une gestion des transactions 

Au-delà de l'intégrité référentielle (clé etrangère), InnoDB propose des mécanismes transactionnelles présentant une grande compatibilité aux critères ACID. 
Toutes les données de toutes les tables de toutes les bases sont stockées dans un espace de tables commun. De ce fait, la base devient un peu plus rigide. 

```
DELETE FROM t_group;
SET @idGroup = 123;
SET AUTOCOMMIT = 0;
START TRANSACTION;

INSERT INTO t_group (name) VALUES ('webmaster');
Query OK, 1 row affected (0.00 sec)

INSERT INTO t_user (idgroup, name) VALUES (@idGroup, 'Leonardo');
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`test`.`t_user`, CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`idgroup`) REFERENCES `t_group` (`id`))

ROLLBACK;
```

* Avantages
    Verrouillage de ligne.
    Gestion du COMMIT/ROLLBACK
    Gère les gros volumes de données.
    Gestion des clés étrangères.
    Grande panoplie d'éléments de configuration du moteur.
    Gestion du backup sans bloquer une base en production.
    Couramment disponible chez les hébergeurs en mutualisé.

* Inconvénients
    Lenteur de certaines opérations telles que le SELECT COUNT(*) FROM maTable.
    TRUNCATE n'est que le synonyme de DELETE.
    Les statistiques envoyées ne sont pas forcément précises : ce ne sont que des estimations.


## MyIsam

- Recherche FULL-TEXT (texte intégrale).
- Tables en lecture seule.
- Tables de Log. 

* MyISAM ne prend pas en charge les transactions ni les clés étrangères, et le verrouillage porte sur des tables entières et non sur les rangées individuelles. 
Il est plus performant pour l'extraction d'informations que dans des situations où il existe de nombreuses écritures concurrentes.
MyISAM dispose de l'indexation en plein texte qui permet des recherches précises et performantes sur des colonnes de type texte par des mots-clés, 
ainsi qu'un tri par pertinence. 
  
* Avantages
    Moteur rapide.
    Possibilité d'écrire et lire en même temps sans risque de verrouillage de table.
    Verrouillage de table manuel.
    La mise en cache des clés.
    Gain de place sur le disque.
    Gain de mémoire lors des mises à jour.
    Gestion de la recherche FULL-TEXT.

* Inconvénients
    Pas de gestion des contraintes de clés étrangères
    Pas de gestion des transactions (pas de COMMIT / ROLLBACK possible).


* Full-text sample

```
CREATE TABLE `article` (
    `idArticle` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `Titre` VARCHAR(250) CHARACTER SET latin1 DEFAULT NULL,
    `Article` TEXT CHARACTER SET latin1,
    PRIMARY KEY  (`idArticle`),
    FULLTEXT KEY `Titre` (`Titre`,`Article`)
  ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  ENGINE = MyISAM;

  INSERT INTO Article (Titre, Article) VALUES ('MyISAM', 'Ce moteur est une version évolué de ISAM avec des extensions en plus....');
INSERT INTO Article (Titre, Article) VALUES ('Memory', 'Les tables de type Memory stock les enregistrements dans la mémoire physique...');
INSERT INTO Article (Titre, Article) VALUES ('CSV', 'Ce type de format facilite le transport entre différentes sources ...');

SELECT *, MATCH (Titre, Article) AGAINST ('base de données') AS Score FROM Article ORDER BY score DESC;
```


## Memory (heap)

- Données volatiles
- fort besoin en accès rapide aux données ; données temporaires 

* Use init-file or  LOAD DATA INFILE from persistant data) (max_heap_table_size)
Save: INSERT INTO maTableMemory SELECT * maTableMySIAM (with trigger)

* Avantages
    Enorme gain de rapidité.
    Couramment proposé chez les hébergeurs en mutualisé mais...

* Inconvénients
    Nécessité d'avoir accès au fichier de configuration de MySQL chez les hébergeurs en mutualisé.
    Perte des données en mémoire au redémarrage du serveur (même s'il existe une commande permettant de recharger les données, il faut être sûr qu'elles soient à jour dans le fichier de données.
    Impossibilité de transformer une table Memory en table physique (exemple : Memory vers MyIsam).
    Ne supporte pas les champs de type BLOB/TEXT, les champs AUTO_INCREMENT ainsi que les champs index n'étant pas en NOT NULL.
    Vue son utilisation, nécessite une quantité de mémoire RAM conséquente. Si la table utilise plus de mémoire que la machine en possède, l'OS va "swapper". Ce qui entraînera des performances bien plus mauvaises qu'avec l'utilisation d'une table physique.
    Possède les mêmes inconvénients que les tables MyISAM.


## Archive

- Enregistrement de logs
(Il permet d'enregistrer une grande quantité de données en prenant un minimum de ressources. )
Only SELECT et INSERT. 
Use LOW_PRIORITY 

* Avantages
    Permet l'écriture de logs au format brut
    Ne prend pas beaucoup d'espace, vu son format d'enregistrement
    Grandes performances en écriture
* Inconvénients
    Il est difficile de trouver des inconvénients si ce moteur est utilisé pour ce qu'il est censé faire, c'est-à-dire l'enregistrement de logs.

## Csv

- Exportation et importation de données venant d'autres sources d'informations. 
(Une astuce consisterait à utiliser une table MyISAM pour effectuer les requêtes de lecture et écriture. Puis, lors d'une exportation au format CSV effectuer une copie de la table au format MyISAM vers le format CSV )

* Avantages
    Facilement exportable vers une autre application. Pas besoin d'un langage tiers pour convertir les données au format CSV. L'importation nécessite plus de délicatesse car il faut faire correspondre les données avec les informations présentes dans le fichier de définition de la table *.frm.
    Données directement lisibles pour un humain.

* Inconvénients
    Pertes importantes de performances sur les tables ayant beaucoup d'enregistrements.
    Ne gère pas l'indexation.
    Importation délicate.

## Merge

- Administration de base de données. 
Une table MyISAM très volumineuse peut être coupée en plusieurs tables ou tables annexes. 

``` 
CREATE TABLE LogJanvier2007 ( idlog INT NOT NULL AUTO_INCREMENT PRIMARY_KEY, log VARCHAR(255));
CREATE TABLE LogFevrier2007 ( idlog INT NOT NULL AUTO_INCREMENT PRIMARY_KEY, log VARCHAR(255))
CREATE TABLE Log2007( idlog INT NOT NULL AUTO_INCREMENT PRIMARY_KEY, log VARCHAR(255))
  TYPE = MERGE UNION=(LogJanvier2007, LogFevrier2007) INSERT_METHODE = LAST;
)

    NO : Pour interdire toute création d'enregistrement via la table MERGE
    FIRST : Les enregistrements seront inscrits dans la première table définie dans la liste UNION.
    LAST : Les enregistrements seront inscrits dans la dernière table définie dans la liste UNION.
```

* Avantages
    Vu que les tables sont de type MyISAM, elles héritent des mêmes avantages
    La maintenance des tables annexes est facilitée par leur taille
    La mise en place (facile à faire et à défaire)
    MERGE permet de mettre en place un partitionnement horizontal pour les versions antérieures de MySQL inférieures à la 5.1. A partir de cette dernière version, MySQL prend en charge le partitionnement horizontal quel que soit le moteur de stockage.
    La rapidité d'exécution

* Inconvénients
    L'obligation d'utiliser les tables de type MyISAM et donc les inconvénients de ce moteur
    Les index ne sont pas uniques.
    Le nombre élevé de fichiers sur la machine. Etant donné que le moteur MERGE utilise des tables de type MyISAM, chaque table annexe correspond à un fichier. S'il y a une table annexe par mois, il y aura donc 12 fichiers.
    La recherche par clés. Obligation de parcourir le catalogue de chaque table, ce qui ralentit le processus

## Exemple

- Phase de développement de la structure SQL et de démonstration. 

* Avantages
    Ne met pas en danger l'intégrité des données de la base.
    Dédié aux tests unitaires

* Inconvénients
    Ne gère pas les index (ce qui est normal vu qu'il n'y a pas de stockage de données).
    Les triggers ne fonctionnent pas.


## Blackhole

- Phase de développement
- Optimisation
- Administration de la structure SQL 
- Utilisation du Proxy MySQL
( Le moteur blackhole peut être particulièrement pratique pour répliquer des données sur des serveurs esclaves sans que le serveur master stocke ces données. )

Ce type de table accepte toutes requêtes d'insertion, mais ne renvoie aucun résultat.
``` show engines; show variables like '%blackhole%'; ```

* Avantage
    Ne présente que des avantages pour ce qui a été présenté.

* Inconvénients
    Peu de documentation.
    Faible disponibilité chez les hébergeurs.

## Federate

- Administration de base de données 
Le moteur FEDERATED permet de déporter les données sur un serveur distant. 
Cela oblige cet autre serveur à se trouver à l'extérieur ou dans un réseau local. En aucun cas il ne peut être le "localhost". 

```
CREATE TABLE t_user (
    id      int(20) NOT NULL auto_increment, idgroup int(10) NOT NULL,  name    varchar(32) NOT NULL default '',    
    PRIMARY KEY  (id) KEY idgroup
)
ENGINE=Federated
CONNECTION='mysql://root@serverB:9306/t_user';
```

 * Avantages
    Permet de répartir la charge.
    Pointer sur plusieurs bases de données distantes si elles acceptent les accès distants.
    Supporte les index.

 * Inconvénients
    Ne supporte que les commandes SQL simples (SELECT, DELETE, INSERT, UPDATE). Il n'est pas possible de faire ALTER TABLE, bien qu'il aurait été utile de pointer vers un autre serveur à la volée afin d'émuler un Load Balancing par exemple
    Ne gère pas les transactions.
    Les performances sont liées au réseau et à son débit.
    Le mot de passe apparaît en clair dans la propriété COMMENT.
    Pas de possibilité de savoir si des modifications ont eu lieu sur le serveur distant.
    Faible disponibilité chez les hébergeurs.


## BerkeleyBD (no fully supported), Falcon, Solid DB, (Prime Base XT), AWS S3, NitroDB, BrightHouse, Maria