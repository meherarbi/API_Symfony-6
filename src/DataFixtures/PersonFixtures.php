<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $manager->persist(

                (new Person())
                    ->setFirstname(sprintf('Prenom %d', $i))
                    ->setLastname(sprintf('Nom %d', $i))

            );
        }

        $manager->flush();
    }
}
