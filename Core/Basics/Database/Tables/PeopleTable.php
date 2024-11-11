<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class PeopleTable extends Migration {
    public function up() {
        $this->createTable("people", function(SchemaBuilder $table) {
            $table->id()
                ->string("first_name")
                ->string("last_name")
                ->foreignId("account_id")->foreignKey("account_id", "users")->nullable()
                ->foreignId("organizations_id")->foreignKey("organizations_id", "organizations")->nullable()
                ->timestamps()
            ;
        });
    }

    public function down() {
        $this->db->query("DROP TABLE people");
    }
}

?>