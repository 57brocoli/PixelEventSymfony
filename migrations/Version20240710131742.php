<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710131742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_style_group DROP FOREIGN KEY FK_B0A9544CDF86016C');
        $this->addSql('ALTER TABLE page_style_group DROP FOREIGN KEY FK_B0A9544CC4663E4');
        $this->addSql('ALTER TABLE style_page DROP FOREIGN KEY FK_7B86C7D1BACD6074');
        $this->addSql('ALTER TABLE style_page DROP FOREIGN KEY FK_7B86C7D1C4663E4');
        $this->addSql('DROP TABLE page_style_group');
        $this->addSql('DROP TABLE style_page');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_style_group (page_id INT NOT NULL, style_group_id INT NOT NULL, INDEX IDX_B0A9544CDF86016C (style_group_id), INDEX IDX_B0A9544CC4663E4 (page_id), PRIMARY KEY(page_id, style_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE style_page (style_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_7B86C7D1C4663E4 (page_id), INDEX IDX_7B86C7D1BACD6074 (style_id), PRIMARY KEY(style_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE page_style_group ADD CONSTRAINT FK_B0A9544CDF86016C FOREIGN KEY (style_group_id) REFERENCES style_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_style_group ADD CONSTRAINT FK_B0A9544CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_page ADD CONSTRAINT FK_7B86C7D1BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_page ADD CONSTRAINT FK_7B86C7D1C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }
}
