<?php

namespace App\Test\Controller;

use App\Entity\Comments;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/comments/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Comments::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Comment index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'comment[title]' => 'Testing',
            'comment[date]' => 'Testing',
            'comment[description]' => 'Testing',
            'comment[professional]' => 'Testing',
            'comment[client]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Comments();
        $fixture->setTitle('My Title');
        $fixture->setDate('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfessional('My Title');
        $fixture->setClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Comment');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Comments();
        $fixture->setTitle('Value');
        $fixture->setDate('Value');
        $fixture->setDescription('Value');
        $fixture->setProfessional('Value');
        $fixture->setClient('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'comment[title]' => 'Something New',
            'comment[date]' => 'Something New',
            'comment[description]' => 'Something New',
            'comment[professional]' => 'Something New',
            'comment[client]' => 'Something New',
        ]);

        self::assertResponseRedirects('/comments/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getProfessional());
        self::assertSame('Something New', $fixture[0]->getClient());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Comments();
        $fixture->setTitle('Value');
        $fixture->setDate('Value');
        $fixture->setDescription('Value');
        $fixture->setProfessional('Value');
        $fixture->setClient('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/comments/');
        self::assertSame(0, $this->repository->count([]));
    }
}
