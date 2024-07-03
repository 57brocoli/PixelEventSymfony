<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703192544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE style_page_section DROP FOREIGN KEY FK_DCDD6A0ED3C3D2E4');
        $this->addSql('ALTER TABLE style_page_section DROP FOREIGN KEY FK_DCDD6A0EBACD6074');
        $this->addSql('DROP TABLE style_page_section');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE style_page_section (style_id INT NOT NULL, page_section_id INT NOT NULL, INDEX IDX_DCDD6A0EBACD6074 (style_id), INDEX IDX_DCDD6A0ED3C3D2E4 (page_section_id), PRIMARY KEY(style_id, page_section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE style_page_section ADD CONSTRAINT FK_DCDD6A0ED3C3D2E4 FOREIGN KEY (page_section_id) REFERENCES page_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_page_section ADD CONSTRAINT FK_DCDD6A0EBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
    }
}
