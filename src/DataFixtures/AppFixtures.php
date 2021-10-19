<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();
        $users = [];
        for ($i=0; $i < 20; $i++) { 
            $user = new User();
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];
        for ($i=0; $i < 10; $i++) { 
            $category = new Category();
            $category->setTitle($faker->text(30));
            $category->setDescription($faker->text(150));
            $category->setImageCategory($faker->imageUrl(640, 480));
            $manager->persist($category);
            $categories[] = $category;
        }

        
        for ($i=0; $i < 50; $i++) { 
            $article = new Article();
            $article->setTitle($faker->text(30));
            $article->setContent($faker->text(250));
            $article->setImageArticle($faker->imageUrl());
            $article->setCreatedAt(new \DateTime());
            $article->addCategoryId($categories[$faker->numberBetween(1, 9)]);
            $article->setAuthor($users[$faker->numberBetween(1, 19)]);
            $manager->persist($article);
            
        }

        $manager->flush();
    }
}
