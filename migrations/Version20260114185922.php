<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260114185922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients DROP CONSTRAINT fk_4b60114f9d86650f');
        $this->addSql('ALTER TABLE menus DROP CONSTRAINT fk_727508cf9d86650f');
        $this->addSql('ALTER TABLE chef_settings DROP CONSTRAINT fk_42e555a29d86650f');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT fk_b338d8d19d86650f');
        $this->addSql('ALTER TABLE recipes DROP CONSTRAINT fk_a369e2b59d86650f');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE TABLE app_user (id SERIAL NOT NULL, email VARCHAR(320) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN app_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP INDEX uniq_42e555a29d86650f');
        $this->addSql('ALTER TABLE chef_settings ALTER tva_rate TYPE VARCHAR(10)');
        $this->addSql('ALTER TABLE chef_settings RENAME COLUMN user_id_id TO user_id');
        $this->addSql('COMMENT ON COLUMN chef_settings.tva_rate IS \'(DC2Type:taxe_enum)\'');
        $this->addSql('ALTER TABLE chef_settings ADD CONSTRAINT FK_42E555A2A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42E555A2A76ED395 ON chef_settings (user_id)');
        $this->addSql('ALTER TABLE ingredients DROP CONSTRAINT fk_4b60114f717bdf5d');
        $this->addSql('DROP INDEX idx_4b60114f717bdf5d');
        $this->addSql('DROP INDEX idx_4b60114f9d86650f');
        $this->addSql('ALTER TABLE ingredients ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredients DROP user_id_id');
        $this->addSql('ALTER TABLE ingredients DROP recipe_ingredients_id');
        $this->addSql('COMMENT ON COLUMN ingredients.unit IS \'ENUM: g, kg, ml, l, piece(DC2Type:unit_enum)\'');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114FA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4B60114FA76ED395 ON ingredients (user_id)');
        $this->addSql('ALTER TABLE menu_recipes DROP CONSTRAINT fk_2bb2ff0b69574a48');
        $this->addSql('ALTER TABLE menu_recipes DROP CONSTRAINT fk_2bb2ff0beee8bd30');
        $this->addSql('DROP INDEX idx_2bb2ff0b69574a48');
        $this->addSql('DROP INDEX idx_2bb2ff0beee8bd30');
        $this->addSql('ALTER TABLE menu_recipes ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_recipes ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_recipes DROP menu_id_id');
        $this->addSql('ALTER TABLE menu_recipes DROP recipe_id_id');
        $this->addSql('ALTER TABLE menu_recipes ADD CONSTRAINT FK_2BB2FF0BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_recipes ADD CONSTRAINT FK_2BB2FF0B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2BB2FF0BCCD7E912 ON menu_recipes (menu_id)');
        $this->addSql('CREATE INDEX IDX_2BB2FF0B59D8A214 ON menu_recipes (recipe_id)');
        $this->addSql('DROP INDEX idx_727508cf9d86650f');
        $this->addSql('ALTER TABLE menus RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE menus ADD CONSTRAINT FK_727508CFA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_727508CFA76ED395 ON menus (user_id)');
        $this->addSql('ALTER TABLE prestation_menus DROP CONSTRAINT fk_b0fe434ebdcfd5d6');
        $this->addSql('ALTER TABLE prestation_menus DROP CONSTRAINT fk_b0fe434eeee8bd30');
        $this->addSql('DROP INDEX idx_b0fe434ebdcfd5d6');
        $this->addSql('DROP INDEX idx_b0fe434eeee8bd30');
        $this->addSql('ALTER TABLE prestation_menus ADD prestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_menus ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_menus DROP prestation_id_id');
        $this->addSql('ALTER TABLE prestation_menus DROP menu_id_id');
        $this->addSql('ALTER TABLE prestation_menus ADD CONSTRAINT FK_B0FE434E9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_menus ADD CONSTRAINT FK_B0FE434ECCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B0FE434E9E45C554 ON prestation_menus (prestation_id)');
        $this->addSql('CREATE INDEX IDX_B0FE434ECCD7E912 ON prestation_menus (menu_id)');
        $this->addSql('ALTER TABLE prestation_recipes DROP CONSTRAINT fk_60ff112c69574a48');
        $this->addSql('ALTER TABLE prestation_recipes DROP CONSTRAINT fk_60ff112cbdcfd5d6');
        $this->addSql('DROP INDEX idx_60ff112c69574a48');
        $this->addSql('DROP INDEX idx_60ff112cbdcfd5d6');
        $this->addSql('ALTER TABLE prestation_recipes ADD prestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_recipes ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_recipes DROP prestation_id_id');
        $this->addSql('ALTER TABLE prestation_recipes DROP recipe_id_id');
        $this->addSql('ALTER TABLE prestation_recipes ADD CONSTRAINT FK_60FF112C9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_recipes ADD CONSTRAINT FK_60FF112C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_60FF112C9E45C554 ON prestation_recipes (prestation_id)');
        $this->addSql('CREATE INDEX IDX_60FF112C59D8A214 ON prestation_recipes (recipe_id)');
        $this->addSql('DROP INDEX idx_b338d8d19d86650f');
        $this->addSql('ALTER TABLE prestations RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B338D8D1A76ED395 ON prestations (user_id)');
        $this->addSql('ALTER TABLE recipe_ingredients ADD recipe_id INT NOT NULL');
        $this->addSql('ALTER TABLE recipe_ingredients ADD ingredient_id INT NOT NULL');
        $this->addSql('ALTER TABLE recipe_ingredients ADD CONSTRAINT FK_9F925F2B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipe_ingredients ADD CONSTRAINT FK_9F925F2B933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9F925F2B59D8A214 ON recipe_ingredients (recipe_id)');
        $this->addSql('CREATE INDEX IDX_9F925F2B933FE08C ON recipe_ingredients (ingredient_id)');
        $this->addSql('DROP INDEX idx_a369e2b59d86650f');
        $this->addSql('ALTER TABLE recipes RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B5A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A369E2B5A76ED395 ON recipes (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chef_settings DROP CONSTRAINT FK_42E555A2A76ED395');
        $this->addSql('ALTER TABLE ingredients DROP CONSTRAINT FK_4B60114FA76ED395');
        $this->addSql('ALTER TABLE menus DROP CONSTRAINT FK_727508CFA76ED395');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D1A76ED395');
        $this->addSql('ALTER TABLE recipes DROP CONSTRAINT FK_A369E2B5A76ED395');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(320) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP INDEX IDX_4B60114FA76ED395');
        $this->addSql('ALTER TABLE ingredients ADD recipe_ingredients_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredients RENAME COLUMN user_id TO user_id_id');
        $this->addSql('COMMENT ON COLUMN ingredients.unit IS \'(DC2Type:unit_enum)\'');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT fk_4b60114f717bdf5d FOREIGN KEY (recipe_ingredients_id) REFERENCES recipe_ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT fk_4b60114f9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4b60114f717bdf5d ON ingredients (recipe_ingredients_id)');
        $this->addSql('CREATE INDEX idx_4b60114f9d86650f ON ingredients (user_id_id)');
        $this->addSql('DROP INDEX IDX_727508CFA76ED395');
        $this->addSql('ALTER TABLE menus RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE menus ADD CONSTRAINT fk_727508cf9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_727508cf9d86650f ON menus (user_id_id)');
        $this->addSql('ALTER TABLE recipe_ingredients DROP CONSTRAINT FK_9F925F2B59D8A214');
        $this->addSql('ALTER TABLE recipe_ingredients DROP CONSTRAINT FK_9F925F2B933FE08C');
        $this->addSql('DROP INDEX IDX_9F925F2B59D8A214');
        $this->addSql('DROP INDEX IDX_9F925F2B933FE08C');
        $this->addSql('ALTER TABLE recipe_ingredients DROP recipe_id');
        $this->addSql('ALTER TABLE recipe_ingredients DROP ingredient_id');
        $this->addSql('ALTER TABLE prestation_recipes DROP CONSTRAINT FK_60FF112C9E45C554');
        $this->addSql('ALTER TABLE prestation_recipes DROP CONSTRAINT FK_60FF112C59D8A214');
        $this->addSql('DROP INDEX IDX_60FF112C9E45C554');
        $this->addSql('DROP INDEX IDX_60FF112C59D8A214');
        $this->addSql('ALTER TABLE prestation_recipes ADD prestation_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_recipes ADD recipe_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_recipes DROP prestation_id');
        $this->addSql('ALTER TABLE prestation_recipes DROP recipe_id');
        $this->addSql('ALTER TABLE prestation_recipes ADD CONSTRAINT fk_60ff112c69574a48 FOREIGN KEY (recipe_id_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_recipes ADD CONSTRAINT fk_60ff112cbdcfd5d6 FOREIGN KEY (prestation_id_id) REFERENCES prestations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_60ff112c69574a48 ON prestation_recipes (recipe_id_id)');
        $this->addSql('CREATE INDEX idx_60ff112cbdcfd5d6 ON prestation_recipes (prestation_id_id)');
        $this->addSql('ALTER TABLE prestation_menus DROP CONSTRAINT FK_B0FE434E9E45C554');
        $this->addSql('ALTER TABLE prestation_menus DROP CONSTRAINT FK_B0FE434ECCD7E912');
        $this->addSql('DROP INDEX IDX_B0FE434E9E45C554');
        $this->addSql('DROP INDEX IDX_B0FE434ECCD7E912');
        $this->addSql('ALTER TABLE prestation_menus ADD prestation_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_menus ADD menu_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation_menus DROP prestation_id');
        $this->addSql('ALTER TABLE prestation_menus DROP menu_id');
        $this->addSql('ALTER TABLE prestation_menus ADD CONSTRAINT fk_b0fe434ebdcfd5d6 FOREIGN KEY (prestation_id_id) REFERENCES prestations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_menus ADD CONSTRAINT fk_b0fe434eeee8bd30 FOREIGN KEY (menu_id_id) REFERENCES menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b0fe434ebdcfd5d6 ON prestation_menus (prestation_id_id)');
        $this->addSql('CREATE INDEX idx_b0fe434eeee8bd30 ON prestation_menus (menu_id_id)');
        $this->addSql('DROP INDEX UNIQ_42E555A2A76ED395');
        $this->addSql('ALTER TABLE chef_settings ALTER tva_rate TYPE VARCHAR(10)');
        $this->addSql('ALTER TABLE chef_settings RENAME COLUMN user_id TO user_id_id');
        $this->addSql('COMMENT ON COLUMN chef_settings.tva_rate IS \'(DC2Type:prestation_status_enum)\'');
        $this->addSql('ALTER TABLE chef_settings ADD CONSTRAINT fk_42e555a29d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_42e555a29d86650f ON chef_settings (user_id_id)');
        $this->addSql('DROP INDEX IDX_B338D8D1A76ED395');
        $this->addSql('ALTER TABLE prestations RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT fk_b338d8d19d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b338d8d19d86650f ON prestations (user_id_id)');
        $this->addSql('DROP INDEX IDX_A369E2B5A76ED395');
        $this->addSql('ALTER TABLE recipes RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT fk_a369e2b59d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a369e2b59d86650f ON recipes (user_id_id)');
        $this->addSql('ALTER TABLE menu_recipes DROP CONSTRAINT FK_2BB2FF0BCCD7E912');
        $this->addSql('ALTER TABLE menu_recipes DROP CONSTRAINT FK_2BB2FF0B59D8A214');
        $this->addSql('DROP INDEX IDX_2BB2FF0BCCD7E912');
        $this->addSql('DROP INDEX IDX_2BB2FF0B59D8A214');
        $this->addSql('ALTER TABLE menu_recipes ADD menu_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_recipes ADD recipe_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_recipes DROP menu_id');
        $this->addSql('ALTER TABLE menu_recipes DROP recipe_id');
        $this->addSql('ALTER TABLE menu_recipes ADD CONSTRAINT fk_2bb2ff0b69574a48 FOREIGN KEY (recipe_id_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_recipes ADD CONSTRAINT fk_2bb2ff0beee8bd30 FOREIGN KEY (menu_id_id) REFERENCES menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2bb2ff0b69574a48 ON menu_recipes (recipe_id_id)');
        $this->addSql('CREATE INDEX idx_2bb2ff0beee8bd30 ON menu_recipes (menu_id_id)');
    }
}
