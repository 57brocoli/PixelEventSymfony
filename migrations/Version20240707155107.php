<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240707155107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_section_style_group (page_section_id INT NOT NULL, style_group_id INT NOT NULL, INDEX IDX_93B3E9DAD3C3D2E4 (page_section_id), INDEX IDX_93B3E9DADF86016C (style_group_id), PRIMARY KEY(page_section_id, style_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_section_style_group ADD CONSTRAINT FK_93B3E9DAD3C3D2E4 FOREIGN KEY (page_section_id) REFERENCES page_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_section_style_group ADD CONSTRAINT FK_93B3E9DADF86016C FOREIGN KEY (style_group_id) REFERENCES style_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section_style_group DROP FOREIGN KEY FK_93B3E9DAD3C3D2E4');
        $this->addSql('ALTER TABLE page_section_style_group DROP FOREIGN KEY FK_93B3E9DADF86016C');
        $this->addSql('DROP TABLE page_section_style_group');
    }
}
