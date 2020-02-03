<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123150431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, quantite INT NOT NULL, total_a_payer_ligne_commande NUMERIC(8, 2) NOT NULL, INDEX IDX_3170B74B82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande_plat (ligne_commande_id INT NOT NULL, plat_id INT NOT NULL, INDEX IDX_4037A285E10FEE63 (ligne_commande_id), INDEX IDX_4037A285D73DB560 (plat_id), PRIMARY KEY(ligne_commande_id, plat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_du_jour (id INT AUTO_INCREMENT NOT NULL, date_du_jour DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_adresse (client_id INT NOT NULL, adresse_id INT NOT NULL, INDEX IDX_91624C6B19EB6921 (client_id), INDEX IDX_91624C6B4DE7DC5C (adresse_id), PRIMARY KEY(client_id, adresse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, menu_du_jour_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, INDEX IDX_2038A2079379AAF0 (menu_du_jour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, code VARCHAR(5) NOT NULL, expire_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur_adresse (livreur_id INT NOT NULL, adresse_id INT NOT NULL, INDEX IDX_1D708A4CF8646701 (livreur_id), INDEX IDX_1D708A4C4DE7DC5C (adresse_id), PRIMARY KEY(livreur_id, adresse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, total_a_payer NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande_plat ADD CONSTRAINT FK_4037A285E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_commande_plat ADD CONSTRAINT FK_4037A285D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_adresse ADD CONSTRAINT FK_91624C6B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_adresse ADD CONSTRAINT FK_91624C6B4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2079379AAF0 FOREIGN KEY (menu_du_jour_id) REFERENCES menu_du_jour (id)');
        $this->addSql('ALTER TABLE livreur_adresse ADD CONSTRAINT FK_1D708A4CF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livreur_adresse ADD CONSTRAINT FK_1D708A4C4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_commande_plat DROP FOREIGN KEY FK_4037A285E10FEE63');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2079379AAF0');
        $this->addSql('ALTER TABLE client_adresse DROP FOREIGN KEY FK_91624C6B4DE7DC5C');
        $this->addSql('ALTER TABLE livreur_adresse DROP FOREIGN KEY FK_1D708A4C4DE7DC5C');
        $this->addSql('ALTER TABLE client_adresse DROP FOREIGN KEY FK_91624C6B19EB6921');
        $this->addSql('ALTER TABLE ligne_commande_plat DROP FOREIGN KEY FK_4037A285D73DB560');
        $this->addSql('ALTER TABLE livreur_adresse DROP FOREIGN KEY FK_1D708A4CF8646701');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP TABLE ligne_commande_plat');
        $this->addSql('DROP TABLE menu_du_jour');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_adresse');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE livreur_adresse');
        $this->addSql('DROP TABLE commande');
    }
}
