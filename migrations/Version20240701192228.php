<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701192228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_section ADD CONSTRAINT FK_D713917A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D713917A3DA5256D ON page_section (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section DROP FOREIGN KEY FK_D713917A3DA5256D');
        $this->addSql('DROP INDEX UNIQ_D713917A3DA5256D ON page_section');
        $this->addSql('ALTER TABLE page_section DROP image_id');
    }
}
