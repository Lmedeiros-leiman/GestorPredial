<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class ContactsTable extends Migration {
    public function up() {
        $this->createTable("contacts", function(SchemaBuilder $table) {
            $table->id()
                ->string("label")
                ->string("value")
                ->boolean("confirmed",false)
                ->foreignId("people_id")->foreignKey("people_id", "people")->nullable()
                ->timestamps();
        });
    }

    public function down() {
        $this->db->query("DROP TABLE contacts");
    }
}

?>