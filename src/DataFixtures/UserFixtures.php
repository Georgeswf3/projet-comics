<?php

namespace App\DataFixtures;

use App\Entity\FanArt;
use App\Entity\User;
use App\Entity\Article;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = new Factory();
        $this->faker = $this->faker->create();
    }

    public function load(ObjectManager $manager)
    {
        $slugger = new AsciiSlugger();

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

        for ($i = 0; $i < 25; $i++){
            $article = new Article();
            $article->setArticleTitle($this->faker->realText(30, 2));
            $article->setArticleText($this->faker->realText(200, 2));
            $article->setUserId($user);
            $article->setIsConfirmed(true);
            $article->setSlug(strtolower($slugger->slug($article->getArticleTitle())));
            $article->setArticleDate($this->faker->dateTimeThisDecade);

            $manager->persist($article);
            $manager->flush();

        }

        for ($i = 0; $i < 25; $i++){
            $fanArt = new FanArt();
            $fanArt->setFanArtTitle($this->faker->realText(30, 2));
            $fanArt->setFanArtHook($this->faker->text(50));
            $fanArt->setFanArtSketch($this->faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker'));
            $fanArt->setUserId($user);
            $fanArt->setIsConfirmed(true);
            $fanArt->setSlug(strtolower($slugger->slug($fanArt->getFanArtTitle())));


            $manager->persist($fanArt);
            $manager->flush();

        }
    }
}
