<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250124221157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_jeu (event_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_932B486671F7E88B (event_id), INDEX IDX_932B48668C9E392E (jeu_id), PRIMARY KEY(event_id, jeu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_jeu ADD CONSTRAINT FK_932B486671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_jeu ADD CONSTRAINT FK_932B48668C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE jeu_de_carte');
        $this->addSql('DROP TABLE jeu_de_duel');
        $this->addSql('DROP TABLE jeu_de_plateau');
        $this->addSql('ALTER TABLE jeu ADD type VARCHAR(255) NOT NULL, ADD nb_carte INT DEFAULT NULL, ADD ressource LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeu_de_carte (id INT AUTO_INCREMENT NOT NULL, nb_carte INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE jeu_de_duel (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE jeu_de_plateau (id INT AUTO_INCREMENT NOT NULL, ressource LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event_jeu DROP FOREIGN KEY FK_932B486671F7E88B');
        $this->addSql('ALTER TABLE event_jeu DROP FOREIGN KEY FK_932B48668C9E392E');
        $this->addSql('DROP TABLE event_jeu');
        $this->addSql('ALTER TABLE jeu DROP type, DROP nb_carte, DROP ressource');
    }
}
