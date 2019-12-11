<?php


namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
        $actor = new Actor();
        $actor->setName($faker->name);
        $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $actor->addProgram($this->getReference('program_0'));
        }
        $manager->flush();
    }

    const ACTORS = [
        'Johny Depp',
        '50cent',
        'Margot Robbie',
        'Dwayne Johnson',
        'Will Smith',
        'Al Pacino',
        'Robert De Niro',
        'Leoardo Di Caprio',
    ];

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}