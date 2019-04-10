<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410161259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE modification ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D24584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_EF6425D24584665A ON modification (product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4A605127');
        $this->addSql('DROP INDEX IDX_D34A04AD4A605127 ON product');
        $this->addSql('ALTER TABLE product DROP modification_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D24584665A');
        $this->addSql('DROP INDEX IDX_EF6425D24584665A ON modification');
        $this->addSql('ALTER TABLE modification DROP product_id');
        $this->addSql('ALTER TABLE product ADD modification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4A605127 FOREIGN KEY (modification_id) REFERENCES modification (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4A605127 ON product (modification_id)');
    }
}
