<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\ApiToken;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $i));
            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'engage'));
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            if ($this->faker->boolean) {
                $user->setTwitterUsername($this->faker->userName);
            }
            return $user;
        });

        $this->createMany(3, 'admin_users', function ($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@thespacebar.com', $i));
            $user->setFirstName($this->faker->firstName);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'engage'));
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            if ($this->faker->boolean) {
                $user->setTwitterUsername($this->faker->userName);
            }
            return $user;
        });

        $manager->flush();
    }
}
