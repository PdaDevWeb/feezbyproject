<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190527065913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE third_postal_code (third_id INT NOT NULL, postal_code_id INT NOT NULL, INDEX IDX_AAF6088274CCD3CA (third_id), INDEX IDX_AAF60882BDBA6A61 (postal_code_id), PRIMARY KEY(third_id, postal_code_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE third_postal_code ADD CONSTRAINT FK_AAF6088274CCD3CA FOREIGN KEY (third_id) REFERENCES third (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE third_postal_code ADD CONSTRAINT FK_AAF60882BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE third_postal_code');
    }
}
