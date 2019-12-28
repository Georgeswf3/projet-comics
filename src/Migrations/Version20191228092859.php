<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191228092859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fan_art_editor (fan_art_id INT NOT NULL, editor_id INT NOT NULL, INDEX IDX_3C20FA475970E6C8 (fan_art_id), INDEX IDX_3C20FA476995AC4C (editor_id), PRIMARY KEY(fan_art_id, editor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fan_art_editor ADD CONSTRAINT FK_3C20FA475970E6C8 FOREIGN KEY (fan_art_id) REFERENCES fan_art (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fan_art_editor ADD CONSTRAINT FK_3C20FA476995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fan_art ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE fan_art ADD CONSTRAINT FK_BAA3C09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BAA3C09D86650F ON fan_art (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fan_art_editor');
        $this->addSql('ALTER TABLE fan_art DROP FOREIGN KEY FK_BAA3C09D86650F');
        $this->addSql('DROP INDEX IDX_BAA3C09D86650F ON fan_art');
        $this->addSql('ALTER TABLE fan_art DROP user_id_id');
    }
}
