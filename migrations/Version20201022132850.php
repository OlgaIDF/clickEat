<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201022132850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus ADD restaurant_id INT NOT NULL');
        $this->addSql('ALTER TABLE menus ADD CONSTRAINT FK_727508CFB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('CREATE INDEX IDX_727508CFB1E7706E ON menus (restaurant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus DROP FOREIGN KEY FK_727508CFB1E7706E');
        $this->addSql('DROP INDEX IDX_727508CFB1E7706E ON menus');
        $this->addSql('ALTER TABLE menus DROP restaurant_id');
    }
}
