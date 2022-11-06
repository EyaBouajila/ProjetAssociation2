<?php

namespace App\DataFixtures;

use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $worker = new Worker();
            $worker->setName($faker->name);
            $worker->setLastName($faker->lastName);
            $worker->setEmail($faker->email);
            $worker->setPhone($faker->phoneNumber);

            //pre execution ->
            $manager->persist($worker);
        }

        //exection
        $manager->flush();
    }
}
