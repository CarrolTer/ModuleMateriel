# ModuleMateriel

Exercice pour Be-Ware Informatique. Réalisation en Symfony 4 / Twig et du plugin JQUERY Datatable.

## Installation

Dans la racine du projet, utiliser la commande de [Composer](https://getcomposer.org/).

```bash
composer install
```

## Data Fixtures

Génerer les Data fixtures dans la base de données créer avec Doctrine afin de visualiser le tableau. 

```composer
Doctrine

php bin/console doctrine:database:create # configurer le .env avant cette commande
php bin/console doctrine:migrations:migrate
```

```composer
Data Fixtures

php bin/console doctrine:fixtures:load
# ou
php bin/console d:f:l

```

## A savoir

Utilisation de [mailtrap](https://mailtrap.io) afin d'informer l'admin qu'un produit a sa quantité à 0.
