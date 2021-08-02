<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer();
            $customer
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setCompanyName($faker->company())
                ->setAddress($faker->address());

            $manager->persist($customer);
            $this->addReference('customer_' . $i, $customer);
        }

        $manager->flush();
    }
}
