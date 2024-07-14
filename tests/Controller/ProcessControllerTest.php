<?php

namespace App\Test\Controller;

use App\Entity\Process;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProcessControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/process/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Process::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Process index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'process[startDate]' => 'Testing',
            'process[endDate]' => 'Testing',
            'process[Description]' => 'Testing',
            'process[client]' => 'Testing',
            'process[requiredExpertise]' => 'Testing',
            'process[requiredProfessional]' => 'Testing',
            'process[status]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Process();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setDescription('My Title');
        $fixture->setClient('My Title');
        $fixture->setRequiredExpertise('My Title');
        $fixture->setRequiredProfessional('My Title');
        $fixture->setStatus('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Process');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Process();
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setDescription('Value');
        $fixture->setClient('Value');
        $fixture->setRequiredExpertise('Value');
        $fixture->setRequiredProfessional('Value');
        $fixture->setStatus('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'process[startDate]' => 'Something New',
            'process[endDate]' => 'Something New',
            'process[Description]' => 'Something New',
            'process[client]' => 'Something New',
            'process[requiredExpertise]' => 'Something New',
            'process[requiredProfessional]' => 'Something New',
            'process[status]' => 'Something New',
        ]);

        self::assertResponseRedirects('/process/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getClient());
        self::assertSame('Something New', $fixture[0]->getRequiredExpertise());
        self::assertSame('Something New', $fixture[0]->getRequiredProfessional());
        self::assertSame('Something New', $fixture[0]->getStatus());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Process();
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setDescription('Value');
        $fixture->setClient('Value');
        $fixture->setRequiredExpertise('Value');
        $fixture->setRequiredProfessional('Value');
        $fixture->setStatus('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/process/');
        self::assertSame(0, $this->repository->count([]));
    }
}
