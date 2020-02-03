<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;


class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $user = new User();
        $user2 = new User();

        $country = new Country();
        $country2 = new Country();
        $country->setName('France')
            ->setSmallPng($faker->imageUrl('400', '300'))
            ->setMap('../img/map_' . $country->getName() . '.png');
        for ($c = 1; $c <= 40; $c++) {
            $city = new City();
            $city->setName($faker->city)
                ->setCountry($country);
            $manager->persist($city);
        }
        $manager->persist($country);

        $country2->setName('Espagne')
            ->setSmallPng($faker->imageUrl('400', '300'))
            ->setMap('../img/map_' . $country2->getName() . '.png');
        for ($c = 1; $c <= 40; $c++) {
            $city = new City();
            $city->setName($faker->city)
                ->setCountry($country2);
            $manager->persist($city);
        }
        $manager->persist($country2);

$hash = $this->encoder->encodePassword($user, '258790');
$user2->setPassword($hash)
->setLastname('Sommesous')
->setEmail('sl0ders@gmail.com')
->setFirstname('Quentin')
->setRoles(['ROLE_USER'])
->setCreatedAt(new \DateTime());
$manager->persist($user2);

$user->setEmail('quentin.sommesous@sfr.fr')
->setFirstname('Quentin')
->setLastname('Sommesous')
->setRoles(['ROLE_ADMIN'])
->setCreatedAt(new \DateTime())
->setPassword($hash);
$manager->persist($user);

$manager->flush();
}
}
