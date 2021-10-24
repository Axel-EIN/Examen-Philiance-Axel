<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021215013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chef (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clan ADD chef_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clan ADD CONSTRAINT FK_9FF6A30C150A48F1 FOREIGN KEY (chef_id) REFERENCES personnage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9FF6A30C150A48F1 ON clan (chef_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE chef');
        $this->addSql('ALTER TABLE clan DROP FOREIGN KEY FK_9FF6A30C150A48F1');
        $this->addSql('DROP INDEX UNIQ_9FF6A30C150A48F1 ON clan');
        $this->addSql('ALTER TABLE clan DROP chef_id');
    }
}
