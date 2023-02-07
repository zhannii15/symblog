<?php

namespace App\DataFixtures;

use Faker\Factory;
use DatetimeImmutable;
use App\Entity\Comment;
use App\Entity\Articles;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Blogfixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //pour utiliser FAKER

        $faker =\Faker\Factory::create('fr_FR');
        
        for($c=0;$c<4;$c++){
            $cat = new Categorie();
            $cat->setName($faker->word());
            $manager->persist($cat);
            // entre 1 et 4 par catégorie
            for($i=0;$i<mt_rand(1,4);$i++){
                // Génération d'un article
                $art = new Articles();
                $art->setTitle($faker->sentence());
                $art->setContent($faker->paragraph(5,true));
                $art->setCreatedAt(new DatetimeImmutable());
                $art->setPicture("https://loremflickr.com/320/240/loup");
                $art->setCategory($cat);
                // persisté cet article
                $manager->persist($art);
                for ($k=0;$k<mt_rand(1,6);$k++){
                    $comment= new Comment();
                    $comment->setAuthor($faker->name());
                    $comment->setCreatedAt(new DatetimeImmutable());
                    $comment->setArticle($art);
                    $comment->setContent($faker->paragraph());
                    $manager->persist($comment);

                }
            }
        }
        // Ecriture dans la BDD
        $manager->flush();
    }
}
