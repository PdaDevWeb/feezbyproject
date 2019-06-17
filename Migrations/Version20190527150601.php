<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190527150601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service ADD third_order_id INT NOT NULL, ADD third_shipper_id INT DEFAULT NULL, ADD third_receiver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2F86769FD FOREIGN KEY (third_order_id) REFERENCES third (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD289A50DC9 FOREIGN KEY (third_shipper_id) REFERENCES third (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD28D3D0642 FOREIGN KEY (third_receiver_id) REFERENCES third (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2F86769FD ON service (third_order_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD289A50DC9 ON service (third_shipper_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD28D3D0642 ON service (third_receiver_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2F86769FD');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD289A50DC9');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD28D3D0642');
        $this->addSql('DROP INDEX IDX_E19D9AD2F86769FD ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD289A50DC9 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD28D3D0642 ON service');
        $this->addSql('ALTER TABLE service DROP third_order_id, DROP third_shipper_id, DROP third_receiver_id');
    }
}
