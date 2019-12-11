<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
        $episode = new Episode();
        $episode->setTitle($faker->words(3, true));
        $episode->setNumber($faker->numberBetween(1, 20));
        $manager->persist($episode);
        $episode->setSeason($this->getReference('season_0'));

        }
        $manager->flush();
        }
}