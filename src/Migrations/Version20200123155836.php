<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123155836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE quantite_livreur_menu_du_jour');
        $this->addSql('ALTER TABLE plat CHANGE menu_du_jour_id menu_du_jour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE livreur CHANGE position position VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quantite_livreur_menu_du_jour (quantite_livreur_id INT NOT NULL, menu_du_jour_id INT NOT NULL, INDEX IDX_E1F6BC5921891EF6 (quantite_livreur_id), INDEX IDX_E1F6BC599379AAF0 (menu_du_jour_id), PRIMARY KEY(quantite_livreur_id, menu_du_jour_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quantite_livreur_menu_du_jour ADD CONSTRAINT FK_E1F6BC5921891EF6 FOREIGN KEY (quantite_livreur_id) REFERENCES quantite_livreur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quantite_livreur_menu_du_jour ADD CONSTRAINT FK_E1F6BC599379AAF0 FOREIGN KEY (menu_du_jour_id) REFERENCES menu_du_jour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livreur CHANGE position position VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE plat CHANGE menu_du_jour_id menu_du_jour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
