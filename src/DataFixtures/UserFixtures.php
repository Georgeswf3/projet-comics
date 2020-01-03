<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // $user -> $user4 -> création utilisateur administrateur
        // $user5 -> test création utilisateur lambda
        $user = new User();
        $user2 = new User();
        $user3 = new User();
        $user4 = new User();
        $user5 = new User();

        $user->setPseudo("Josam")
            ->setFirstName("Georges")
            ->setLastName("Fourre")
            ->setEmail("fourre.geo@gmail.com")
            ->setPassword($this->passwordEncoder->encodePassword($user, 'geogeo14'))
            ->setRoles(['ROLE_ADMIN']);


        $user2->setPseudo("Lau")
            ->setFirstName("Laurence")
            ->setLastName("Vadori")
            ->setEmail("laurence.vadori@gmail.com")
            ->setPassword($this->passwordEncoder->encodePassword($user2,'geogeo14'))
            ->setRoles(['ROLE_ADMIN']);


        $user3->setPseudo("geoffrey")
            ->setFirstName("Geoffrey")
            ->setLastName("Legall")
            ->setEmail("geoffrey.legall@orange.fr")
            ->setPassword($this->passwordEncoder->encodePassword($user3, 'geogeo14'))
            ->setRoles(['ROLE_ADMIN']);


        $user4->setPseudo("steve")
            ->setFirstName("Steve")
            ->setLastName("Lacour")
            ->setEmail("steve.lacour21.03@gmail.com")
            ->setPassword($this->passwordEncoder->encodePassword($user4,'geogeo14'))
            ->setRoles(['ROLE_ADMIN']);

        $user5->setPseudo("dogeman")
            ->setFirstName("Arthur")
            ->setLastName("Jung")
            ->setEmail("arthur.jung@yahoo.com")
            ->setPassword($this->passwordEncoder->encodePassword($user5, 'test1234'))
            ->setRoles(['ROLE_USER']);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);

        //pensez à la fin de la création à loader les fixtures


        $manager->flush();
    }
}
