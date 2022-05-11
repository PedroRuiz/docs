<?php

namespace Docs\Database\Migrations;

use CodeIgniter\Database\Migration;

class Docs extends Migration
{

  const TABLE = 'module_docs';
  const ID = 'id';
  const USERFIELD = 'user';
  const USERSTABLE = 'users';

  public function up()
  {
    $this->forge->dropTable(self::TABLE, true); // delete if table exists

    $this->forge->addField([
      self::ID           => [
        'type'           => 'INT',
        'constraint'     => 5,
        'unsigned'       => true,
        'auto_increment' => true,
      ],
      self::USERFIELD => [        
        'type'           => 'MEDIUMINT',
        'constraint'     => '8',
        'unsigned'       => true,
      ],
      'docname' => [
        'type'           => 'VARCHAR',
        'constraint'     => '255',
        'null'           => false,
        'unique'         => true,
      ],
      'content' => [
        'type'  => 'TEXT',
        'null'  => 'false',
      ],

      'created_at' => [
        'type'       => 'DATETIME',                
        'null'       => false,
        'default' => null,
      ],
      'updated_at' => [
        'type'       => 'DATETIME',                
        'null'       => false,
        'default' => null,
      ],
      'deleted_at' => [
        'type'       => 'DATETIME',                
        'null'       => true,
        'default' => null,
      ],
    ]);

    $this->forge->addForeignKey(self::USERFIELD, self::USERSTABLE, 'id', 'RESTRICT', 'RESTRICT');
    $this->forge->addKey(self::ID, true);

    $this->forge->createTable(self::TABLE);
  }

  public function down()
  {
    $this->forge->dropTable(self::TABLE, true);
  }
}
