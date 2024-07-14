<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711183827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, given_professional_id INT DEFAULT NULL, date_in DATE NOT NULL, time_in TIME NOT NULL, duration INT NOT NULL, INDEX IDX_FE38F844D44746A3 (given_professional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, professional_id INT NOT NULL, client_id INT NOT NULL, title VARCHAR(120) NOT NULL, date DATE NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_5F9E962ADB77003 (professional_id), INDEX IDX_5F9E962A19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expertise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expertise_professional (expertise_id INT NOT NULL, professional_id INT NOT NULL, INDEX IDX_F0755B179D5B92F9 (expertise_id), INDEX IDX_F0755B17DB77003 (professional_id), PRIMARY KEY(expertise_id, professional_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_order (item_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_DF8E8848126F525E (item_id), INDEX IDX_DF8E88488D9F6D38 (order_id), PRIMARY KEY(item_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, professional_id INT NOT NULL, client_id INT NOT NULL, amount INT NOT NULL, unit VARCHAR(55) NOT NULL, date_start DATE NOT NULL, date_end DATE DEFAULT NULL, INDEX IDX_F5299398DB77003 (professional_id), INDEX IDX_F529939819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, required_expertise_id INT NOT NULL, required_professional_id INT NOT NULL, status_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_861D189619EB6921 (client_id), INDEX IDX_861D18966D1442D1 (required_expertise_id), INDEX IDX_861D18965CB2FEB5 (required_professional_id), INDEX IDX_861D18966BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reference VARCHAR(18) NOT NULL, UNIQUE INDEX UNIQ_B3B573AAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rights (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rights_user (rights_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5832F81FB196EE6E (rights_id), INDEX IDX_5832F81FA76ED395 (user_id), PRIMARY KEY(rights_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_user (roles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_57048B3038C751C4 (roles_id), INDEX IDX_57048B30A76ED395 (user_id), PRIMARY KEY(roles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_rights (roles_id INT NOT NULL, rights_id INT NOT NULL, INDEX IDX_EA47E46238C751C4 (roles_id), INDEX IDX_EA47E462B196EE6E (rights_id), PRIMARY KEY(roles_id, rights_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844D44746A3 FOREIGN KEY (given_professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ADB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE expertise_professional ADD CONSTRAINT FK_F0755B179D5B92F9 FOREIGN KEY (expertise_id) REFERENCES expertise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expertise_professional ADD CONSTRAINT FK_F0755B17DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_order ADD CONSTRAINT FK_DF8E8848126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_order ADD CONSTRAINT FK_DF8E88488D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18966D1442D1 FOREIGN KEY (required_expertise_id) REFERENCES expertise (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18965CB2FEB5 FOREIGN KEY (required_professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18966BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE professional ADD CONSTRAINT FK_B3B573AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rights_user ADD CONSTRAINT FK_5832F81FB196EE6E FOREIGN KEY (rights_id) REFERENCES rights (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rights_user ADD CONSTRAINT FK_5832F81FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_user ADD CONSTRAINT FK_57048B3038C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_user ADD CONSTRAINT FK_57048B30A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_rights ADD CONSTRAINT FK_EA47E46238C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_rights ADD CONSTRAINT FK_EA47E462B196EE6E FOREIGN KEY (rights_id) REFERENCES rights (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD client_id INT DEFAULT NULL, ADD nom VARCHAR(55) NOT NULL, ADD prenom VARCHAR(55) NOT NULL, ADD address VARCHAR(120) NOT NULL, ADD zip_code INT NOT NULL, ADD country VARCHAR(55) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64919EB6921 ON user (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844D44746A3');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962ADB77003');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A19EB6921');
        $this->addSql('ALTER TABLE expertise_professional DROP FOREIGN KEY FK_F0755B179D5B92F9');
        $this->addSql('ALTER TABLE expertise_professional DROP FOREIGN KEY FK_F0755B17DB77003');
        $this->addSql('ALTER TABLE item_order DROP FOREIGN KEY FK_DF8E8848126F525E');
        $this->addSql('ALTER TABLE item_order DROP FOREIGN KEY FK_DF8E88488D9F6D38');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398DB77003');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189619EB6921');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D18966D1442D1');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D18965CB2FEB5');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D18966BF700BD');
        $this->addSql('ALTER TABLE professional DROP FOREIGN KEY FK_B3B573AAA76ED395');
        $this->addSql('ALTER TABLE rights_user DROP FOREIGN KEY FK_5832F81FB196EE6E');
        $this->addSql('ALTER TABLE rights_user DROP FOREIGN KEY FK_5832F81FA76ED395');
        $this->addSql('ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B3038C751C4');
        $this->addSql('ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B30A76ED395');
        $this->addSql('ALTER TABLE roles_rights DROP FOREIGN KEY FK_EA47E46238C751C4');
        $this->addSql('ALTER TABLE roles_rights DROP FOREIGN KEY FK_EA47E462B196EE6E');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE expertise_professional');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_order');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE professional');
        $this->addSql('DROP TABLE rights');
        $this->addSql('DROP TABLE rights_user');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_user');
        $this->addSql('DROP TABLE roles_rights');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX UNIQ_8D93D64919EB6921 ON user');
        $this->addSql('ALTER TABLE user DROP client_id, DROP nom, DROP prenom, DROP address, DROP zip_code, DROP country');
    }
}
