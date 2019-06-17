<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190529110449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE owner_historic (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, created_at DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, comment_auto VARCHAR(255) NOT NULL, INDEX IDX_BBB25695A76ED395 (user_id), INDEX IDX_BBB25695ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owner_historic ADD CONSTRAINT FK_BBB25695A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE owner_historic ADD CONSTRAINT FK_BBB25695ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service ADD user_picker_id INT DEFAULT NULL, ADD user_deliver_id INT DEFAULT NULL, ADD user_owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2867C4E6 FOREIGN KEY (user_picker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2C7E0106D FOREIGN KEY (user_deliver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD29EB185F9 FOREIGN KEY (user_owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2867C4E6 ON service (user_picker_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2C7E0106D ON service (user_deliver_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD29EB185F9 ON service (user_owner_id)');
        $this->addSql('ALTER TABLE third ADD CONSTRAINT FK_24322064BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id)');
        $this->addSql('CREATE INDEX IDX_24322064BDBA6A61 ON third (postal_code_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE owner_historic');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2867C4E6');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2C7E0106D');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD29EB185F9');
        $this->addSql('DROP INDEX IDX_E19D9AD2867C4E6 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD2C7E0106D ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD29EB185F9 ON service');
        $this->addSql('ALTER TABLE service DROP user_picker_id, DROP user_deliver_id, DROP user_owner_id');
        $this->addSql('ALTER TABLE third DROP FOREIGN KEY FK_24322064BDBA6A61');
        $this->addSql('DROP INDEX IDX_24322064BDBA6A61 ON third');
    }
}
