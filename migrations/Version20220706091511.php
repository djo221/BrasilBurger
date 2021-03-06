<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706091511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_portion (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, portion_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_685BE098CCD7E912 (menu_id), INDEX IDX_685BE098162BE352 (portion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_portion ADD CONSTRAINT FK_685BE098CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_portion ADD CONSTRAINT FK_685BE098162BE352 FOREIGN KEY (portion_id) REFERENCES portion_frite (id)');
        $this->addSql('ALTER TABLE menu_taille ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_A517D3E0CCD7E912 ON menu_taille (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu_portion');
        $this->addSql('ALTER TABLE menu_taille DROP FOREIGN KEY FK_A517D3E0CCD7E912');
        $this->addSql('DROP INDEX IDX_A517D3E0CCD7E912 ON menu_taille');
        $this->addSql('ALTER TABLE menu_taille DROP menu_id');
    }
}
