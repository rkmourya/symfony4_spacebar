<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'tags', function ($i) {
            $tag = new Tag();
            $tag->setName($this->faker->realText(20));
            return $tag;
        });

        $manager->flush();
    }
}
