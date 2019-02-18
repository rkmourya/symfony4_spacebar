<?php

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;
use App\Entity\Article;

class CommentFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            );
            $comment->setAuthorName($this->faker->name);
            $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $comment->setArticle($this->getReference(Article::class.'_0'));
        });

        $manager->flush();
    }
}
