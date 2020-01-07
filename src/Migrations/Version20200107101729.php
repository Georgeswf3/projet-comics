<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107101729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, article_title VARCHAR(255) NOT NULL, article_text LONGTEXT NOT NULL, article_date DATETIME NOT NULL, is_confirmed TINYINT(1) NOT NULL, INDEX IDX_23A0E66A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, author_name VARCHAR(100) NOT NULL, author_first_name VARCHAR(100) NOT NULL, facebook_page VARCHAR(100) DEFAULT NULL, author_image VARCHAR(255) DEFAULT NULL, creation_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_article (author_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_47009125F675F31B (author_id), INDEX IDX_470091257294869C (article_id), PRIMARY KEY(author_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, article_id INT DEFAULT NULL, fan_art_id INT DEFAULT NULL, comment_article LONGTEXT DEFAULT NULL, comment_fan_art LONGTEXT DEFAULT NULL, is_confirmed TINYINT(1) NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C7294869C (article_id), INDEX IDX_9474526C5970E6C8 (fan_art_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, editor_brand VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fan_art (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, user_id INT NOT NULL, fan_art_title VARCHAR(255) NOT NULL, fan_art_hook VARCHAR(255) DEFAULT NULL, fan_art_sketch VARCHAR(255) NOT NULL, is_confirmed TINYINT(1) NOT NULL, INDEX IDX_BAA3C0F675F31B (author_id), INDEX IDX_BAA3C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fan_art_editor (fan_art_id INT NOT NULL, editor_id INT NOT NULL, INDEX IDX_3C20FA475970E6C8 (fan_art_id), INDEX IDX_3C20FA476995AC4C (editor_id), PRIMARY KEY(fan_art_id, editor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, job_writer TINYINT(1) NOT NULL, job_penciler TINYINT(1) NOT NULL, job_inker TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_author (job_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_EDABF549BE04EA9 (job_id), INDEX IDX_EDABF549F675F31B (author_id), PRIMARY KEY(job_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(40) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, avatar_image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE author_article ADD CONSTRAINT FK_47009125F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_article ADD CONSTRAINT FK_470091257294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5970E6C8 FOREIGN KEY (fan_art_id) REFERENCES fan_art (id)');
        $this->addSql('ALTER TABLE fan_art ADD CONSTRAINT FK_BAA3C0F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE fan_art ADD CONSTRAINT FK_BAA3C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fan_art_editor ADD CONSTRAINT FK_3C20FA475970E6C8 FOREIGN KEY (fan_art_id) REFERENCES fan_art (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fan_art_editor ADD CONSTRAINT FK_3C20FA476995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_author ADD CONSTRAINT FK_EDABF549BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_author ADD CONSTRAINT FK_EDABF549F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author_article DROP FOREIGN KEY FK_470091257294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE author_article DROP FOREIGN KEY FK_47009125F675F31B');
        $this->addSql('ALTER TABLE fan_art DROP FOREIGN KEY FK_BAA3C0F675F31B');
        $this->addSql('ALTER TABLE job_author DROP FOREIGN KEY FK_EDABF549F675F31B');
        $this->addSql('ALTER TABLE fan_art_editor DROP FOREIGN KEY FK_3C20FA476995AC4C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5970E6C8');
        $this->addSql('ALTER TABLE fan_art_editor DROP FOREIGN KEY FK_3C20FA475970E6C8');
        $this->addSql('ALTER TABLE job_author DROP FOREIGN KEY FK_EDABF549BE04EA9');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE fan_art DROP FOREIGN KEY FK_BAA3C0A76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_article');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE fan_art');
        $this->addSql('DROP TABLE fan_art_editor');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE job_author');
        $this->addSql('DROP TABLE user');
    }
}
