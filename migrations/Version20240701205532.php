<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701205532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_section ADD CONSTRAINT FK_D713917AC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_D713917AC4663E4 ON page_section (page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section DROP FOREIGN KEY FK_D713917AC4663E4');
        $this->addSql('DROP INDEX IDX_D713917AC4663E4 ON page_section');
        $this->addSql('ALTER TABLE page_section DROP page_id');
    }
}
