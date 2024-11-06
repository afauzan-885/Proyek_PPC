<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('reset_request_status', ['pending', 'approved', 'rejected'])->nullable();
            $table->timestamp('reset_request_expiry')->nullable();
            $table->string('tentang_saya')->nullable();
            $table->string('kontak')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('remember')->nullable();
            $table->string('role')->default('member');
            $table->string('photo')->nullable()->default(''); 
            $table->boolean('is_active')->default(false); 
            $table->rememberToken();
            $table->timestamps();
        });
        
    
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
