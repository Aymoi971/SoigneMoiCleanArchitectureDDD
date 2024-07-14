<?php

// namespace App\SoigneMoiApp\Client\Infrastucture\Persistence;
// use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
// use App\Entity\User;
// use App\Entity\Client;
// use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
// use App\Repository\UserRepository;
// use App\Repository\ClientRepository;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Component\HttpFoundation\Request;
// use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;



class ClientImplementation extends ServiceEntityRepository implements ClientPersistenceInterface{
    public Request $request;
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }
    public function getClientUser($email):?ClientUser{
        //Maybe if not, write an independent function that will directly use the paramConverter for brevity
        // like: $user = getClientUser($email);
        // $manager = new ManagerRegistry();
        // $userRepository = new UserRepository($manager);
        $user = $userRepository->findOneByEmail($email);

        $email = $user->getEmail();
        $rightsArray = $user->getIndividualRights();
        $processesArray = $user->getClient()->getProcesses();
        if($user instanceof User){
            return new ClientUser($email, $rightsArray, $processesArray, $user->getNom(), $user->getPrenom(), $user->getAddress()." ".$user->getZipCode()." ".$user->getCountry());
        }
        return null;
    }
    public function addClientUser(ClientUser $clientUser):bool{
        $manager = new ManagerRegistry();
        $userRepository = new UserRepository($manager);
        $user = $userRepository->findOneByEmail($email);

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

    }    
    public function isLoggedIn(ClientUser $clientUser):bool{}
    public function authenticate($email, $password):bool{}
    // public function isAuthorized($email,$right):bool{}
    public function getClientProcess(ClientUser $clientUser):?ClientProcess{}
    public function addClientProcess(ClientUser $clientUser, ClientProcess $clientProcess):bool{}
    public function setClientProcess(ClientUser $clientUser):bool{}
}
