<?php

namespace App\Test\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/order/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Order::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Order index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'order[amount]' => 'Testing',
            'order[unit]' => 'Testing',
            'order[dateStart]' => 'Testing',
            'order[dateEnd]' => 'Testing',
            'order[Professional]' => 'Testing',
            'order[items]' => 'Testing',
            'order[client]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Order();
        $fixture->setAmount('My Title');
        $fixture->setUnit('My Title');
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setProfessional('My Title');
        $fixture->setItems('My Title');
        $fixture->setClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Order');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Order();
        $fixture->setAmount('Value');
        $fixture->setUnit('Value');
        $fixture->setDateStart('Value');
        $fixture->setDateEnd('Value');
        $fixture->setProfessional('Value');
        $fixture->setItems('Value');
        $fixture->setClient('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'order[amount]' => 'Something New',
            'order[unit]' => 'Something New',
            'order[dateStart]' => 'Something New',
            'order[dateEnd]' => 'Something New',
            'order[Professional]' => 'Something New',
            'order[items]' => 'Something New',
            'order[client]' => 'Something New',
        ]);

        self::assertResponseRedirects('/order/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAmount());
        self::assertSame('Something New', $fixture[0]->getUnit());
        self::assertSame('Something New', $fixture[0]->getDateStart());
        self::assertSame('Something New', $fixture[0]->getDateEnd());
        self::assertSame('Something New', $fixture[0]->getProfessional());
        self::assertSame('Something New', $fixture[0]->getItems());
        self::assertSame('Something New', $fixture[0]->getClient());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Order();
        $fixture->setAmount('Value');
        $fixture->setUnit('Value');
        $fixture->setDateStart('Value');
        $fixture->setDateEnd('Value');
        $fixture->setProfessional('Value');
        $fixture->setItems('Value');
        $fixture->setClient('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/order/');
        self::assertSame(0, $this->repository->count([]));
    }
}
