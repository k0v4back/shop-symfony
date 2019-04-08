<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408135535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_14B784184584665A ON photo (product_id)');
        $this->addSql('ALTER TABLE related_products ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE related_products ADD CONSTRAINT FK_153914F74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_153914F74584665A ON related_products (product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7E9E4C8C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA761FF2D');
        $this->addSql('DROP INDEX IDX_D34A04AD7E9E4C8C ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADA761FF2D ON product');
        $this->addSql('ALTER TABLE product DROP photo_id, DROP related_products_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184584665A');
        $this->addSql('DROP INDEX IDX_14B784184584665A ON photo');
        $this->addSql('ALTER TABLE photo DROP product_id');
        $this->addSql('ALTER TABLE product ADD photo_id INT DEFAULT NULL, ADD related_products_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA761FF2D FOREIGN KEY (related_products_id) REFERENCES related_products (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7E9E4C8C ON product (photo_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA761FF2D ON product (related_products_id)');
        $this->addSql('ALTER TABLE related_products DROP FOREIGN KEY FK_153914F74584665A');
        $this->addSql('DROP INDEX IDX_153914F74584665A ON related_products');
        $this->addSql('ALTER TABLE related_products DROP product_id');
    }
}
