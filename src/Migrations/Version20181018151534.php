<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181018151534 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE galery_image DROP FOREIGN KEY FK_2286070DA40A005');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FB62DE735');
        $this->addSql('DROP TABLE galery');
        $this->addSql('DROP TABLE galery_image');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE training_category');
        $this->addSql('DROP INDEX IDX_D5128A8FB62DE735 ON training');
        $this->addSql('ALTER TABLE training CHANGE training_category_id team_id INT NOT NULL');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5128A8F296CD8AE ON training (team_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE galery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, slug VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galery_image (galery_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_2286070DA40A005 (galery_id), INDEX IDX_22860703DA5256D (image_id), PRIMARY KEY(galery_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, match_date DATETIME DEFAULT NULL, location VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, opponent VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, winner VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, looser VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, winner_score INT DEFAULT NULL, looser_score INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE galery_image ADD CONSTRAINT FK_22860703DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE galery_image ADD CONSTRAINT FK_2286070DA40A005 FOREIGN KEY (galery_id) REFERENCES galery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F296CD8AE');
        $this->addSql('DROP INDEX UNIQ_D5128A8F296CD8AE ON training');
        $this->addSql('ALTER TABLE training CHANGE team_id training_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FB62DE735 FOREIGN KEY (training_category_id) REFERENCES training_category (id)');
        $this->addSql('CREATE INDEX IDX_D5128A8FB62DE735 ON training (training_category_id)');
    }
}
