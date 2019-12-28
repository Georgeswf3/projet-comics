<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191228092418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment ADD user_id_id INT DEFAULT NULL, ADD article_id_id INT NOT NULL, ADD fan_art_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA1DC27C7 FOREIGN KEY (fan_art_id_id) REFERENCES fan_art (id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C8F3EC46 ON comment (article_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA1DC27C7 ON comment (fan_art_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8F3EC46');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA1DC27C7');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('DROP INDEX IDX_9474526C8F3EC46 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CA1DC27C7 ON comment');
        $this->addSql('ALTER TABLE comment DROP user_id_id, DROP article_id_id, DROP fan_art_id_id');
    }
}
