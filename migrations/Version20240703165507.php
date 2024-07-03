<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703165507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE style (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, page_id INT DEFAULT NULL, property VARCHAR(100) NOT NULL, value VARCHAR(100) NOT NULL, INDEX IDX_33BDB86AD823E37A (section_id), INDEX IDX_33BDB86AC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE style ADD CONSTRAINT FK_33BDB86AD823E37A FOREIGN KEY (section_id) REFERENCES page_section (id)');
        $this->addSql('ALTER TABLE style ADD CONSTRAINT FK_33BDB86AC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE style DROP FOREIGN KEY FK_33BDB86AD823E37A');
        $this->addSql('ALTER TABLE style DROP FOREIGN KEY FK_33BDB86AC4663E4');
        $this->addSql('DROP TABLE style');
    }
}
