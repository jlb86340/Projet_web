<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328071527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, quant_stock INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(200) NOT NULL, surname VARCHAR(200) NOT NULL, birthdate DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
    }
}
