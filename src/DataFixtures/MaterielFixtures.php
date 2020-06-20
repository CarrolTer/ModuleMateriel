<?php

namespace App\DataFixtures;

use App\Entity\Materiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MaterielFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            //Incrémente jusqu'à 20 fixtures dans la table Matériel
        for ($i = 0; $i < 20; $i++) {
            $materiel = new Materiel();
            $materiel->setNom('product '.$i);
            $materiel->setPrix(mt_rand(10, 100));
            $materiel->setQuantite(mt_rand(10, 100));
            $materiel->setCreatedAt(new \DateTime( 'now' ));
            $manager->persist($materiel);
        }
        $manager->flush();
    }
}