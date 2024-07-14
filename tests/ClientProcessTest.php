<?php

use PHPUnit\Framework\TestCase;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;

class ClientProcessTest extends TestCase
{
    public function testProcessCreationWithAllFields()
    {
        $process = new ClientProcess('2024-07-15', '2024-07-20', 'General', 'Checkup', 'Dr. Smith');
        $this->assertEmpty($process->getErrors());
    }

    public function testProcessCreationWithMissingFields()
    {
        $process = new ClientProcess();
        $errors = $process->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('start', $errors);
        $this->assertArrayHasKey('end', $errors);
        $this->assertArrayHasKey('expertise', $errors);
        $this->assertArrayHasKey('description', $errors);
        $this->assertArrayHasKey('preferred', $errors);
    }

    public function testProcessCreationWithMissingStartDate()
    {
        $process = new ClientProcess(null, '2024-07-20', 'General', 'Checkup', 'Dr. Smith');
        $errors = $process->getErrors();
        $this->assertArrayHasKey('start', $errors);
        $this->assertEquals("Start_Date_Required", $errors['start']);
    }

    public function testProcessCreationWithMissingEndDate()
    {
        $process = new ClientProcess('2024-07-15', null, 'General', 'Checkup', 'Dr. Smith');
        $errors = $process->getErrors();
        $this->assertArrayHasKey('end', $errors);
        $this->assertEquals("End_Date_Required", $errors['end']);
    }

    public function testProcessCreationWithMissingExpertise()
    {
        $process = new ClientProcess('2024-07-15', '2024-07-20', null, 'Checkup', 'Dr. Smith');
        $errors = $process->getErrors();
        $this->assertArrayHasKey('expertise', $errors);
        $this->assertEquals("Expertise_Required", $errors['expertise']);
    }

    public function testProcessCreationWithMissingDescription()
    {
        $process = new ClientProcess('2024-07-15', '2024-07-20', 'General', null, 'Dr. Smith');
        $errors = $process->getErrors();
        $this->assertArrayHasKey('description', $errors);
        $this->assertEquals("Description_Required", $errors['description']);
    }

    public function testProcessCreationWithMissingPreferedProfessional()
    {
        $process = new ClientProcess('2024-07-15', '2024-07-20', 'General', 'Checkup', null);
        $errors = $process->getErrors();
        $this->assertArrayHasKey('preferred', $errors);
        $this->assertEquals("Preferred_Professional_Required", $errors['preferred']);
    }

    public function testSettersRemoveErrors()
    {
        $process = new ClientProcess();
        $process->setStartDate('2024-07-15');
        $process->setEndDate('2024-07-20');
        $process->setExpertise('General');
        $process->setDescription('Checkup');
        $process->setPreferredProfessional('Dr. Smith');
        $this->assertEmpty($process->getErrors());
    }
}