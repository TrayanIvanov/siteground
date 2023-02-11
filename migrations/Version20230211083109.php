<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211083109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert product and promotions records.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO products VALUES ("1", "A", "Lemon", "50")');
        $this->addSql('INSERT INTO products VALUES ("2", "B", "Banana", "30")');
        $this->addSql('INSERT INTO products VALUES ("3", "C", "Watermelon", "20")');
        $this->addSql('INSERT INTO products VALUES ("4", "D", "Apple", "10")');
        $this->addSql('INSERT INTO promotions VALUES ("1", "1", "3", "130")');
        $this->addSql('INSERT INTO promotions VALUES ("2", "2", "2", "45")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('SET FOREIGN_KEY_CHECKS = 0');
        $this->addSql('TRUNCATE promotions');
        $this->addSql('TRUNCATE products');
        $this->addSql('SET FOREIGN_KEY_CHECKS = 1');
    }
}
