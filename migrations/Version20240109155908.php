<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109155908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_ref_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE borrow_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE library_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, library_id_id INT NOT NULL, book_ref_id_id INT NOT NULL, status VARCHAR(50) NOT NULL, state VARCHAR(50) NOT NULL, language VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A3314CE14C78 ON book (library_id_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3311E21EDD3 ON book (book_ref_id_id)');
        $this->addSql('CREATE TABLE book_ref (id INT NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, genre VARCHAR(60) NOT NULL, publication_date DATE DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, isbn VARCHAR(255) NOT NULL, edition VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE borrow (id INT NOT NULL, user_id_id INT NOT NULL, book_id_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, due_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55DBA8B09D86650F ON borrow (user_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55DBA8B071868B2E ON borrow (book_id_id)');
        $this->addSql('COMMENT ON COLUMN borrow.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE library (id INT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip VARCHAR(15) NOT NULL, phone VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, user_id_id INT NOT NULL, book_ref_id_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C849559D86650F ON reservation (user_id_id)');
        $this->addSql('CREATE INDEX IDX_42C849551E21EDD3 ON reservation (book_ref_id_id)');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, book_ref_id_id INT DEFAULT NULL, user_id_id INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, rating DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_boosted BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C61E21EDD3 ON review (book_ref_id_id)');
        $this->addSql('CREATE INDEX IDX_794381C69D86650F ON review (user_id_id)');
        $this->addSql('COMMENT ON COLUMN review.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, library_id_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, phone VARCHAR(15) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D6494CE14C78 ON "user" (library_id_id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314CE14C78 FOREIGN KEY (library_id_id) REFERENCES library (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311E21EDD3 FOREIGN KEY (book_ref_id_id) REFERENCES book_ref (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B09D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B071868B2E FOREIGN KEY (book_id_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551E21EDD3 FOREIGN KEY (book_ref_id_id) REFERENCES book_ref (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C61E21EDD3 FOREIGN KEY (book_ref_id_id) REFERENCES book_ref (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C69D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6494CE14C78 FOREIGN KEY (library_id_id) REFERENCES library (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_ref_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE borrow_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE library_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3314CE14C78');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3311E21EDD3');
        $this->addSql('ALTER TABLE borrow DROP CONSTRAINT FK_55DBA8B09D86650F');
        $this->addSql('ALTER TABLE borrow DROP CONSTRAINT FK_55DBA8B071868B2E');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C849559D86650F');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C849551E21EDD3');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C61E21EDD3');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C69D86650F');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6494CE14C78');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_ref');
        $this->addSql('DROP TABLE borrow');
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE "user"');
    }
}
