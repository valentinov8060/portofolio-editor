<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePortofolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id(); // Kolom id
            $table->string('name', 100)->nullable(); // Kolom untuk nama dengan batasan 100 karakter
            $table->string('profession', 100)->nullable(); // Kolom untuk profesi dengan batasan 100 karakter
            $table->binary('profile_picture')->nullable(); 
            $table->enum('mime_type', ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'])->nullable();
            $table->text('about')->nullable();
            $table->jsonb('skills')->nullable();
            $table->timestamps();
        });

        // Tambahkan constraint agar hanya satu baris data yang diperbolehkan
        DB::statement('ALTER TABLE portofolio ADD CONSTRAINT single_row CHECK (id = 1)');

        // Menambahkan data default dengan id 1
        DB::table('portofolio')->insert([
            'id' => 1,
            'name' => null,
            'profession' => null,
            'profile_picture' => null, // Atur null atau masukkan data gambar di sini
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portofolio');
    }
}
