<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011164933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chapitre (id INT AUTO_INCREMENT NOT NULL, saison_parent_id INT NOT NULL, numero INT NOT NULL, titre VARCHAR(255) NOT NULL, citation VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, couleur VARCHAR(7) NOT NULL, INDEX IDX_8C62B025406DFFCA (saison_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, chapitre_parent_id INT NOT NULL, numero INT NOT NULL, titre VARCHAR(255) NOT NULL, resume VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_DDAA1CDA38E4424 (chapitre_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saison (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, couleur VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scene (id INT AUTO_INCREMENT NOT NULL, episode_parent_id INT NOT NULL, numero SMALLINT NOT NULL, titre VARCHAR(255) NOT NULL, temps VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_D979EFDACCB85C49 (episode_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B025406DFFCA FOREIGN KEY (saison_parent_id) REFERENCES saison (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA38E4424 FOREIGN KEY (chapitre_parent_id) REFERENCES chapitre (id)');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDACCB85C49 FOREIGN KEY (episode_parent_id) REFERENCES episode (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA38E4424');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDACCB85C49');
        $this->addSql('ALTER TABLE chapitre DROP FOREIGN KEY FK_8C62B025406DFFCA');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE saison');
        $this->addSql('DROP TABLE scene');
    }
}
