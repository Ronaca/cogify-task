<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213174627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_4A1B2A92CC1CF4E6 ON books');
        $this->addSql('DROP INDEX `primary` ON books');
        $this->addSql('ALTER TABLE books DROP id');
        $this->addSql('ALTER TABLE books ADD PRIMARY KEY (isbn)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4A1B2A92CC1CF4E6 ON books (isbn)');
    }
}
