<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190407084437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_14B784184584665A ON photo (product_id)');
        $this->addSql('ALTER TABLE tag DROP product_id');
        $this->addSql('ALTER TABLE modification DROP product_id');
        $this->addSql('ALTER TABLE related_products DROP product_id');
        $this->addSql('ALTER TABLE rating DROP product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184584665A');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE modification ADD product_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_14B784184584665A ON photo');
        $this->addSql('ALTER TABLE photo CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE rating ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE related_products ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE tag ADD product_id INT NOT NULL');
    }
}
