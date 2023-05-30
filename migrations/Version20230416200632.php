<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416200632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anime (id INT AUTO_INCREMENT NOT NULL, title_id INT NOT NULL, license_id INT DEFAULT NULL, studio_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, synopsis LONGTEXT NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, canonical_title VARCHAR(255) NOT NULL, average_rating DOUBLE PRECISION NOT NULL, user_count INT NOT NULL, up_vote_count INT NOT NULL, start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', next_release DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', popularity_rank INT NOT NULL, rating_rank INT NOT NULL, age_rating VARCHAR(255) NOT NULL, age_rating_guide VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, episode_count INT NOT NULL, episode_length INT NOT NULL, total_length INT NOT NULL, youtube_video_id VARCHAR(255) NOT NULL, nsfw TINYINT(1) NOT NULL, show_type VARCHAR(255) NOT NULL, score DOUBLE PRECISION NOT NULL, favorite INT NOT NULL, UNIQUE INDEX UNIQ_13045942A9F87BD (title_id), INDEX IDX_13045942460F904B (license_id), INDEX IDX_13045942446F285F (studio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_genre (anime_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_EFF953C7794BBE89 (anime_id), INDEX IDX_EFF953C74296D31F (genre_id), PRIMARY KEY(anime_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_staff (anime_id INT NOT NULL, staff_id INT NOT NULL, INDEX IDX_2EC793AD794BBE89 (anime_id), INDEX IDX_2EC793ADD4D57CD (staff_id), PRIMARY KEY(anime_id, staff_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_streaming_link (anime_id INT NOT NULL, streaming_link_id INT NOT NULL, INDEX IDX_67128EFE794BBE89 (anime_id), INDEX IDX_67128EFE56D133E6 (streaming_link_id), PRIMARY KEY(anime_id, streaming_link_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_theme (anime_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_FBDC8737794BBE89 (anime_id), INDEX IDX_FBDC873759027487 (theme_id), PRIMARY KEY(anime_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cover_image (id INT AUTO_INCREMENT NOT NULL, anime_id INT DEFAULT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1CDF82CA794BBE89 (anime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, anime_id INT NOT NULL, title_id INT DEFAULT NULL, canonical_title VARCHAR(255) NOT NULL, season_number INT NOT NULL, number INT NOT NULL, synopsis LONGTEXT NOT NULL, airdate DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', length INT NOT NULL, INDEX IDX_DDAA1CDA794BBE89 (anime_id), UNIQUE INDEX UNIQ_DDAA1CDAA9F87BD (title_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, staff_id INT NOT NULL, anime_id INT NOT NULL, name_id INT NOT NULL, description LONGTEXT NOT NULL, role VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_2F57B37AD4D57CD (staff_id), INDEX IDX_2F57B37A794BBE89 (anime_id), UNIQUE INDEX UNIQ_2F57B37A71179CD6 (name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE figure_image (id INT AUTO_INCREMENT NOT NULL, figure_id INT DEFAULT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D71082665C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, total_media_count INT NOT NULL, slug VARCHAR(255) NOT NULL, nsfw TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `kahinaute` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_32F52D36E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE license (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music (id INT AUTO_INCREMENT NOT NULL, anime_id INT NOT NULL, composer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_CD52224A794BBE89 (anime_id), INDEX IDX_CD52224A7A8D2620 (composer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE name (id INT AUTO_INCREMENT NOT NULL, romaji VARCHAR(255) NOT NULL, english VARCHAR(255) NOT NULL, native VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notice (id INT AUTO_INCREMENT NOT NULL, anime_id INT NOT NULL, content VARCHAR(255) NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_480D45C2794BBE89 (anime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poster_image (id INT AUTO_INCREMENT NOT NULL, anime_id INT DEFAULT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_31B9AF9A794BBE89 (anime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, anime_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_6B71CBF4794BBE89 (anime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthday DATE NOT NULL, biography LONGTEXT DEFAULT NULL, role VARCHAR(255) NOT NULL, voice_actor TINYINT(1) NOT NULL, language VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming_link (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studio (id INT AUTO_INCREMENT NOT NULL, slogan VARCHAR(255) NOT NULL, head_office VARCHAR(255) NOT NULL, direction VARCHAR(255) NOT NULL, activity VARCHAR(255) NOT NULL, product VARCHAR(255) NOT NULL, parent_company VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thumbnail (id INT AUTO_INCREMENT NOT NULL, episode_id INT DEFAULT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C35726E6362B62A0 (episode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title (id INT AUTO_INCREMENT NOT NULL, en VARCHAR(255) DEFAULT NULL, en_jp VARCHAR(255) DEFAULT NULL, ja_jp VARCHAR(255) DEFAULT NULL, fr VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token LONGTEXT NOT NULL, created_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_5F37A13BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token_black_list (id INT AUTO_INCREMENT NOT NULL, token LONGTEXT NOT NULL, expiration_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_13045942A9F87BD FOREIGN KEY (title_id) REFERENCES title (id)');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_13045942460F904B FOREIGN KEY (license_id) REFERENCES license (id)');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_13045942446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('ALTER TABLE anime_genre ADD CONSTRAINT FK_EFF953C7794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_genre ADD CONSTRAINT FK_EFF953C74296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_staff ADD CONSTRAINT FK_2EC793AD794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_staff ADD CONSTRAINT FK_2EC793ADD4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_streaming_link ADD CONSTRAINT FK_67128EFE794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_streaming_link ADD CONSTRAINT FK_67128EFE56D133E6 FOREIGN KEY (streaming_link_id) REFERENCES streaming_link (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_theme ADD CONSTRAINT FK_FBDC8737794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_theme ADD CONSTRAINT FK_FBDC873759027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cover_image ADD CONSTRAINT FK_1CDF82CA794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAA9F87BD FOREIGN KEY (title_id) REFERENCES title (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AD4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A71179CD6 FOREIGN KEY (name_id) REFERENCES name (id)');
        $this->addSql('ALTER TABLE figure_image ADD CONSTRAINT FK_D71082665C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A7A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id)');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C2794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE poster_image ADD CONSTRAINT FK_31B9AF9A794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE thumbnail ADD CONSTRAINT FK_C35726E6362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_13045942A9F87BD');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_13045942460F904B');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_13045942446F285F');
        $this->addSql('ALTER TABLE anime_genre DROP FOREIGN KEY FK_EFF953C7794BBE89');
        $this->addSql('ALTER TABLE anime_genre DROP FOREIGN KEY FK_EFF953C74296D31F');
        $this->addSql('ALTER TABLE anime_staff DROP FOREIGN KEY FK_2EC793AD794BBE89');
        $this->addSql('ALTER TABLE anime_staff DROP FOREIGN KEY FK_2EC793ADD4D57CD');
        $this->addSql('ALTER TABLE anime_streaming_link DROP FOREIGN KEY FK_67128EFE794BBE89');
        $this->addSql('ALTER TABLE anime_streaming_link DROP FOREIGN KEY FK_67128EFE56D133E6');
        $this->addSql('ALTER TABLE anime_theme DROP FOREIGN KEY FK_FBDC8737794BBE89');
        $this->addSql('ALTER TABLE anime_theme DROP FOREIGN KEY FK_FBDC873759027487');
        $this->addSql('ALTER TABLE cover_image DROP FOREIGN KEY FK_1CDF82CA794BBE89');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA794BBE89');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAA9F87BD');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AD4D57CD');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A794BBE89');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A71179CD6');
        $this->addSql('ALTER TABLE figure_image DROP FOREIGN KEY FK_D71082665C011B5');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A794BBE89');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A7A8D2620');
        $this->addSql('ALTER TABLE notice DROP FOREIGN KEY FK_480D45C2794BBE89');
        $this->addSql('ALTER TABLE poster_image DROP FOREIGN KEY FK_31B9AF9A794BBE89');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4794BBE89');
        $this->addSql('ALTER TABLE thumbnail DROP FOREIGN KEY FK_C35726E6362B62A0');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BA76ED395');
        $this->addSql('DROP TABLE anime');
        $this->addSql('DROP TABLE anime_genre');
        $this->addSql('DROP TABLE anime_staff');
        $this->addSql('DROP TABLE anime_streaming_link');
        $this->addSql('DROP TABLE anime_theme');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE cover_image');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE figure_image');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE `kahinaute`');
        $this->addSql('DROP TABLE license');
        $this->addSql('DROP TABLE music');
        $this->addSql('DROP TABLE name');
        $this->addSql('DROP TABLE notice');
        $this->addSql('DROP TABLE poster_image');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE streaming_link');
        $this->addSql('DROP TABLE studio');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE thumbnail');
        $this->addSql('DROP TABLE title');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE token_black_list');
        $this->addSql('DROP TABLE `user`');
    }
}
