<?php

use PHPUnit\Framework\TestCase;
use App\SoigneMoiApp\Client\Domain\UseCase\CreateProcess\ClientCreateProcess;
use App\SoigneMoiApp\Client\Domain\UseCase\CreateProcess\ClientCreateProcessRequest;
use App\SoigneMoiApp\Client\Domain\UseCase\CreateProcess\ClientCreateProcessResponse;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;

class ClientCreateProcessTest extends TestCase
{
    private $clientCreateProcess;
    private $mockPersistence;
    private $mockOutputPort;

    protected function setUp(): void
    {
        $this->clientCreateProcess = new ClientCreateProcess();
        $this->mockPersistence = $this->createMock(ClientPersistenceInterface::class);
        $this->mockOutputPort = $this->createMock(ClientOutputPort::class);
    }

    public function testSuccessfulProcessCreation()
    {
        $user = new ClientUser('test@example.com', ['Create_Process_Self']);
        $process = new ClientProcess('2024-07-15', '2024-07-20', 'General', 'Checkup', 'Dr. Smith');

        $this->mockPersistence->method('isLoggedIn')->willReturn(true);
        $this->mockPersistence->expects($this->once())->method('addClientProcess');

        $request = new ClientCreateProcessRequest($user, $process, $this->mockPersistence);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'success' && $response->message === 'Process_added';
            }));

        $this->clientCreateProcess->execute($request, $this->mockOutputPort);
    }

    public function testUnauthorizedProcessCreation()
    {
        $user = new ClientUser('test@example.com', []);
        $process = new ClientProcess('2024-07-15', '2024-07-20', 'General', 'Checkup', 'Dr. Smith');

        $request = new ClientCreateProcessRequest($user, $process, $this->mockPersistence);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Not_Authorized';
            }));

        $this->clientCreateProcess->execute($request, $this->mockOutputPort);
    }

    public function testNotLoggedInProcessCreation()
    {
        $user = new ClientUser('test@example.com', ['Create_Process_Self']);
        $process = new ClientProcess('2024-07-15', '2024-07-20', 'General', 'Checkup', 'Dr. Smith');

        $this->mockPersistence->method('isLoggedIn')->willReturn(false);

        $request = new ClientCreateProcessRequest($user, $process, $this->mockPersistence);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Not_Logged_In';
            }));

        $this->clientCreateProcess->execute($request, $this->mockOutputPort);
    }

    public function testIncompleteProcessCreation()
    {
        $user = new ClientUser('test@example.com', ['Create_Process_Self']);
        $process = new ClientProcess(); // Empty process will have errors

        $this->mockPersistence->method('isLoggedIn')->willReturn(true);

        $request = new ClientCreateProcessRequest($user, $process, $this->mockPersistence);

        $this->mockOutputPort->expects($this->once())
            ->method('present')
            ->with($this->callback(function ($response) {
                return $response->status === 'failure' && $response->message === 'Incomplete' && !empty($response->errors);
            }));

        $this->clientCreateProcess->execute($request, $this->mockOutputPort);
    }
}