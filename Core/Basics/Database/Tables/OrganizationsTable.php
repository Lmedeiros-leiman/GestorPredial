<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class OrganizationsTable extends Migration
{
    public function up() {
        $this->createTable("organizations", function(SchemaBuilder $table) {
            $table->id()
                ->string("name")
                ->timestamps()
                ->foreignId("responsible_id")->foreignKey("responsible_id", "people")->nullable();
        });
    }

    public function down() {
        $this->db->query("DROP TABLE organizations");
    }
}




?>