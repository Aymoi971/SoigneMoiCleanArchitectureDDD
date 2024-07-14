<?php

namespace App\Test\Controller;

use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppointmentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/appointment/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Appointment::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Appointment index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'appointment[dateIn]' => 'Testing',
            'appointment[timeIn]' => 'Testing',
            'appointment[duration]' => 'Testing',
            'appointment[given_Professional]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Appointment();
        $fixture->setDateIn('My Title');
        $fixture->setTimeIn('My Title');
        $fixture->setDuration('My Title');
        $fixture->setGiven_Professional('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Appointment');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Appointment();
        $fixture->setDateIn('Value');
        $fixture->setTimeIn('Value');
        $fixture->setDuration('Value');
        $fixture->setGiven_Professional('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'appointment[dateIn]' => 'Something New',
            'appointment[timeIn]' => 'Something New',
            'appointment[duration]' => 'Something New',
            'appointment[given_Professional]' => 'Something New',
        ]);

        self::assertResponseRedirects('/appointment/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateIn());
        self::assertSame('Something New', $fixture[0]->getTimeIn());
        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getGiven_Professional());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Appointment();
        $fixture->setDateIn('Value');
        $fixture->setTimeIn('Value');
        $fixture->setDuration('Value');
        $fixture->setGiven_Professional('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/appointment/');
        self::assertSame(0, $this->repository->count([]));
    }
}
