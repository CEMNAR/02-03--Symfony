<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface

{
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $season = new Season();
            $season->setYear($faker->year);
            $season->setNumber($faker->numberBetween(1,10));
            $season->setDescription($faker->paragraph);
            $manager->persist($season);
            $this->addReference('season_' .$i ,$season);
            $season->setProgram($this->getReference('program_0'));

        }
        $manager->flush();
    }
}