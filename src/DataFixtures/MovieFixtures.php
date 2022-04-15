<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var array<array-key, Genre> $genres*/
        $genres = $manager->getRepository(Genre::class)->findAll();
        /** @var array<array-key, Person> $persons*/
        $persons = $manager->getRepository(Person::class)->findAll();

        foreach ($genres as $genre) {
            for ($i = 1; $i <= 10; $i++) {
                $manager->persist(
                    $movie = (new Movie())
                        ->setTitle(sprintf('Title %d', $i))
                        ->setSynopsis(sprintf('Synopsis %d', $i))
                        ->setDuration(rand(50, 500))
                        ->setProductionYear(rand(2017, 2022))
                        ->setGenre($genre)
                );
                shuffle($persons);

                foreach (array_slice($persons, 0, 3) as $person) {
                    $movie->getActors()->add($person);
                }
                foreach (array_slice($persons, 0, 2) as $person) {
                    $movie->getDirectors()->add($person);
                }

            }

        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [GenreFixtures::class , PersonFixtures::class];
    }
}
