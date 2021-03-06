<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706085718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu_portion_frite');
        $this->addSql('DROP TABLE menu_taille');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_portion_frite (menu_id INT NOT NULL, portion_frite_id INT NOT NULL, INDEX IDX_29FA693B9B17FA7B (portion_frite_id), INDEX IDX_29FA693BCCD7E912 (menu_id), PRIMARY KEY(menu_id, portion_frite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu_taille (menu_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_A517D3E0CCD7E912 (menu_id), INDEX IDX_A517D3E0FF25611A (taille_id), PRIMARY KEY(menu_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_portion_frite ADD CONSTRAINT FK_29FA693B9B17FA7B FOREIGN KEY (portion_frite_id) REFERENCES portion_frite (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_portion_frite ADD CONSTRAINT FK_29FA693BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
