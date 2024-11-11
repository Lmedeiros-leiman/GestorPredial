<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class InventoryTable extends Migration {
    public function up() {
        $this->createTable("inventory", function(SchemaBuilder $table) {
            $table->id()
                ->string("item_name")
                ->integer("ammount")
                ->foreignId("organization_id")->foreignKey("organization_id", "organizations")->nullable()
                ->foreignId("responsible_id")->foreignKey("responsible_id", "people")->nullable()
                ->timestamps()
            ;
        });
    }

    public function down() {
        $this->db->query("DROP TABLE inventory");
    }
}

?>