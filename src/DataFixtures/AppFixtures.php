<?php

namespace App\DataFixtures;

use App\Entity\Funder;
use App\Entity\Patient;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher){}
    public function load(ObjectManager $manager): void
    {
        //php bin/console doctrine:fixtures:load --append
        $faker = Factory::create();
            for ($i = 0; $i < 2; $i++) {
                $user = new User();
                $user->setEmail($faker->email);
                $user->setPassword($this->hasher->hashPassword($user,'user'));
                $user->setFirstName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setPhone($faker->phoneNumber);
                $user->setRoles(["ROLE_ADMIN"]);
                $manager->persist($user);
            }
            for ($i = 0; $i < 4; $i++) {
                $user = new User();
                $user->setEmail($faker->email);
                $user->setPassword($this->hasher->hashPassword($user,'user'));
                $user->setFirstName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setPhone($faker->phoneNumber);
                $user->setRoles(["ROLE_WORKER"]);
                $manager->persist($user);
            }
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->hasher->hashPassword($user,'user'));
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setRoles(["ROLE_CEO"]);
            $manager->persist($user);
        }
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->hasher->hashPassword($user,'user'));
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setRoles(["ROLE_SG"]);
            $manager->persist($user);
        }
//
////        for ($i = 0; $i < 20; $i++) {
////            $worker = new Worker();
////            $worker->setName($faker->name);
////            $worker->setLastName($faker->lastName);
////            $worker->setEmail($faker->email);
////            $worker->setPhone($faker->phoneNumber);
////
////            //pre execution ->
////            $manager->persist($worker);
////        }
        for ($i = 0; $i < 20; $i++) {
            $funder = new Funder();
            $funder->setName($faker->name);
            $funder->setEmail($faker->email);
            $funder->setPhone($faker->phoneNumber);
            $funder->setAddress($faker->address);
            $funder->setNbrActivities($faker->randomNumber());
            $funder->setFunderType($faker->randomLetter);

            $manager->persist($funder);
        }

        for ($i = 0; $i < 20; $i++) {
            $patient = new Patient();
            $patient->setName($faker->name);
            $patient->setHealthStatus($faker->word);
            $patient->setFundingNeeded($faker->randomNumber());
            $patient->setPatientDetails($faker->randomLetter);

            $manager->persist($patient);
        }

        for ($i = 0; $i < 20; $i++) {
            $projet = new Project();
            $projet->setName($faker->company);
            $projet->setFundingNeeded($faker->randomFloat(2,0,400));
            $projet->setProjectDetails("testing details");
            $manager->persist($projet);
        }
        //execution
        $manager->flush();

    }
}
