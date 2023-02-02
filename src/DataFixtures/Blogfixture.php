<?php

namespace App\DataFixtures;

use Faker\Factory;
use DatetimeImmutable;
use App\Entity\Articles;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Blogfixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //pour utiliser FAKER

        $faker =\Faker\Factory::create('fr_FR');

        //Fabriquer plusieurs articles
        for($i=0;$i<10;$i++){
            // Génération d'un article
            $art = new Articles();
            $art->setTitle($faker->sentence());
            $art->setContent($faker->paragraph(5,true));
            $art->setCreatedAt(new DatetimeImmutable());
            $art->setPicture("https://loremflickr.com/320/240/loup");

            // persisté cet article
            $manager->persist($art);
        }
        // Ecriture dans la BDD
        $manager->flush();
    }
}
