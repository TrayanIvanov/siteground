<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211232958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, total INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt_item (id INT AUTO_INCREMENT NOT NULL, receipt_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, total INT NOT NULL, INDEX IDX_89601E922B5CA896 (receipt_id), INDEX IDX_89601E924584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE receipt_item ADD CONSTRAINT FK_89601E922B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
        $this->addSql('ALTER TABLE receipt_item ADD CONSTRAINT FK_89601E924584665A FOREIGN KEY (product_id) REFERENCES products (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receipt_item DROP FOREIGN KEY FK_89601E922B5CA896');
        $this->addSql('ALTER TABLE receipt_item DROP FOREIGN KEY FK_89601E924584665A');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE receipt_item');
    }
}
