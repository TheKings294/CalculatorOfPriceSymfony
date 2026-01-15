<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251208142229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration for an SAAS for the Private chef';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TYPE prestation_status_enum AS ENUM (\'draft\', \'confirmed\', \'completed\', \'canceled\')');
        $this->addSql('CREATE TYPE recipe_enum AS ENUM (\'starter\', \'main\', \'dessert\', \'side\', \'drink\')');
        $this->addSql('CREATE TYPE taxe_enum AS ENUM (\'no_tva\', \'tva_5_5\', \'tva_10\', \'tva_20\')');
        $this->addSql('CREATE TYPE unit_enum AS ENUM (\'g\', \'kg\', \'ml\', \'l\', \'piece\')');
        $this->addSql('CREATE TABLE chef_settings (id SERIAL NOT NULL, user_id_id INT NOT NULL, applies_tva BOOLEAN NOT NULL, tva_rate prestation_status_enum NOT NULL, margin_percent INT NOT NULL, hourly_rate INT NOT NULL, travel_cost_per_km INT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42E555A29D86650F ON chef_settings (user_id_id)');
        $this->addSql('COMMENT ON COLUMN chef_settings.tva_rate IS \'(DC2Type:prestation_status_enum)\'');
        $this->addSql('COMMENT ON COLUMN chef_settings.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ingredients (id SERIAL NOT NULL, user_id_id INT NOT NULL, recipe_ingredients_id INT NOT NULL, name VARCHAR(255) NOT NULL, unit unit_enum NOT NULL, cost_per_unit INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4B60114F9D86650F ON ingredients (user_id_id)');
        $this->addSql('CREATE INDEX IDX_4B60114F717BDF5D ON ingredients (recipe_ingredients_id)');
        $this->addSql('COMMENT ON COLUMN ingredients.unit IS \'(DC2Type:unit_enum)\'');
        $this->addSql('COMMENT ON COLUMN ingredients.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE menu_recipes (id SERIAL NOT NULL, menu_id_id INT DEFAULT NULL, recipe_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2BB2FF0BEEE8BD30 ON menu_recipes (menu_id_id)');
        $this->addSql('CREATE INDEX IDX_2BB2FF0B69574A48 ON menu_recipes (recipe_id_id)');
        $this->addSql('CREATE TABLE menus (id SERIAL NOT NULL, user_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_727508CF9D86650F ON menus (user_id_id)');
        $this->addSql('COMMENT ON COLUMN menus.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE prestation_menus (id SERIAL NOT NULL, prestation_id_id INT DEFAULT NULL, menu_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0FE434EBDCFD5D6 ON prestation_menus (prestation_id_id)');
        $this->addSql('CREATE INDEX IDX_B0FE434EEEE8BD30 ON prestation_menus (menu_id_id)');
        $this->addSql('CREATE TABLE prestation_recipes (id SERIAL NOT NULL, prestation_id_id INT DEFAULT NULL, recipe_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60FF112CBDCFD5D6 ON prestation_recipes (prestation_id_id)');
        $this->addSql('CREATE INDEX IDX_60FF112C69574A48 ON prestation_recipes (recipe_id_id)');
        $this->addSql('CREATE TABLE prestations (id SERIAL NOT NULL, user_id_id INT NOT NULL, date DATE NOT NULL, people_count INT NOT NULL, base_cost INT NOT NULL, travel_km INT NOT NULL, final_price DOUBLE PRECISION NOT NULL, notes TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B338D8D19D86650F ON prestations (user_id_id)');
        $this->addSql('COMMENT ON COLUMN prestations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE recipe_ingredients (id SERIAL NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE recipes (id SERIAL NOT NULL, user_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A369E2B59D86650F ON recipes (user_id_id)');
        $this->addSql('COMMENT ON COLUMN recipes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(320) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE chef_settings ADD CONSTRAINT FK_42E555A29D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114F9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114F717BDF5D FOREIGN KEY (recipe_ingredients_id) REFERENCES recipe_ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_recipes ADD CONSTRAINT FK_2BB2FF0BEEE8BD30 FOREIGN KEY (menu_id_id) REFERENCES menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_recipes ADD CONSTRAINT FK_2BB2FF0B69574A48 FOREIGN KEY (recipe_id_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menus ADD CONSTRAINT FK_727508CF9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_menus ADD CONSTRAINT FK_B0FE434EBDCFD5D6 FOREIGN KEY (prestation_id_id) REFERENCES prestations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_menus ADD CONSTRAINT FK_B0FE434EEEE8BD30 FOREIGN KEY (menu_id_id) REFERENCES menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_recipes ADD CONSTRAINT FK_60FF112CBDCFD5D6 FOREIGN KEY (prestation_id_id) REFERENCES prestations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation_recipes ADD CONSTRAINT FK_60FF112C69574A48 FOREIGN KEY (recipe_id_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D19D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B59D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chef_settings DROP CONSTRAINT FK_42E555A29D86650F');
        $this->addSql('ALTER TABLE ingredients DROP CONSTRAINT FK_4B60114F9D86650F');
        $this->addSql('ALTER TABLE ingredients DROP CONSTRAINT FK_4B60114F717BDF5D');
        $this->addSql('ALTER TABLE menu_recipes DROP CONSTRAINT FK_2BB2FF0BEEE8BD30');
        $this->addSql('ALTER TABLE menu_recipes DROP CONSTRAINT FK_2BB2FF0B69574A48');
        $this->addSql('ALTER TABLE menus DROP CONSTRAINT FK_727508CF9D86650F');
        $this->addSql('ALTER TABLE prestation_menus DROP CONSTRAINT FK_B0FE434EBDCFD5D6');
        $this->addSql('ALTER TABLE prestation_menus DROP CONSTRAINT FK_B0FE434EEEE8BD30');
        $this->addSql('ALTER TABLE prestation_recipes DROP CONSTRAINT FK_60FF112CBDCFD5D6');
        $this->addSql('ALTER TABLE prestation_recipes DROP CONSTRAINT FK_60FF112C69574A48');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D19D86650F');
        $this->addSql('ALTER TABLE recipes DROP CONSTRAINT FK_A369E2B59D86650F');
        $this->addSql('DROP TABLE chef_settings');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE menu_recipes');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE prestation_menus');
        $this->addSql('DROP TABLE prestation_recipes');
        $this->addSql('DROP TABLE prestations');
        $this->addSql('DROP TABLE recipe_ingredients');
        $this->addSql('DROP TABLE recipes');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
