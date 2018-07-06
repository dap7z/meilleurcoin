<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\City;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //Annonces :
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


        //Villes :
        $rawQuery = 'SELECT * FROM Ville;';
        $statement = $manager->getConnection()->prepare($rawQuery);
        //$statement->bindValue('status', 1);


        $statement->execute();
        while($row = $statement->fetch()){
            $city = new City();
            $city->setCodePostal($row['code_postal']);
            $city->setNom($row['nom']);
            $city->setGeoLat($row['geo_lat']);
            $city->setGeoLon($row['geo_lon']);
            $city->setCodeDepartement($row['code_departement']);
            $manager->persist($city);
        }
        $manager->flush();
    }
}
