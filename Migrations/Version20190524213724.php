<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190524213724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE postal_code (id INT AUTO_INCREMENT NOT NULL, dept_code VARCHAR(2) NOT NULL, dept_name VARCHAR(255) NOT NULL, suburban VARCHAR(255) DEFAULT NULL, city_postal_code VARCHAR(5) NOT NULL, city_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, service_category_id INT NOT NULL, expected_pickup_date DATETIME DEFAULT NULL, real_pickup_date DATETIME DEFAULT NULL, expected_delivery_date DATETIME DEFAULT NULL, real_delivery_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_E19D9AD2DEDCBB4E (service_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_third (service_id INT NOT NULL, third_id INT NOT NULL, INDEX IDX_8D40CD83ED5CA9E6 (service_id), INDEX IDX_8D40CD8374CCD3CA (third_id), PRIMARY KEY(service_id, third_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_user (service_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_43D062A5ED5CA9E6 (service_id), INDEX IDX_43D062A5A76ED395 (user_id), PRIMARY KEY(service_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_third_category (service_id INT NOT NULL, third_category_id INT NOT NULL, INDEX IDX_70D240B2ED5CA9E6 (service_id), INDEX IDX_70D240B252287616 (third_category_id), PRIMARY KEY(service_id, third_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE third (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE third_postal_code (third_id INT NOT NULL, postal_code_id INT NOT NULL, INDEX IDX_AAF6088274CCD3CA (third_id), INDEX IDX_AAF60882BDBA6A61 (postal_code_id), PRIMARY KEY(third_id, postal_code_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE third_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) NOT NULL, phone VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2DEDCBB4E FOREIGN KEY (service_category_id) REFERENCES service_category (id)');
        $this->addSql('ALTER TABLE service_third ADD CONSTRAINT FK_8D40CD83ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_third ADD CONSTRAINT FK_8D40CD8374CCD3CA FOREIGN KEY (third_id) REFERENCES third (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_user ADD CONSTRAINT FK_43D062A5ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_user ADD CONSTRAINT FK_43D062A5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_third_category ADD CONSTRAINT FK_70D240B2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_third_category ADD CONSTRAINT FK_70D240B252287616 FOREIGN KEY (third_category_id) REFERENCES third_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE third_postal_code ADD CONSTRAINT FK_AAF6088274CCD3CA FOREIGN KEY (third_id) REFERENCES third (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE third_postal_code ADD CONSTRAINT FK_AAF60882BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE third_postal_code DROP FOREIGN KEY FK_AAF60882BDBA6A61');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE service_third DROP FOREIGN KEY FK_8D40CD83ED5CA9E6');
        $this->addSql('ALTER TABLE service_user DROP FOREIGN KEY FK_43D062A5ED5CA9E6');
        $this->addSql('ALTER TABLE service_third_category DROP FOREIGN KEY FK_70D240B2ED5CA9E6');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2DEDCBB4E');
        $this->addSql('ALTER TABLE service_third DROP FOREIGN KEY FK_8D40CD8374CCD3CA');
        $this->addSql('ALTER TABLE third_postal_code DROP FOREIGN KEY FK_AAF6088274CCD3CA');
        $this->addSql('ALTER TABLE service_third_category DROP FOREIGN KEY FK_70D240B252287616');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('ALTER TABLE service_user DROP FOREIGN KEY FK_43D062A5A76ED395');
        $this->addSql('DROP TABLE postal_code');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_third');
        $this->addSql('DROP TABLE service_user');
        $this->addSql('DROP TABLE service_third_category');
        $this->addSql('DROP TABLE service_category');
        $this->addSql('DROP TABLE third');
        $this->addSql('DROP TABLE third_postal_code');
        $this->addSql('DROP TABLE third_category');
        $this->addSql('DROP TABLE user');
    }
}
