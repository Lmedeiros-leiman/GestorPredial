<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class UsersTable extends Migration {
    public function up() {
        $this->createTable("users", function(SchemaBuilder $table) {
            $table->id()
                ->string("email")
                ->foreignId("password")->foreignKey("password", "secrets")->nullable()
                ->boolean("confirmed_email", false)
                ->foreignId("person_ID")->foreignKey("person_ID", "people")->nullable()
                ->timestamps()
            ;
        });
    }

    public function down() {
        $this->db->query("DROP TABLE users");
    }
}


?>