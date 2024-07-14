<?php

use PHPUnit\Framework\TestCase;
use App\SoigneMoiApp\Client\Domain\UseCase\Register\ClientRegister;
use App\SoigneMoiApp\Client\Domain\UseCase\Register\ClientRegisterRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;

class ClientRegisterTest extends TestCase
{
    private $clientRegister;
    private $mockPersistence;
    private $mockOutputPort;

    protected function setUp(): void
    {
        $this->clientRegister = new ClientRegister();
        $this->mockPersistence = $this->createMock(ClientPersistenceInterface::class);
        $this->mockOutputPort = $this->createMock(ClientOutputPort::class);
    }

    public function testSuccessfulRegistration()
    {
        $email = 'newuser@example.com';
        $password1 = 'password123';
        $password2 = 'password123';
        $nom = 'Doe';
        $prenom = 'John';
        $address = '123 Main St';

        $this->mockPersistence->method('getClientUser')->with($email)->willReturn(null);
        $this->mockPersistence->method('addClientUser')->willReturn(true);

        $request = new ClientRegisterRequest($this->mockPersistence, $email, $password1, $password2, $nom, $prenom, $address);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'sucess' && $response->message === 'User_registered';
            }));

        $this->clientRegister->execute($request, $this->mockOutputPort);
    }

    public function testRegistrationWithExistingEmail()
    {
        $email = 'existing@example.com';
        $password1 = 'password123';
        $password2 = 'password123';
        $nom = 'Doe';
        $prenom = 'John';
        $address = '123 Main St';

        $this->mockPersistence->method('getClientUser')->with($email)->willReturn(new ClientUser($email));

        $request = new ClientRegisterRequest($this->mockPersistence, $email, $password1, $password2, $nom, $prenom, $address);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Email_exists';
            }));

        $this->clientRegister->execute($request, $this->mockOutputPort);
    }

    public function testRegistrationWithIncompleteData()
    {
        $email = 'newuser@example.com';
        $password1 = 'password123';
        $password2 = 'password123';
        $nom = null;
        $prenom = 'John';
        $address = '123 Main St';

        $request = new ClientRegisterRequest($this->mockPersistence, $email, $password1, $password2, $nom, $prenom, $address);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Incomplete' && isset($response->errors['nom']);
            }));

        $this->clientRegister->execute($request, $this->mockOutputPort);
    }
}