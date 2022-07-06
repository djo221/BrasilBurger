<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706090809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_taille DROP FOREIGN KEY FK_A517D3E0162BE352');
        $this->addSql('DROP INDEX IDX_A517D3E0162BE352 ON menu_taille');
        $this->addSql('ALTER TABLE menu_taille DROP portion_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_taille ADD portion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0162BE352 FOREIGN KEY (portion_id) REFERENCES portion_frite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A517D3E0162BE352 ON menu_taille (portion_id)');
    }
}
