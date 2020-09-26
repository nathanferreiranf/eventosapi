<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefone_celular')->nullable(true)->after('email');
            $table->string('estado')->nullable(true)->after('email');
            $table->string('cidade')->nullable(true)->after('email');
            $table->string('escolaridade')->nullable(true)->after('email');
            $table->string('profissao')->nullable(true)->after('email');
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
            $table->dropColumn('telefone_celular');
            $table->dropColumn('estado');
            $table->dropColumn('cidade');
            $table->dropColumn('escolaridade');
            $table->dropColumn('profissao');
        });
    }
}
