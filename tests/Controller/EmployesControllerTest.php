<?php

namespace App\Test\Controller;

use App\Entity\Employes;
use App\Repository\EmployesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmployesRepository $repository;
    private string $path = '/employes/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Employes::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Employe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'employe[nom]' => 'Testing',
            'employe[prenom]' => 'Testing',
            'employe[sexe]' => 'Testing',
            'employe[adresse]' => 'Testing',
            'employe[dateNaissance]' => 'Testing',
        ]);

        self::assertResponseRedirects('/employes/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Employes();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setDateNaissance('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Employe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Employes();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setDateNaissance('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'employe[nom]' => 'Something New',
            'employe[prenom]' => 'Something New',
            'employe[sexe]' => 'Something New',
            'employe[adresse]' => 'Something New',
            'employe[dateNaissance]' => 'Something New',
        ]);

        self::assertResponseRedirects('/employes/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Employes();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setSexe('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setDateNaissance('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/employes/');
    }
}
