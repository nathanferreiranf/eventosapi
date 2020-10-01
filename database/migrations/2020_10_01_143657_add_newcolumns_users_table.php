<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewcolumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sobrenome')->nullable(true)->after('email');
            $table->string('cpf')->nullable(true)->after('email');
            $table->string('fl_interesse')->nullable(true)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sobrenome');
            $table->dropColumn('cpf');
            $table->dropColumn('fl_interesse');
        });
    }
}
