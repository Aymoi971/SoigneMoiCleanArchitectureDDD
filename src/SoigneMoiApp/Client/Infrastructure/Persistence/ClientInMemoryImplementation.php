<?php

namespace App\SoigneMoiApp\Client\Infrastructure\Persistence;

use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;

class InMemoryClientPersistence implements ClientPersistenceInterface
{
    private array $users = [];
    private array $processes = [];
    private array $loggedInUsers = [];

    public function getClientUser($email): ?ClientUser
    {
        return $this->users[$email] ?? null;
    }

    public function addClientUser(ClientUser $clientUser): bool
    {
        $email = $clientUser->getEmail();
        if (isset($this->users[$email])) {
            return false;
        }
        $this->users[$email] = $clientUser;
        return true;
    }

    public function isLoggedIn(ClientUser $clientUser): bool
    {
        return in_array($clientUser->getEmail(), $this->loggedInUsers);
    }

    public function authenticate($email, $password): bool
    {
        $user = $this->getClientUser($email);
        if ($user && $password === 'correct_password') { // Simulating password check
            $this->loggedInUsers[] = $email;
            return true;
        }
        return false;
    }

    public function addClientProcess(ClientUser $clientUser, ClientProcess $clientProcess): bool
    {
        $email = $clientUser->getEmail();
        if (!isset($this->processes[$email])) {
            $this->processes[$email] = [];
        }
        $this->processes[$email][] = $clientProcess;
        return true;
    }

    public function setClientProcess(ClientUser $clientUser): bool
    {
        // This method is not clear in its purpose. For now, we'll just return true.
        return true;
    }
}