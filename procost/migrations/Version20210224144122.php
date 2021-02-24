<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224144122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ManagementWorkingHours (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, employ_id INT NOT NULL, hours VARCHAR(255) NOT NULL, INDEX IDX_30BBC50A166D1F9C (project_id), INDEX IDX_30BBC50ABC18698D (employ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ManagementWorkingHours ADD CONSTRAINT FK_30BBC50A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE ManagementWorkingHours ADD CONSTRAINT FK_30BBC50ABC18698D FOREIGN KEY (employ_id) REFERENCES employ (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ManagementWorkingHours');
    }
}
