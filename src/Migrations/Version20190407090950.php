<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190407090950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346684584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_3AF346684584665A ON categories (product_id)');
        $this->addSql('ALTER TABLE tag ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7834584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_389B7834584665A ON tag (product_id)');
        $this->addSql('ALTER TABLE review ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_794381C64584665A ON review (product_id)');
        $this->addSql('ALTER TABLE related_products ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE related_products ADD CONSTRAINT FK_153914F74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_153914F74584665A ON related_products (product_id)');
        $this->addSql('ALTER TABLE rating ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926224584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_D88926224584665A ON rating (product_id)');
        $this->addSql('ALTER TABLE product ADD title TINYTEXT NOT NULL, ADD description LONGTEXT NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD created_at INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346684584665A');
        $this->addSql('DROP INDEX IDX_3AF346684584665A ON categories');
        $this->addSql('ALTER TABLE categories DROP product_id');
        $this->addSql('ALTER TABLE product DROP title, DROP description, DROP price, DROP created_at');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926224584665A');
        $this->addSql('DROP INDEX IDX_D88926224584665A ON rating');
        $this->addSql('ALTER TABLE rating DROP product_id');
        $this->addSql('ALTER TABLE related_products DROP FOREIGN KEY FK_153914F74584665A');
        $this->addSql('DROP INDEX IDX_153914F74584665A ON related_products');
        $this->addSql('ALTER TABLE related_products DROP product_id');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('DROP INDEX IDX_794381C64584665A ON review');
        $this->addSql('ALTER TABLE review DROP product_id');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7834584665A');
        $this->addSql('DROP INDEX IDX_389B7834584665A ON tag');
        $this->addSql('ALTER TABLE tag DROP product_id');
    }
}
