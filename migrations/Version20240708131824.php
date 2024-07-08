<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708131824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE section_content (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_content_image (section_content_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_46E34FE819109932 (section_content_id), INDEX IDX_46E34FE83DA5256D (image_id), PRIMARY KEY(section_content_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE section_content_image ADD CONSTRAINT FK_46E34FE819109932 FOREIGN KEY (section_content_id) REFERENCES section_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_content_image ADD CONSTRAINT FK_46E34FE83DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section_content_image DROP FOREIGN KEY FK_46E34FE819109932');
        $this->addSql('ALTER TABLE section_content_image DROP FOREIGN KEY FK_46E34FE83DA5256D');
        $this->addSql('DROP TABLE section_content');
        $this->addSql('DROP TABLE section_content_image');
    }
}
