<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728124722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP adresse');
        $this->addSql('ALTER TABLE gestionnaire DROP nom, DROP prenom');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD adresse VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE gestionnaire ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP adresse');
    }
}
