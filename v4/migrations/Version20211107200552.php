<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211107200552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche_personnage (id INT AUTO_INCREMENT NOT NULL, personnage_id INT NOT NULL, creation_exp INT NOT NULL, avantages LONGTEXT DEFAULT NULL, desavantages LONGTEXT DEFAULT NULL, constitution SMALLINT NOT NULL, volonte SMALLINT NOT NULL, reflexes SMALLINT NOT NULL, intuition SMALLINT NOT NULL, agilite SMALLINT NOT NULL, intelligence SMALLINT NOT NULL, force_stat SMALLINT NOT NULL, perception SMALLINT NOT NULL, vide SMALLINT NOT NULL, UNIQUE INDEX UNIQ_C4BC4C9A5E315342 (personnage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche_personnage ADD CONSTRAINT FK_C4BC4C9A5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fiche_personnage');
    }
}
