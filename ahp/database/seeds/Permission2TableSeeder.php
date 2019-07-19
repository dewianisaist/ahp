<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Permission;

class Permission2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
			[
        		'name' => 'resultstep1-list',
        		'display_name' => 'Menampilkan hasil kriteria pada tahap 1',
        		'description' => 'Menampilkan hasil kriteria pada tahap 1'
        	],
			[
        		'name' => 'criteriastep2-list',
        		'display_name' => 'Menampilkan kriteria pada tahap 2',
        		'description' => 'Menampilkan kriteria pada tahap 2'
        	],
        	[
        		'name' => 'criteriastep2-create',
        		'display_name' => 'Menambahkan kriteria pada tahap 2',
        		'description' => 'Menambahkan kriteria pada tahap 2'
        	],
        	[
        		'name' => 'criteriastep2-edit',
        		'display_name' => 'Edit kriteria pada tahap 2',
        		'description' => 'Edit kriteria pada tahap 2'
        	],
        	[
        		'name' => 'criteriastep2-delete',
        		'display_name' => 'Hapus kriteria pada tahap 2',
        		'description' => 'Hapus kriteria pada tahap 2'
            ],
            [
        		'name' => 'criteriastep2-use',
        		'display_name' => 'Menggunakan kriteria pada tahap sebelumnya',
        		'description' => 'Menggunakan kriteria pada tahap sebelumnya'
			],
			[
        		'name' => 'criteriagroup-list',
        		'display_name' => 'Menampilkan hierarki (kelompok kriteria)',
        		'description' => 'Menampilkan hierarki (kelompok kriteria)'
        	],
        	[
        		'name' => 'criteriagroup-create',
        		'display_name' => 'Menambahkan kelompok kriteria',
        		'description' => 'Menambahkan kelompok kriteria'
        	],
        	[
        		'name' => 'criteriagroup-edit',
        		'display_name' => 'Edit kelompok kriteria',
        		'description' => 'Edit kelompok kriteria'
        	],
        	[
        		'name' => 'criteriagroup-delete',
        		'display_name' => 'Hapus kelompok kriteria',
        		'description' => 'Hapus kelompok kriteria'
            ],
            [
        		'name' => 'criteriagroup-add',
        		'display_name' => 'Tambahkan kriteria ke kelompok kriteria',
        		'description' => 'Tambahkan kriteria ke kelompok kriteria'
			],
            [
        		'name' => 'criteriagroup-out',
        		'display_name' => 'Keluarkan kriteria dari kelompok kriteria',
        		'description' => 'Keluarkan kriteria dari kelompok kriteria'
            ],
			[
        		'name' => 'weights-list',
        		'display_name' => 'Menampilkan bobot kriteria',
        		'description' => 'Menampilkan bobot kriteria'
        	],
        	[
        		'name' => 'weights-pairwise',
        		'display_name' => 'Melakukan perbandingan berpasangan',
        		'description' => 'Melakukan perbandingan berpasangan'
            ],
			[
        		'name' => 'result_selection-list',
        		'display_name' => 'Menampilkan daftar data alternatif untuk penilaian',
        		'description' => 'Menampilkan daftar data alternatif untuk penilaian'
        	],
        	[
        		'name' => 'result_selection-assessment',
        		'display_name' => 'Melakukan penilaian terhadap alternatif',
        		'description' => 'Melakukan penilaian terhadap alternatif'
        	],
        	[
        		'name' => 'result_selection-clear',
        		'display_name' => 'Hapus penilaian terhadap alternatif',
        		'description' => 'Hapus penilaian terhadap alternatif'
        	],
        	[
        		'name' => 'result_selection-count',
        		'display_name' => 'Menghitung penilaian alternatif',
        		'description' => 'Menghitung penilaian alternatif'
			],
			[
        		'name' => 'result-list',
        		'display_name' => 'Menampilkan hasil seleksi',
        		'description' => 'Menampilkan hasil seleksi'
        	],
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
