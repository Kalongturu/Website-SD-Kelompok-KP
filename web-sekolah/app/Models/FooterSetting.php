<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $table = 'footer_settings';

    protected $fillable = [
        'nama_sekolah',
        'deskripsi',
        'alamat',
        'telepon',
        'email',
        'jam_weekday',
        'jam_sabtu',
        'copyright',
    ];

    /** Ambil baris pertama atau instance baru dengan default. */
    public static function getData(): self
    {
        return static::first() ?? new static([
            'nama_sekolah' => 'SDN Dadapsari',
            'deskripsi'    => 'Santun dalam berperilaku, hebat dalam prestasi. Membentuk generasi cerdas, berkarakter, dan berakhlak mulia melalui pendidikan dasar yang berkualitas.',
            'alamat'       => 'Jl. Petek No. 117-119, Kel. Dadapsari, Kec. Semarang Utara, Kota Semarang',
            'telepon'      => '(024) 3568721',
            'email'        => 'dadapsarisd@gmail.com',
            'jam_weekday'  => '07.00 – 15.00',
            'jam_sabtu'    => '07.00 – 11.00',
            'copyright'    => 'SDN Dadapsari. Seluruh hak cipta dilindungi.',
        ]);
    }
}
