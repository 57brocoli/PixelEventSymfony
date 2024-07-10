<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710131949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_style (page_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_553C47BCC4663E4 (page_id), INDEX IDX_553C47BCBACD6074 (style_id), PRIMARY KEY(page_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_style_group (page_id INT NOT NULL, style_group_id INT NOT NULL, INDEX IDX_B0A9544CC4663E4 (page_id), INDEX IDX_B0A9544CDF86016C (style_group_id), PRIMARY KEY(page_id, style_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_style ADD CONSTRAINT FK_553C47BCC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_style ADD CONSTRAINT FK_553C47BCBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_style_group ADD CONSTRAINT FK_B0A9544CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_style_group ADD CONSTRAINT FK_B0A9544CDF86016C FOREIGN KEY (style_group_id) REFERENCES style_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_style DROP FOREIGN KEY FK_553C47BCC4663E4');
        $this->addSql('ALTER TABLE page_style DROP FOREIGN KEY FK_553C47BCBACD6074');
        $this->addSql('ALTER TABLE page_style_group DROP FOREIGN KEY FK_B0A9544CC4663E4');
        $this->addSql('ALTER TABLE page_style_group DROP FOREIGN KEY FK_B0A9544CDF86016C');
        $this->addSql('DROP TABLE page_style');
        $this->addSql('DROP TABLE page_style_group');
    }
}
