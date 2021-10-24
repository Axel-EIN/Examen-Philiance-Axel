<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021214336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clan (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, est_majeur SMALLINT DEFAULT NULL, couleur VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ecole (id INT AUTO_INCREMENT NOT NULL, classe_id INT NOT NULL, clan_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, tech1_nom VARCHAR(255) DEFAULT NULL, tech1_desc LONGTEXT DEFAULT NULL, tech2_nom VARCHAR(255) DEFAULT NULL, tech2_desc LONGTEXT DEFAULT NULL, tech3_nom VARCHAR(255) DEFAULT NULL, tech3_desc LONGTEXT DEFAULT NULL, tech4_nom VARCHAR(255) DEFAULT NULL, tech4_desc LONGTEXT DEFAULT NULL, tech5_nom VARCHAR(255) DEFAULT NULL, tech5_desc LONGTEXT DEFAULT NULL, tech_special_nom VARCHAR(255) DEFAULT NULL, tech_special_desc LONGTEXT DEFAULT NULL, INDEX IDX_9786AAC8F5EA509 (classe_id), INDEX IDX_9786AACBEAF84C8 (clan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, clan_id INT DEFAULT NULL, classe_id INT NOT NULL, ecole_id INT DEFAULT NULL, joueur_id INT DEFAULT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, titres VARCHAR(255) DEFAULT NULL, icone VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, est_pj TINYINT(1) NOT NULL, INDEX IDX_6AEA486DBEAF84C8 (clan_id), INDEX IDX_6AEA486D8F5EA509 (classe_id), INDEX IDX_6AEA486D77EF1B1E (ecole_id), INDEX IDX_6AEA486DA9E2D76C (joueur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ecole ADD CONSTRAINT FK_9786AAC8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE ecole ADD CONSTRAINT FK_9786AACBEAF84C8 FOREIGN KEY (clan_id) REFERENCES clan (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DBEAF84C8 FOREIGN KEY (clan_id) REFERENCES clan (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D77EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DA9E2D76C FOREIGN KEY (joueur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecole DROP FOREIGN KEY FK_9786AACBEAF84C8');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486DBEAF84C8');
        $this->addSql('ALTER TABLE ecole DROP FOREIGN KEY FK_9786AAC8F5EA509');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D8F5EA509');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D77EF1B1E');
        $this->addSql('DROP TABLE clan');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE ecole');
        $this->addSql('DROP TABLE personnage');
    }
}
