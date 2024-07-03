<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703192205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE style DROP FOREIGN KEY FK_33BDB86AC4663E4');
        $this->addSql('ALTER TABLE style DROP FOREIGN KEY FK_33BDB86AD823E37A');
        $this->addSql('DROP INDEX IDX_33BDB86AC4663E4 ON style');
        $this->addSql('DROP INDEX IDX_33BDB86AD823E37A ON style');
        $this->addSql('ALTER TABLE style DROP section_id, DROP page_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE style ADD section_id INT DEFAULT NULL, ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE style ADD CONSTRAINT FK_33BDB86AC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE style ADD CONSTRAINT FK_33BDB86AD823E37A FOREIGN KEY (section_id) REFERENCES page_section (id)');
        $this->addSql('CREATE INDEX IDX_33BDB86AC4663E4 ON style (page_id)');
        $this->addSql('CREATE INDEX IDX_33BDB86AD823E37A ON style (section_id)');
    }
}
