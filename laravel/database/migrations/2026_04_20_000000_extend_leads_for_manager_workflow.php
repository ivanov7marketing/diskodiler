<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('contact_method')->nullable()->after('phone');
            $table->text('manager_comment')->nullable()->after('message');
            $table->timestamp('handled_at')->nullable()->after('manager_comment');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'contact_method',
                'manager_comment',
                'handled_at',
            ]);
        });
    }
};
