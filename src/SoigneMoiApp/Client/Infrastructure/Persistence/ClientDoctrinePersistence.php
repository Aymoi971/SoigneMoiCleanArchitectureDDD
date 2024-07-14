<?php

namespace App\SoigneMoiApp\Client\Infrastructure\Persistence;

use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Process;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\ProcessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientDoctrinePersistence implements ClientPersistenceInterface
{
    private $userRepository;
    private $clientRepository;
    private $processRepository;
    private $entityManager;
    private $security;
    private $passwordHasher;

    public function __construct(
        UserRepository $userRepository,
        ClientRepository $clientRepository,
        ProcessRepository $processRepository,
        EntityManagerInterface $entityManager,
        Security $security,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
        $this->processRepository = $processRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->passwordHasher = $passwordHasher;
    }

    public function getClientUser($email): ?ClientUser
    {
        $user = $this->userRepository->findOneByEmail($email);
        if (!$user || !$user->getClient()) {
            return null;
        }
        return $this->mapUserToClientUser($user);
    }

    public function addClientUser(ClientUser $clientUser): bool
    {
        $user = new User();
        $user->setEmail($clientUser->getEmail());
        $user->setNom($clientUser->profile->nom);
        $user->setPrenom($clientUser->profile->prenom);
        $user->setAddress($clientUser->profile->address);
        // Set other fields as necessary

        $client = new Client();
        $client->setUser($user);
        $user->setClient($client);

        $this->entityManager->persist($user);
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return true;
    }

    public function isLoggedIn(ClientUser $clientUser): bool
    {
       $user = $this->getLoggedInUser();
        return $user && $user->getEmail() === $clientUser->getEmail();
    }

    private function getLoggedInUser():?User {
        return $this->security->getUser();
    }

    public function authenticate($email, $password): bool
    {
        $user = $this->userRepository->findOneByEmail($email);
        if (!$user) {
            return false;
        }

        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function addClientProcess(ClientUser $clientUser, ClientProcess $clientProcess): bool
    {
        $user = $this->userRepository->findOneByEmail($clientUser->getEmail());
        if (!$user || !$user->getClient()) {
            return false;
        }

        $process = new Process();
        $process->setStartDate(new \DateTime($clientProcess->getStartDate()));
        $process->setEndDate(new \DateTime($clientProcess->getEndDate()));
        $process->setDescription($clientProcess->getDescription());
        // Set other fields as necessary
        $process->setClient($user->getClient());

        $this->entityManager->persist($process);
        $this->entityManager->flush();

        return true;
    }

    public function setClientProcess(ClientUser $clientUser): bool
    {
        $user = $this->userRepository->findOneByEmail($clientUser->getEmail());
        if (!$user || !$user->getClient()) {
            return false;
        }

        $client = $user->getClient();

        // Remove all existing processes
        foreach ($client->getProcesses() as $process) {
            $client->removeProcess($process);
            $this->entityManager->remove($process);
        }

        // Add new processes
        foreach ($clientUser->getProcessesArray() as $clientProcess) {
            $process = new Process();
            $process->setStartDate(new \DateTime($clientProcess->getStartDate()));
            $process->setEndDate(new \DateTime($clientProcess->getEndDate()));
            $process->setDescription($clientProcess->getDescription());
            // Set other fields as necessary
            $client->addProcess($process);
        }

        $this->entityManager->flush();

        return true;
    }

    private function mapUserToClientUser(User $user): ClientUser
    {
        $clientUser = new ClientUser(
            $user->getEmail(),
            $this->mapRolesToRights($user->getRoles()),
            $this->mapProcessesToClientProcesses($user->getClient()->getProcesses()),
            $user->getNom(),
            $user->getPrenom(),
            $user->getAddress()
        );
        return $clientUser;
    }

    private function mapRolesToRights(array $roles): array
    {
        // Map Symfony roles to your application's rights
        $rightsMap = [
            'ROLE_USER' => ['Create_Process_Self', 'View_Process_Self'],
            'ROLE_ADMIN' => ['Create_Process_Self', 'View_Process_Self', 'Admin_Rights'],
        ];

        $rights = [];
        foreach ($roles as $role) {
            if (isset($rightsMap[$role])) {
                $rights = array_merge($rights, $rightsMap[$role]);
            }
        }

        return array_unique($rights);
    }

    private function mapProcessesToClientProcesses(Collection $processes): array
    {
        $clientProcesses = [];
        foreach ($processes as $process) {
            $clientProcess = new ClientProcess(
                $process->getStartDate()->format('Y-m-d'),
                $process->getEndDate()->format('Y-m-d'),
                $process->getRequiredExpertise()->getName(), // Assuming Expertise entity has a getName() method
                $process->getDescription(),
                $process->getRequiredProfessional()->getUser()->getEmail() // Assuming Professional entity has a getUser() method
            );
            $clientProcesses[] = $clientProcess;
        }
        return $clientProcesses;
    }
}