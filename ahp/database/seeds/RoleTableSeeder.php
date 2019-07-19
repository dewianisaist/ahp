<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
			[
        		'name' => 'superadmin',
        		'display_name' => 'Peneliti',
        		'description' => 'Mempunyai hak akses untuk semua fitur'
        	],
        	[
        		'name' => 'admin',
        		'display_name' => 'Staf',
        		'description' => 'Melakukan kegiatan operasional'
            ],
            [
        		'name' => 'kepala',
        		'display_name' => 'Kepala',
        		'description' => 'Sebagai pembuat keputusan'
        	],
        	[
        		'name' => 'pendaftar',
        		'display_name' => 'Pendaftar',
        		'description' => 'Calon peserta pelatihan yang mengikuti seleksi'
            ],
        	[
        		'name' => 'kasubag',
        		'display_name' => 'Kepala Sub-Bagian TU',
        		'description' => 'Bertanggung jawab terhadap operasional'
            ],
            [
        		'name' => 'koor',
        		'display_name' => 'Koordinator Instruktur',
        		'description' => 'Bertanggung jawab terhadap kepala kejuruan'
        	],
        	[
        		'name' => 'kajur',
        		'display_name' => 'Kepala Kejuruan',
        		'description' => 'Bertanggungjawab terhadap pelaksanaan seleksi'
            ],
        ];

        foreach ($role as $key => $value) {
        	Role::create($value);
        }
    }
}
