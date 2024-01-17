<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
     public function up()
     {
         Schema::create('users', function (Blueprint $table) {
             $table->id();
             $table->string('user_id', 250)->default('');
             $table->string('user_mail', 50)->default('');
             $table->string('user_name', 50)->default('');
             $table->string('user_password', 150)->default('');
             $table->string('user_phone', 50)->nullable();
             $table->dateTime('user_birthdate')->nullable();
             $table->text('user_image_url')->default('');
             $table->integer('user_forgot_password')->default(0);
             $table->dateTime('user_email_verified_at')->nullable(); // eğer MySQL'de tinyint kullanıyorsanız
             $table->dateTime('user_register_date')->nullable();
             $table->text('user_notification_token')->default('');
             $table->tinyInteger('user_language')->default(0);
             $table->string('user_role', 50)->nullable();
             $table->string('remember_token', 100)->default('');
             $table->timestamps();
         });
     }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
   
    public function down()
    {
        Schema::dropIfExists('users');
    }

}
