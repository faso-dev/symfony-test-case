<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123162004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quantite_livreur ADD plat_id INT NOT NULL');
        $this->addSql('ALTER TABLE quantite_livreur ADD CONSTRAINT FK_523A360DD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id)');
        $this->addSql('CREATE INDEX IDX_523A360DD73DB560 ON quantite_livreur (plat_id)');
        $this->addSql('ALTER TABLE plat CHANGE menu_du_jour_id menu_du_jour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE livreur CHANGE position position VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livreur CHANGE position position VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE plat CHANGE menu_du_jour_id menu_du_jour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite_livreur DROP FOREIGN KEY FK_523A360DD73DB560');
        $this->addSql('DROP INDEX IDX_523A360DD73DB560 ON quantite_livreur');
        $this->addSql('ALTER TABLE quantite_livreur DROP plat_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
