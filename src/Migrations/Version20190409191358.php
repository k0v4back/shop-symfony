<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190409191358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rating ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926224584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D88926224584665A ON rating (product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA32EFC6');
        $this->addSql('DROP INDEX IDX_D34A04ADA32EFC6 ON product');
        $this->addSql('ALTER TABLE product DROP rating_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD rating_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA32EFC6 FOREIGN KEY (rating_id) REFERENCES rating (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA32EFC6 ON product (rating_id)');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926224584665A');
        $this->addSql('DROP INDEX UNIQ_D88926224584665A ON rating');
        $this->addSql('ALTER TABLE rating DROP product_id');
    }
}
