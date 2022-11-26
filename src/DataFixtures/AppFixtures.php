<?php

namespace App\DataFixtures;

use App\Entity\Funder;
use App\Entity\Patient;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
/*        for ($i = 0; $i < 20; $i++) {
            $worker = new Worker();
            $worker->setName($faker->name);
            $worker->setLastName($faker->lastName);
            $worker->setEmail($faker->email);
            $worker->setPhone($faker->phoneNumber);

            //pre execution ->
            $manager->persist($worker);
        }*/
/*        for ($i = 0; $i < 20; $i++) {
            $funder = new Funder();
            $funder->setName($faker->name);
            $funder->setEmail($faker->email);
            $funder->setPhone($faker->phoneNumber);
            $funder->setAddress($faker->address);
            $funder->setNbrActivities($faker->randomNumber());
            $funder->setFunderType($faker->randomLetter);

            $manager->persist($funder);
        }

        //execution
        $manager->flush();*/

        for ($i = 0; $i < 20; $i++) {
            $patient = new Patient();
            $patient->setHealthStatus($faker->name);
            $patient->setFundingNeeded($faker->randomNumber());
            $patient->setPatientDetails($faker->randomLetter);

            $manager->persist($patient);
        }
        //execution
        $manager->flush();

    }
}
