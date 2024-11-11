<?php

namespace Core\Basics\Database\Tables;

use Core\Basics\Database\Migration\Migration;
use Core\Basics\Database\Migration\SchemaBuilder;

class SecretsTable extends Migration {
    public function up() {
        $this->createTable('secrets', function (SchemaBuilder $table) {
            $table->id();
            $table->string('salt');
            $table->text('value');
            $table->timestamps();
        });
    }

    public function down() {
        $this->db->query("DROP TABLE secrets");
    }
}


?>