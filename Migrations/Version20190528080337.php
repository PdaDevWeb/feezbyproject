<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528080337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE deliver (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, assignment_date DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_56BD90B4A76ED395 (user_id), INDEX IDX_56BD90B4ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picker (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, assignment_date DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_E5524A80A76ED395 (user_id), INDEX IDX_E5524A80ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deliver ADD CONSTRAINT FK_56BD90B4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE deliver ADD CONSTRAINT FK_56BD90B4ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE picker ADD CONSTRAINT FK_E5524A80A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picker ADD CONSTRAINT FK_E5524A80ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('DROP TABLE service_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_user (service_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_43D062A5ED5CA9E6 (service_id), INDEX IDX_43D062A5A76ED395 (user_id), PRIMARY KEY(service_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service_user ADD CONSTRAINT FK_43D062A5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_user ADD CONSTRAINT FK_43D062A5ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE deliver');
        $this->addSql('DROP TABLE picker');
    }
}
