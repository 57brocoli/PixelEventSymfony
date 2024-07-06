<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705203002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, INDEX IDX_64C19C112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, page_section_id INT DEFAULT NULL, kind VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_389B783D3C3D2E4 (page_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783D3C3D2E4 FOREIGN KEY (page_section_id) REFERENCES page_section (id)');
        $this->addSql('ALTER TABLE style ADD category_id INT DEFAULT NULL, ADD tag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE style ADD CONSTRAINT FK_33BDB86A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE style ADD CONSTRAINT FK_33BDB86ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_33BDB86A12469DE2 ON style (category_id)');
        $this->addSql('CREATE INDEX IDX_33BDB86ABAD26311 ON style (tag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE style DROP FOREIGN KEY FK_33BDB86A12469DE2');
        $this->addSql('ALTER TABLE style DROP FOREIGN KEY FK_33BDB86ABAD26311');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C112469DE2');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783D3C3D2E4');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP INDEX IDX_33BDB86A12469DE2 ON style');
        $this->addSql('DROP INDEX IDX_33BDB86ABAD26311 ON style');
        $this->addSql('ALTER TABLE style DROP category_id, DROP tag_id');
    }
}
