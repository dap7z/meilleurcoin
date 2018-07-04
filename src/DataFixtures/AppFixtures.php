<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $ad1 = new Ad();
        $ad1->setTitle("titre1");
        $ad1->setDescription("desciption1");
        $ad1->setCity("nantes");
        $ad1->setZip("44000");
        $ad1->setPrice(100.001);
        $ad1->setDateCreated(new DateTime());
        $manager->persist($ad1);

        $ad2 = new Ad();
        $ad2->setTitle("titre2");
        $ad2->setDescription("desciption2");
        $ad2->setCity("nantes");
        $ad2->setZip("44000");
        $ad2->setPrice(200.002);
        $ad2->setDateCreated(new DateTime());
        $manager->persist($ad2);

        $manager->flush();
    }
}
