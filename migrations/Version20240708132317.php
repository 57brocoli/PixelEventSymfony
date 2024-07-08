<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708132317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section DROP FOREIGN KEY FK_D713917A3DA5256D');
        $this->addSql('DROP INDEX UNIQ_D713917A3DA5256D ON page_section');
        $this->addSql('ALTER TABLE page_section DROP image_id, DROP content');
        $this->addSql('ALTER TABLE section_content ADD section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE section_content ADD CONSTRAINT FK_2C82FDA6D823E37A FOREIGN KEY (section_id) REFERENCES page_section (id)');
        $this->addSql('CREATE INDEX IDX_2C82FDA6D823E37A ON section_content (section_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_section ADD image_id INT DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_section ADD CONSTRAINT FK_D713917A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D713917A3DA5256D ON page_section (image_id)');
        $this->addSql('ALTER TABLE section_content DROP FOREIGN KEY FK_2C82FDA6D823E37A');
        $this->addSql('DROP INDEX IDX_2C82FDA6D823E37A ON section_content');
        $this->addSql('ALTER TABLE section_content DROP section_id');
    }
}
