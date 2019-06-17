<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190612150942 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE delivery_state (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pickup_state (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD pickup_state_id INT DEFAULT NULL, ADD delivery_state_id INT DEFAULT NULL, ADD pickup_comment VARCHAR(255) DEFAULT NULL, ADD pickup_signer_name VARCHAR(255) DEFAULT NULL, ADD delivery_comment VARCHAR(255) DEFAULT NULL, ADD delivery_signer_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2ADD0C192 FOREIGN KEY (pickup_state_id) REFERENCES pickup_state (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD264B9DDAD FOREIGN KEY (delivery_state_id) REFERENCES delivery_state (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2ADD0C192 ON service (pickup_state_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD264B9DDAD ON service (delivery_state_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD264B9DDAD');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2ADD0C192');
        $this->addSql('DROP TABLE delivery_state');
        $this->addSql('DROP TABLE pickup_state');
        $this->addSql('DROP INDEX IDX_E19D9AD2ADD0C192 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD264B9DDAD ON service');
        $this->addSql('ALTER TABLE service DROP pickup_state_id, DROP delivery_state_id, DROP pickup_comment, DROP pickup_signer_name, DROP delivery_comment, DROP delivery_signer_name');
    }
}
