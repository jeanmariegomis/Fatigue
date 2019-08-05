<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Admin extends Fixture
{
    private $encoder;

public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}
public function load(ObjectManager $manager)
{
    $user = new User();
    $user->setUsername('Jean');
    $password = $this->encoder->encodePassword($user, 'pass');
    $user->setPassword($password);
    $user->setNom('Gomis');
    $user->setPrenom('Jean');
    $user->setEmail('gm@gmail.com');
    $user->setTelephone('772957710');
    $user->setNci('1525');
    $user->setStatus('actif');
    $user->setRoles(['super_admin']);
    $manager->persist($user);
    $manager->flush();
}


}
