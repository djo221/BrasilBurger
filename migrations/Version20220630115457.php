<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630115457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_complements DROP FOREIGN KEY FK_52BE81ECD1322E03');
        $this->addSql('DROP TABLE complements');
        $this->addSql('DROP TABLE menu_complements');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complements (id INT AUTO_INCREMENT NOT NULL, taille_id INT DEFAULT NULL, portion_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_3A429FA0162BE352 (portion_id), UNIQUE INDEX UNIQ_3A429FA0FF25611A (taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu_complements (menu_id INT NOT NULL, complements_id INT NOT NULL, INDEX IDX_52BE81ECCCD7E912 (menu_id), INDEX IDX_52BE81ECD1322E03 (complements_id), PRIMARY KEY(menu_id, complements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE complements ADD CONSTRAINT FK_3A429FA0162BE352 FOREIGN KEY (portion_id) REFERENCES portion_frite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE complements ADD CONSTRAINT FK_3A429FA0FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE menu_complements ADD CONSTRAINT FK_52BE81ECCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_complements ADD CONSTRAINT FK_52BE81ECD1322E03 FOREIGN KEY (complements_id) REFERENCES complements (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
