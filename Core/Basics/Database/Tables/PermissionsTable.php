<?php 

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\CRUD;
use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class PermissionsTable extends Migration {
    public function up() {
      $validPermissions = [
         ['name' => 'admin', 'slug' => 'admin'],
      ];
      
      $this->createTable("permissions", function(SchemaBuilder $table) {
            $table->id()
                ->string("name")
                ->string("slug")
                ->timestamps()
            ;
        });

        $crud = new CRUD();

        foreach ($validPermissions as $permission) {
            $crud->create("permissions", $permission);
        }



        $this->createTable("userpermissions", function(SchemaBuilder $table) {
         $table->id()
             ->foreignId("user")->foreignKey("user", "users")->nullable()
             ->foreignId("permission")->foreignKey("permission", "permissions")->nullable()
             ->timestamps();
     });
    }

    public function down() {
        $this->db->query("DROP TABLE people");
    }
}

?>