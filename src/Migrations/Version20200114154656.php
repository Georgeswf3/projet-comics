<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114154656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article_author (article_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_D7684F487294869C (article_id), INDEX IDX_D7684F48F675F31B (author_id), PRIMARY KEY(article_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_job (author_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_1A9F3474F675F31B (author_id), INDEX IDX_1A9F3474BE04EA9 (job_id), PRIMARY KEY(author_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor_fan_art (editor_id INT NOT NULL, fan_art_id INT NOT NULL, INDEX IDX_3E676D96995AC4C (editor_id), INDEX IDX_3E676D95970E6C8 (fan_art_id), PRIMARY KEY(editor_id, fan_art_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_author ADD CONSTRAINT FK_D7684F487294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_author ADD CONSTRAINT FK_D7684F48F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_job ADD CONSTRAINT FK_1A9F3474F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_job ADD CONSTRAINT FK_1A9F3474BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE editor_fan_art ADD CONSTRAINT FK_3E676D96995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE editor_fan_art ADD CONSTRAINT FK_3E676D95970E6C8 FOREIGN KEY (fan_art_id) REFERENCES fan_art (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE author_article');
        $this->addSql('DROP TABLE fan_art_editor');
        $this->addSql('DROP TABLE job_author');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE author_article (author_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_47009125F675F31B (author_id), INDEX IDX_470091257294869C (article_id), PRIMARY KEY(author_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE fan_art_editor (fan_art_id INT NOT NULL, editor_id INT NOT NULL, INDEX IDX_3C20FA475970E6C8 (fan_art_id), INDEX IDX_3C20FA476995AC4C (editor_id), PRIMARY KEY(fan_art_id, editor_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE job_author (job_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_EDABF549BE04EA9 (job_id), INDEX IDX_EDABF549F675F31B (author_id), PRIMARY KEY(job_id, author_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE author_article ADD CONSTRAINT FK_470091257294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_article ADD CONSTRAINT FK_47009125F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fan_art_editor ADD CONSTRAINT FK_3C20FA475970E6C8 FOREIGN KEY (fan_art_id) REFERENCES fan_art (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fan_art_editor ADD CONSTRAINT FK_3C20FA476995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_author ADD CONSTRAINT FK_EDABF549BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_author ADD CONSTRAINT FK_EDABF549F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE article_author');
        $this->addSql('DROP TABLE author_job');
        $this->addSql('DROP TABLE editor_fan_art');
    }
}
