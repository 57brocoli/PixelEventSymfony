<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624140931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode ADD day_id INT NOT NULL');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA9C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA9C24126 ON episode (day_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA9C24126');
        $this->addSql('DROP INDEX IDX_DDAA1CDA9C24126 ON episode');
        $this->addSql('ALTER TABLE episode DROP day_id');
    }
}
