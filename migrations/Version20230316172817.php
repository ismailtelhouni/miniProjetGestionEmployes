<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316172817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, designation_serv VARCHAR(100) NOT NULL, description_serv VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employes ADD num_serv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employes ADD CONSTRAINT FK_A94BC0F08990C105 FOREIGN KEY (num_serv_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_A94BC0F08990C105 ON employes (num_serv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employes DROP FOREIGN KEY FK_A94BC0F08990C105');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_A94BC0F08990C105 ON employes');
        $this->addSql('ALTER TABLE employes DROP num_serv_id');
    }
}
