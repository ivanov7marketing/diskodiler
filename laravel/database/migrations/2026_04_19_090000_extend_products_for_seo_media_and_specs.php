<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('h1')->nullable();
            $table->text('seo_text')->nullable();

            $table->string('stock_status')->default('in_stock')->index();
            $table->unsignedInteger('quantity')->nullable();
            $table->string('set_condition')->nullable();

            $table->string('diameter')->nullable();
            $table->string('width_front')->nullable();
            $table->string('width_rear')->nullable();
            $table->string('et_front')->nullable();
            $table->string('et_rear')->nullable();
            $table->string('pcd')->nullable();
            $table->string('dia')->nullable();

            $table->string('video_path')->nullable();
            $table->string('video_disk')->nullable();
            $table->text('video_url')->nullable();
            $table->string('video_poster_path')->nullable();
            $table->string('video_poster_disk')->nullable();
            $table->text('video_poster_url')->nullable();
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->text('url')->nullable()->change();
            $table->text('path')->nullable();
            $table->string('disk')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->text('url')->nullable(false)->change();
            $table->dropColumn(['path', 'disk']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'h1',
                'seo_text',
                'stock_status',
                'quantity',
                'set_condition',
                'diameter',
                'width_front',
                'width_rear',
                'et_front',
                'et_rear',
                'pcd',
                'dia',
                'video_path',
                'video_disk',
                'video_url',
                'video_poster_path',
                'video_poster_disk',
                'video_poster_url',
            ]);
        });
    }
};
