<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Third;
use App\Entity\Picker;
use App\Entity\Deliver;
use App\Entity\Service;
use App\Entity\PostalCode;
use App\Entity\OwnerHistoric;
use App\Entity\ThirdCategory;
use App\Entity\ServiceCategory;
use App\Repository\PostalCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Création d'un Rôle(Role)
        /*
        $role = new Role();
        $role->setTitle('ROLE_ADMIN');
        $manager->persist($role);
        //

        // Création de deux Administrateurs(User)
        //
        $users = [];
        $user = new User();
        $createdAt = new \DateTime();
        $user->setFirstName('Patrick')
             ->setLastName('Dambreville')
             ->setEmail('patrick@dambreville.online')
             ->setHash($this->encoder->encodePassword($user, 'password'))
             ->setPicture('https://avatars.io/twitter/PaDaHi67')
             ->setPhone($faker->mobileNumber())
             ->addUserRole($role)
             ->setCreatedAt($createdAt);
        
        $manager->persist($user);
        $users[] = $user;
        
        $user = new User();
        $createdAt = new \DateTime();
        $user->setFirstName('Ghyslain')
             ->setLastName('Lauvaux')
             ->setEmail('ghyslain.lauvaux@feezby.com')
             ->setHash($this->encoder->encodePassword($user, 'Ux31357lvx'))
             ->setPicture('https://avatars.io/facebook/feezby')
             ->setPhone($faker->mobileNumber())
             ->addUserRole($role)
             ->setCreatedAt($createdAt);
        
        $manager->persist($user);        
        //

        // Création d'Utilisateurs (User)
        //
         
        //$users = [];
        $genders = ['male', 'female'];
         
        for ($i=1; $i<=15; $i++) {
            $user = new User();
             
            $gender = $faker->randomElement($genders);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';
            $picture = $picture . ($gender == 'male' ? 'men/' : 'women/') . $pictureId;
            
            $hash = $this->encoder->encodePassword($user, 'password');
            
            $user->setFirstName($faker->firstName($gender))
                 ->setLastName($faker->lastName)
                 ->setEmail($faker->email)
                 ->setPicture($picture)
                 ->setHash($hash)
                 ->setPhone($faker->mobileNumber);
            
            $manager->persist($user);
            $users[] = $user;
        }
        */
        
        // Création de Tiers
        
        /*
        $thirds = [];
         
        for ($i=1; $i<=50 ; $i++) {
             
            $third = new Third();
             
            // Gestion de la relation Third<->PostalCode
            // Sélection aléatoire de l'Id d'une commune du 35
            $postalCodeId = mt_rand(19616, 19986);
            $postalCodeRepo = $manager->getRepository(PostalCode::class);
            $postalCode = $postalCodeRepo->findOneById($postalCodeId);
            
            $third->setName($faker->company())
            ->setAddress($faker->streetAddress())
                ->setPostalCode($postalCode);
            
            $manager->persist($third);
            $thirds[] = $third;
            
        }
        /*
        
        /*
        Tests d'utilisation de DQL

        $query = $manager->createQuery("select p from App\Entity\PostalCode p where p.id >= 19616 and p.id <= 19617");
        $postalCodes = $query->getResult();
        dump($postalCodes);
        die();

        */

        /*
        // Création de Catégories de Services(serviceCategory)
        //
        $serviceCategories = [];

        $serviceCategory = new ServiceCategory();
        $serviceCategory->setTitle('Course')
                        ->setDescription('Enlèvement/Expédition réalisée dans la journée');
        $manager->persist($serviceCategory);
        $serviceCategories[] = $serviceCategory;

        $serviceCategory = new ServiceCategory();
        $serviceCategory->setTitle('Messagerie')
                        ->setDescription('Enlèvement à J, Dépôt et Livraison réalisée à J+1');
        $manager->persist($serviceCategory);
        
        */
        
        // Création de Services
        $thirdRepo = $manager->getRepository(Third::class);
        $thirds = $thirdRepo->findAll();
        
        $userRepo = $manager->getRepository(User::class);
        $users = $userRepo->findAll();
        
        $services = [];
        $ownerHistorics = [];
        
        for ($i=1; $i<=40; $i++) {

            $service = new Service();

            /*
            Gestion de la relation Service<->ServiceCategory
            */
            $category = 'Course';
            $serviceCategoryRepo = $manager->getRepository(ServiceCategory::class);
            $serviceCategory = $serviceCategoryRepo->findOneByTitle($category);
            
            $service->setServiceCategory($serviceCategory);

            /*
            Gestion des propriétés thirdOrder, thirdShipper et thirdReceiver
            */
            $thirdOrder = $thirds[mt_rand(0, (count($thirds) -1))];
            $service->setThirdOrder($thirdOrder);

            $valThirdShipper = mt_rand(1, 100);
            if ($valThirdShipper >= 30) { // Si >=70 alors
                $thirdShipper = $thirdOrder; // le Donneur d'Ordre et l'Expéditeur sont les mêmes
            } else { // Sinon le Donneur et l'Expédidteur sont différents
                $thirdShipper = $thirds[mt_rand(0, (count($thirds) -1))];
            }
            $service->setThirdShipper($thirdShipper);

            $valThirdReceiver = mt_rand(1, 100);
            if ($valThirdReceiver <= 10) { // Si <=10 alors
                $thirdReceiver = $thirdOrder; // le Donneur d'Ordre et le Destinataire sont les mêmes
            } else { // Sinon le Donneur et le Destinataire sont différents
                $thirdReceiver = $thirds[mt_rand(0, (count($thirds) -1))];
            }
            $service->setThirdReceiver($thirdReceiver);

            /*
            Gestion de userOwner
            */
            $valUserOwner = mt_rand(1, 100);
            if ($valUserOwner >= 40 ) { // Si >=40 alors on attribue la course à un Owner
                
                $userOwner = $users[mt_rand(0, (count($users) -1))];
                $service->setUserOwner($userOwner);

                /*
                Gestion de ownerHistoric
                */
                $ownerHistoric = new OwnerHistoric();

                $ownerHistoric->setUser($userOwner)
                              ->setService($service)
                              ->setCommentAuto("Création lors des Fixtures");

                $manager->persist($ownerHistoric);
                $ownerHistorics[] = $ownerHistoric;
            }

            $manager->persist($service);
            $services[] = $service;
        }
        //
        
        $manager->flush();
    }

}