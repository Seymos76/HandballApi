<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181004190749 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `match`');
        $this->addSql('ALTER TABLE player ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A653DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A653DA5256D ON player (image_id)');
        $this->addSql('ALTER TABLE team ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4E0A61F3DA5256D ON team (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, match_date DATETIME DEFAULT NULL, location VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, opponent VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, winner VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, looser VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, winner_score INT DEFAULT NULL, looser_score INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A653DA5256D');
        $this->addSql('DROP INDEX UNIQ_98197A653DA5256D ON player');
        $this->addSql('ALTER TABLE player DROP image_id');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3DA5256D');
        $this->addSql('DROP INDEX UNIQ_C4E0A61F3DA5256D ON team');
        $this->addSql('ALTER TABLE team DROP image_id');
    }
}
