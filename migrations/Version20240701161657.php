<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701161657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section DROP FOREIGN KEY FK_D713917A3DA5256D');
        $this->addSql('ALTER TABLE page_section_image DROP FOREIGN KEY FK_C3B01300D3C3D2E4');
        $this->addSql('ALTER TABLE page_section_image DROP FOREIGN KEY FK_C3B013003DA5256D');
        $this->addSql('DROP TABLE page_section');
        $this->addSql('DROP TABLE page_section_image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_section (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, title VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D713917A3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE page_section_image (page_section_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_C3B01300D3C3D2E4 (page_section_id), INDEX IDX_C3B013003DA5256D (image_id), PRIMARY KEY(page_section_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE page_section ADD CONSTRAINT FK_D713917A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE page_section_image ADD CONSTRAINT FK_C3B01300D3C3D2E4 FOREIGN KEY (page_section_id) REFERENCES page_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_section_image ADD CONSTRAINT FK_C3B013003DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
    }
}
