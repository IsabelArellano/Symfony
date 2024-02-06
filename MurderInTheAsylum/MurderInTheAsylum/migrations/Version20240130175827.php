<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130175827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE passwords');
        $this->addSql('ALTER TABLE message CHANGE code_message code_message VARCHAR(20) NOT NULL, CHANGE body_message body_message VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE name_user name_user VARCHAR(45) DEFAULT NULL, CHANGE surname_user surname_user VARCHAR(45) DEFAULT NULL, CHANGE nickname_user nickname_user VARCHAR(45) DEFAULT NULL, CHANGE age_user age_user INT DEFAULT NULL, CHANGE phone_user phone_user INT DEFAULT NULL, CHANGE password password VARCHAR(100) DEFAULT NULL, CHANGE image_user image_user LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id_character INT AUTO_INCREMENT NOT NULL, name_character VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, description_character VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_character)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE passwords (id_password INT AUTO_INCREMENT NOT NULL, password_hash VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_password)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE Message CHANGE code_message code_message VARCHAR(20) DEFAULT \'NULL\', CHANGE body_message body_message VARCHAR(500) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE users CHANGE name_user name_user VARCHAR(45) DEFAULT \'NULL\', CHANGE surname_user surname_user VARCHAR(50) NOT NULL, CHANGE nickname_user nickname_user VARCHAR(50) NOT NULL, CHANGE age_user age_user INT NOT NULL, CHANGE phone_user phone_user INT NOT NULL, CHANGE password password VARCHAR(100) DEFAULT \'NULL\', CHANGE image_user image_user LONGBLOB NOT NULL');
    }
}
