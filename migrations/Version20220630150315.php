<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630150315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D685E5B99');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93685E5B99');
        $this->addSql('DROP TABLE catalogues');
        $this->addSql('DROP INDEX IDX_EFE35A0D685E5B99 ON burger');
        $this->addSql('ALTER TABLE burger DROP catalogues_id');
        $this->addSql('DROP INDEX IDX_7D053A93685E5B99 ON menu');
        $this->addSql('ALTER TABLE menu DROP catalogues_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalogues (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE burger ADD catalogues_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D685E5B99 FOREIGN KEY (catalogues_id) REFERENCES catalogues (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EFE35A0D685E5B99 ON burger (catalogues_id)');
        $this->addSql('ALTER TABLE menu ADD catalogues_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93685E5B99 FOREIGN KEY (catalogues_id) REFERENCES catalogues (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7D053A93685E5B99 ON menu (catalogues_id)');
    }
}
