<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708195006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE section_content_style (section_content_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_B063F3DD19109932 (section_content_id), INDEX IDX_B063F3DDBACD6074 (style_id), PRIMARY KEY(section_content_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_content_style_group (section_content_id INT NOT NULL, style_group_id INT NOT NULL, INDEX IDX_AA012BD819109932 (section_content_id), INDEX IDX_AA012BD8DF86016C (style_group_id), PRIMARY KEY(section_content_id, style_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE section_content_style ADD CONSTRAINT FK_B063F3DD19109932 FOREIGN KEY (section_content_id) REFERENCES section_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_content_style ADD CONSTRAINT FK_B063F3DDBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_content_style_group ADD CONSTRAINT FK_AA012BD819109932 FOREIGN KEY (section_content_id) REFERENCES section_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_content_style_group ADD CONSTRAINT FK_AA012BD8DF86016C FOREIGN KEY (style_group_id) REFERENCES style_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section_content_style DROP FOREIGN KEY FK_B063F3DD19109932');
        $this->addSql('ALTER TABLE section_content_style DROP FOREIGN KEY FK_B063F3DDBACD6074');
        $this->addSql('ALTER TABLE section_content_style_group DROP FOREIGN KEY FK_AA012BD819109932');
        $this->addSql('ALTER TABLE section_content_style_group DROP FOREIGN KEY FK_AA012BD8DF86016C');
        $this->addSql('DROP TABLE section_content_style');
        $this->addSql('DROP TABLE section_content_style_group');
    }
}
