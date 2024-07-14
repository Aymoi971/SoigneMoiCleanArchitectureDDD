<?php

use PHPUnit\Framework\TestCase;
use App\SoigneMoiApp\Client\Domain\UseCase\Login\ClientLogin;
use App\SoigneMoiApp\Client\Domain\UseCase\Login\ClientLoginRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;

class ClientLoginTest extends TestCase
{
    private $clientLogin;
    private $mockPersistence;
    private $mockOutputPort;

    protected function setUp(): void
    {
        $this->clientLogin = new ClientLogin();
        $this->mockPersistence = $this->createMock(ClientPersistenceInterface::class);
        $this->mockOutputPort = $this->createMock(ClientOutputPort::class);
    }

    public function testSuccessfulLogin()
    {
        $email = 'test@example.com';
        $password = 'password123';
        $user = new ClientUser($email);

        $this->mockPersistence->method('getClientUser')->with($email)->willReturn($user);
        $this->mockPersistence->method('authenticate')->with($email, $password)->willReturn(true);

        $request = new ClientLoginRequest($this->mockPersistence, $email, $password);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'success' && $response->message === 'User_Logged_In';
            }));

        $this->clientLogin->execute($request, $this->mockOutputPort);
    }

    public function testLoginWithInvalidEmail()
    {
        $email = 'nonexistent@example.com';
        $password = 'password123';

        $this->mockPersistence->method('getClientUser')->with($email)->willReturn(null);

        $request = new ClientLoginRequest($this->mockPersistence, $email, $password);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Invalid_Email';
            }));

        $this->clientLogin->execute($request, $this->mockOutputPort);
    }

    public function testLoginWithInvalidPassword()
    {
        $email = 'test@example.com';
        $password = 'wrongpassword';
        $user = new ClientUser($email);

        $this->mockPersistence->method('getClientUser')->with($email)->willReturn($user);
        $this->mockPersistence->method('authenticate')->with($email, $password)->willReturn(false);

        $request = new ClientLoginRequest($this->mockPersistence, $email, $password);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Invalid_Password';
            }));

        $this->clientLogin->execute($request, $this->mockOutputPort);
    }
}