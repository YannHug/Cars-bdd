# Cars Bdd

Projet Symfony de restitution des cours sur le CRUD (BREAD)

Pratique de création d'entités avec relation -> cars et brands

Creation de formulaire d'ajout

Pratique de la méthode BREAD à la place du CRUD

Ajout de fixtures avec FakerPhp et la librairie Nelmio/Alice et utilisation de [fake-car](https://github.com/pelmered/fake-car/blob/master/README.md)

Affichage des données avec relation

## Installation

Utilisation de composer pour installation

```bash
composer install
```

## Usage

Deux migrations présentes pour creation des tables

```bash
bin/console d:mi:mi
```

Les données sont crées via des fixtures avec Nelmio/Alice fixtures et FakerPhp
```bash
bin/console d:f:l
```

## License

Projet créé à des fins purement éducatifs.
