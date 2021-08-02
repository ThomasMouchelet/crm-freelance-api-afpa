<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [CustomerFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        for ($i = 0; $i < 50; $i++) {
            $invoice = new Invoice();
            $invoice
                ->setAmount($faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL))
                ->setSendingAt($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null))
                ->setStatut($faker->randomElement(['SENT', 'PAID', 'CANCEL']));

            $cutomer = $this->getReference("customer_" . rand(0, 9));
            $invoice->setCustomer($cutomer);

            $manager->persist($invoice);
        }

        $manager->flush();
    }
}
