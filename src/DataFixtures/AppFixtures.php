<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Place;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    protected $faker;
    /**
     * @var ObjectManager
     */
    protected $manager;

    private $cities = [
        1 => 'SPB',
        2 => 'MSK',
    ];

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        foreach ($this->cities as $id => $name) {
            $city = new City();
            $city->setName($name)->setSlug($this->faker->city);
            $manager->persist($city);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference(City::class . '_' . $id, $city);
        }

        $this->addPlaces($manager);

        $manager->flush();
    }

    private function addPlaces(EntityManager $em)
    {
        $randomKeys = array_keys($this->cities);
        for ($i = 1; $i <= 10; $i++) {
            $place = new Place();
            $place->setName($this->faker->company)
                ->setSlug($this->faker->slug)
                ->setActive($this->faker->boolean)
                ->setClosed($this->faker->boolean)
                ->setCity($this->getReference(City::class . '_' . $this->faker->randomElement($randomKeys)))
                ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $em->persist($place);
        }
    }
}
