<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408135218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE related_products (id INT AUTO_INCREMENT NOT NULL, related_product_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE review ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_794381C64584665A ON review (product_id)');
        $this->addSql('ALTER TABLE product ADD photo_id INT DEFAULT NULL, ADD modification_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD tag_id INT DEFAULT NULL, ADD related_products_id INT DEFAULT NULL, ADD rating_id INT DEFAULT NULL, ADD title TINYTEXT NOT NULL, ADD description LONGTEXT NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD created_at INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4A605127 FOREIGN KEY (modification_id) REFERENCES modification (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA761FF2D FOREIGN KEY (related_products_id) REFERENCES related_products (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA32EFC6 FOREIGN KEY (rating_id) REFERENCES rating (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7E9E4C8C ON product (photo_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4A605127 ON product (modification_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADBAD26311 ON product (tag_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA761FF2D ON product (related_products_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA32EFC6 ON product (rating_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA761FF2D');
        $this->addSql('DROP TABLE related_products');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7E9E4C8C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4A605127');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBAD26311');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA32EFC6');
        $this->addSql('DROP INDEX IDX_D34A04AD7E9E4C8C ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD4A605127 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADBAD26311 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADA761FF2D ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADA32EFC6 ON product');
        $this->addSql('ALTER TABLE product DROP photo_id, DROP modification_id, DROP category_id, DROP tag_id, DROP related_products_id, DROP rating_id, DROP title, DROP description, DROP price, DROP created_at');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('DROP INDEX IDX_794381C64584665A ON review');
        $this->addSql('ALTER TABLE review DROP product_id');
    }
}
