<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913085101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nft_gallery (nft_id INT NOT NULL, gallery_id INT NOT NULL, INDEX IDX_4ED2AC12E813668D (nft_id), INDEX IDX_4ED2AC124E7AF8F (gallery_id), PRIMARY KEY(nft_id, gallery_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft_sub_category (nft_id INT NOT NULL, sub_category_id INT NOT NULL, INDEX IDX_8FB34E85E813668D (nft_id), INDEX IDX_8FB34E85F7BFE87C (sub_category_id), PRIMARY KEY(nft_id, sub_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nft_gallery ADD CONSTRAINT FK_4ED2AC12E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nft_gallery ADD CONSTRAINT FK_4ED2AC124E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nft_sub_category ADD CONSTRAINT FK_8FB34E85E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nft_sub_category ADD CONSTRAINT FK_8FB34E85F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_472B783AA76ED395 ON gallery (user_id)');
        $this->addSql('ALTER TABLE nft ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9C7463CA76ED395 ON nft (user_id)');
        $this->addSql('ALTER TABLE sub_category ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F79812469DE2 ON sub_category (category_id)');
        $this->addSql('ALTER TABLE user ADD adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498486F9AC ON user (adress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft_gallery DROP FOREIGN KEY FK_4ED2AC12E813668D');
        $this->addSql('ALTER TABLE nft_gallery DROP FOREIGN KEY FK_4ED2AC124E7AF8F');
        $this->addSql('ALTER TABLE nft_sub_category DROP FOREIGN KEY FK_8FB34E85E813668D');
        $this->addSql('ALTER TABLE nft_sub_category DROP FOREIGN KEY FK_8FB34E85F7BFE87C');
        $this->addSql('DROP TABLE nft_gallery');
        $this->addSql('DROP TABLE nft_sub_category');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AA76ED395');
        $this->addSql('DROP INDEX IDX_472B783AA76ED395 ON gallery');
        $this->addSql('ALTER TABLE gallery DROP user_id');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CA76ED395');
        $this->addSql('DROP INDEX IDX_D9C7463CA76ED395 ON nft');
        $this->addSql('ALTER TABLE nft DROP user_id');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('DROP INDEX IDX_BCE3F79812469DE2 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP category_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498486F9AC');
        $this->addSql('DROP INDEX IDX_8D93D6498486F9AC ON user');
        $this->addSql('ALTER TABLE user DROP adress_id');
    }
}
