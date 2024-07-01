<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701192414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD pages_section_images_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FE9608745 FOREIGN KEY (pages_section_images_id) REFERENCES page_section (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FE9608745 ON image (pages_section_images_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FE9608745');
        $this->addSql('DROP INDEX IDX_C53D045FE9608745 ON image');
        $this->addSql('ALTER TABLE image DROP pages_section_images_id');
    }
}
