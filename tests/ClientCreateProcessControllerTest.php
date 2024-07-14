<?php

namespace App\Tests\SoigneMoiApp\Client\Infrastucture\Controller;

use PHPUnit\Framework\TestCase;
use App\SoigneMoiApp\Client\Infrastucture\Controller\ClientCreateProcessController;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Infrastucture\Presenter\ClientCreateProcessPresenter;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;

class ClientCreateProcessControllerTest extends TestCase
{
    private $controller;
    private $mockPersistence;
    private $mockPresenter;

    protected function setUp(): void
    {
        $this->mockPersistence = $this->createMock(ClientPersistenceInterface::class);
        $this->mockPresenter = $this->createMock(ClientCreateProcessPresenter::class);
        $this->controller = new ClientCreateProcessController($this->mockPersistence, $this->mockPresenter);
    }

    public function testHandle()
    {
        $clientUser = new ClientUser('test@example.com', ['Create_Process_Self']);
        $clientProcess = new ClientProcess('2024-07-15', '2024-07-20', 'General', 'Checkup', 'Dr. Smith');

        $this->mockPersistence->expects($this->once())
            ->method('isAuthorized')
            ->with($clientUser)
            ->willReturn(true);

        $this->mockPersistence->expects($this->once())
            ->method('isLoggedIn')
            ->with($clientUser)
            ->willReturn(true);

        $this->mockPresenter->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'success' && $response->message === 'Process_added';
            }));

        $this->controller->handle($clientUser, $clientProcess);
    }
}
