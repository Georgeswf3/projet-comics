<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107085040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8F3EC46');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA1DC27C7');
        $this->addSql('DROP INDEX IDX_9474526C8F3EC46 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('DROP INDEX IDX_9474526CA1DC27C7 ON comment');
        $this->addSql('ALTER TABLE comment ADD article_id INT DEFAULT NULL, ADD fan_art_id INT DEFAULT NULL, DROP article_id_id, DROP fan_art_id_id, CHANGE comment_article comment_article LONGTEXT DEFAULT NULL, CHANGE comment_fan_art comment_fan_art LONGTEXT DEFAULT NULL, CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5970E6C8 FOREIGN KEY (fan_art_id) REFERENCES fan_art (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5970E6C8 ON comment (fan_art_id)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669D86650F');
        $this->addSql('DROP INDEX IDX_23A0E669D86650F ON article');
        $this->addSql('ALTER TABLE article CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('ALTER TABLE fan_art DROP FOREIGN KEY FK_BAA3C09D86650F');
        $this->addSql('DROP INDEX IDX_BAA3C09D86650F ON fan_art');
        $this->addSql('ALTER TABLE fan_art CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE fan_art ADD CONSTRAINT FK_BAA3C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BAA3C0A76ED395 ON fan_art (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('DROP INDEX IDX_23A0E66A76ED395 ON article');
        $this->addSql('ALTER TABLE article CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E669D86650F ON article (user_id_id)');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5970E6C8');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C7294869C ON comment');
        $this->addSql('DROP INDEX IDX_9474526C5970E6C8 ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id_id INT DEFAULT NULL, ADD article_id_id INT NOT NULL, ADD fan_art_id_id INT NOT NULL, DROP user_id, DROP article_id, DROP fan_art_id, CHANGE comment_article comment_article LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comment_fan_art comment_fan_art LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA1DC27C7 FOREIGN KEY (fan_art_id_id) REFERENCES fan_art (id)');
        $this->addSql('CREATE INDEX IDX_9474526C8F3EC46 ON comment (article_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA1DC27C7 ON comment (fan_art_id_id)');
        $this->addSql('ALTER TABLE fan_art DROP FOREIGN KEY FK_BAA3C0A76ED395');
        $this->addSql('DROP INDEX IDX_BAA3C0A76ED395 ON fan_art');
        $this->addSql('ALTER TABLE fan_art CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE fan_art ADD CONSTRAINT FK_BAA3C09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BAA3C09D86650F ON fan_art (user_id_id)');
    }
}
