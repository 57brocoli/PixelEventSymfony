<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626125635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artiste ADD featured_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT FK_9C07354F3569D950 FOREIGN KEY (featured_image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C07354F3569D950 ON artiste (featured_image_id)');
        $this->addSql('ALTER TABLE event ADD featured_image_id INT DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73569D950 FOREIGN KEY (featured_image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA73569D950 ON event (featured_image_id)');
        $this->addSql('ALTER TABLE lieu ADD featured_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D593569D950 FOREIGN KEY (featured_image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F577D593569D950 ON lieu (featured_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste DROP FOREIGN KEY FK_9C07354F3569D950');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73569D950');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D593569D950');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP INDEX UNIQ_9C07354F3569D950 ON artiste');
        $this->addSql('ALTER TABLE artiste DROP featured_image_id');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA73569D950 ON event');
        $this->addSql('ALTER TABLE event DROP featured_image_id, DROP image');
        $this->addSql('DROP INDEX UNIQ_2F577D593569D950 ON lieu');
        $this->addSql('ALTER TABLE lieu DROP featured_image_id');
    }
}
