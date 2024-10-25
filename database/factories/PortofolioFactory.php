<?php

namespace Database\Factories;

use App\Models\Portofolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortofolioFactory extends Factory
{
    // Tentukan model terkait factory ini
    protected $model = Portofolio::class;

    public function definition()
    {
        return [
            'id' => env('USER_ID'), // Menentukan ID sesuai kebutuhan
            'user_id' => env('USER_ID'), // Menentukan user_id yang sesuai
            'name' => $this->faker->name, // Anda bisa mengubah ini sesuai data yang ingin diisi
            'profession' => $this->faker->jobTitle, // Contoh untuk data profession
            'profile_picture' => null, // Biarkan kosong atau sesuai data yang ingin diisi
            'mime_type' => null,
            'about' => null,
            'skills' => null,
            'projects' => null,
            'contacts' => null,
        ];
    }
}
