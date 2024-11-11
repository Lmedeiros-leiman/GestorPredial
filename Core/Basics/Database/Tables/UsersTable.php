<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;

class UsersTable extends Migration {
    public function up() {
        $this->createTable("users", function($table) {
            $table->id()
                ->string("email")
                ->foreignId("secret_id")
                ->foreignKey("secret_id", "secrets")
                ->nullable()
                ->timestamps()
            ;
        });
    }

    public function down() {
        $this->db->query("DROP TABLE users");
    }
}


?>