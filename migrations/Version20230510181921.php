<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510181921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anime_anime (anime_source INT NOT NULL, anime_target INT NOT NULL, INDEX IDX_7FAD397DE980FB2E (anime_source), INDEX IDX_7FAD397DF065ABA1 (anime_target), PRIMARY KEY(anime_source, anime_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anime_anime ADD CONSTRAINT FK_7FAD397DE980FB2E FOREIGN KEY (anime_source) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_anime ADD CONSTRAINT FK_7FAD397DF065ABA1 FOREIGN KEY (anime_target) REFERENCES anime (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime_anime DROP FOREIGN KEY FK_7FAD397DE980FB2E');
        $this->addSql('ALTER TABLE anime_anime DROP FOREIGN KEY FK_7FAD397DF065ABA1');
        $this->addSql('DROP TABLE anime_anime');
    }
}
