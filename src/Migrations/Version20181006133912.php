<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181006133912 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('ALTER TABLE image ADD slide_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FDD5AFB87 FOREIGN KEY (slide_id) REFERENCES slide (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FDD5AFB87 ON image (slide_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FDD5AFB87');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, match_date DATETIME DEFAULT NULL, location VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, opponent VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, winner VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, looser VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, winner_score INT DEFAULT NULL, looser_score INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP INDEX IDX_C53D045FDD5AFB87 ON image');
        $this->addSql('ALTER TABLE image DROP slide_id');
    }
}
