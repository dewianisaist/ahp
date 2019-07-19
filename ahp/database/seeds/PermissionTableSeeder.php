<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Permission;

class PermissionTableSeeder extends Seeder
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
        		'name' => 'registrant-list',
        		'display_name' => 'Menampilkan data pendaftar',
        		'description' => 'Menampilkan data pendaftar'
        	],
        	[
        		'name' => 'registrant-edit',
        		'display_name' => 'Edit data pendaftar',
        		'description' => 'Edit data pendaftar'
			],
			[
        		'name' => 'educational_background-list',
        		'display_name' => 'Menampilkan daftar riwayat pendidikan',
        		'description' => 'Menampilkan daftar riwayat pendidikan'
        	],
        	[
        		'name' => 'educational_background-create',
        		'display_name' => 'Menambahkan riwayat pendidikan',
        		'description' => 'Menambahkan riwayat pendidikan'
        	],
        	[
        		'name' => 'educational_background-edit',
        		'display_name' => 'Edit riwayat pendidikan',
        		'description' => 'Edit riwayat pendidikan'
        	],
        	[
        		'name' => 'educational_background-delete',
        		'display_name' => 'Hapus riwayat pendidikan',
        		'description' => 'Hapus riwayat pendidikan'
			],
			[
        		'name' => 'course_experience-list',
        		'display_name' => 'Menampilkan daftar pengalaman kursus',
        		'description' => 'Menampilkan daftar pengalaman kursus'
        	],
        	[
        		'name' => 'course_experience-create',
        		'display_name' => 'Menambahkan pengalaman kursus',
        		'description' => 'Menambahkan pengalaman kursus'
        	],
        	[
        		'name' => 'course_experience-edit',
        		'display_name' => 'Edit pengalaman kursus',
        		'description' => 'Edit pengalaman kursus'
        	],
        	[
        		'name' => 'course_experience-delete',
        		'display_name' => 'Hapus pengalaman kursus',
        		'description' => 'Hapus pengalaman kursus'
			],
			[
        		'name' => 'registration-list',
        		'display_name' => 'Menampilkan riwayat pendaftaran',
        		'description' => 'Menampilkan riwayat pendaftaran'
        	],
        	[
        		'name' => 'registration-create',
        		'display_name' => 'Melakukan pendaftaran',
        		'description' => 'Melakukan pendaftaran'
        	],
			[
        		'name' => 'user-list',
        		'display_name' => 'Menampilkan daftar akun pengguna',
        		'description' => 'Menampilkan daftar akun pengguna'
        	],
        	[
        		'name' => 'user-create',
        		'display_name' => 'Membuat akun pengguna',
        		'description' => 'Membuat akun pengguna'
        	],
        	[
        		'name' => 'user-edit',
        		'display_name' => 'Edit akun pengguna',
        		'description' => 'Edit akun pengguna'
        	],
        	[
        		'name' => 'user-delete',
        		'display_name' => 'Hapus akun pengguna',
        		'description' => 'Hapus akun pengguna'
			],
			[
        		'name' => 'role-list',
        		'display_name' => 'Menampilkan daftar role',
        		'description' => 'Menampilkan daftar role'
        	],
        	[
        		'name' => 'role-create',
        		'display_name' => 'Membuat role',
        		'description' => 'Membuat role'
        	],
        	[
        		'name' => 'role-edit',
        		'display_name' => 'Edit role',
        		'description' => 'Edit role'
        	],
        	[
        		'name' => 'role-delete',
        		'display_name' => 'Hapus role',
        		'description' => 'Hapus role'
			],
        	[
        		'name' => 'vocational-list',
        		'display_name' => 'Menampilkan daftar kejuruan',
        		'description' => 'Menampilkan daftar kejuruan'
        	],
        	[
        		'name' => 'vocational-create',
        		'display_name' => 'Membuat kejuruan',
        		'description' => 'Membuat kejuruan'
        	],
        	[
        		'name' => 'vocational-edit',
        		'display_name' => 'Edit kejuruan',
        		'description' => 'Edit kejuruan'
        	],
        	[
        		'name' => 'vocational-delete',
        		'display_name' => 'Hapus kejuruan',
        		'description' => 'Hapus kejuruan'
			],
			[
        		'name' => 'education-list',
        		'display_name' => 'Menampilkan daftar pendidikan',
        		'description' => 'Menampilkan daftar pendidikan'
        	],
        	[
        		'name' => 'education-create',
        		'display_name' => 'Menambahkan pendidikan',
        		'description' => 'Menambahkan pendidikan'
        	],
        	[
        		'name' => 'education-edit',
        		'display_name' => 'Edit pendidikan',
        		'description' => 'Edit pendidikan'
        	],
        	[
        		'name' => 'education-delete',
        		'display_name' => 'Hapus pendidikan',
        		'description' => 'Hapus pendidikan'
			],
			[
        		'name' => 'course-list',
        		'display_name' => 'Menampilkan daftar kursus',
        		'description' => 'Menampilkan daftar kursus'
        	],
        	[
        		'name' => 'course-create',
        		'display_name' => 'Menambahkan kursus',
        		'description' => 'Menambahkan kursus'
        	],
        	[
        		'name' => 'course-edit',
        		'display_name' => 'Edit kursus',
        		'description' => 'Edit kursus'
        	],
        	[
        		'name' => 'course-delete',
        		'display_name' => 'Hapus kursus',
        		'description' => 'Hapus kursus'
			],
			[
        		'name' => 'profile_user-list',
        		'display_name' => 'Menampilkan profile user',
        		'description' => 'Menampilkan profile user'
        	],
        	[
        		'name' => 'profile_user-edit',
        		'display_name' => 'Edit profile user',
        		'description' => 'Edit profile user'
        	],
			[
        		'name' => 'subvocational-list',
        		'display_name' => 'Menampilkan daftar sub-kejuruan',
        		'description' => 'Menampilkan daftar sub-kejuruan'
        	],
        	[
        		'name' => 'subvocational-create',
        		'display_name' => 'Membuat sub-kejuruan',
        		'description' => 'Membuat sub-kejuruan'
        	],
        	[
        		'name' => 'subvocational-edit',
        		'display_name' => 'Edit sub-kejuruan',
        		'description' => 'Edit sub-kejuruan'
        	],
        	[
        		'name' => 'subvocational-delete',
        		'display_name' => 'Hapus sub-kejuruan',
        		'description' => 'Hapus sub-kejuruan'
			],
			[
        		'name' => 'criteria-list',
        		'display_name' => 'Menampilkan daftar kriteria',
        		'description' => 'Menampilkan daftar kriteria'
        	],
        	[
        		'name' => 'criteria-create',
        		'display_name' => 'Membuat kriteria',
        		'description' => 'Membuat kriteria'
        	],
        	[
        		'name' => 'criteria-edit',
        		'display_name' => 'Edit kriteria',
        		'description' => 'Edit kriteria'
        	],
        	[
        		'name' => 'criteria-delete',
        		'display_name' => 'Hapus kriteria',
        		'description' => 'Hapus kriteria'
			],
			[
        		'name' => 'preference-list',
        		'display_name' => 'Menampilkan daftar preference',
        		'description' => 'Menampilkan daftar preference'
        	],
        	[
        		'name' => 'preference-create',
        		'display_name' => 'Membuat preference',
        		'description' => 'Membuat preference'
        	],
        	[
        		'name' => 'preference-edit',
        		'display_name' => 'Edit preference',
        		'description' => 'Edit preference'
        	],
        	[
        		'name' => 'preference-delete',
        		'display_name' => 'Hapus preference',
        		'description' => 'Hapus preference'
			],
			[
        		'name' => 'manage_registrant-list',
        		'display_name' => 'Menampilkan daftar data pendaftar',
        		'description' => 'Menampilkan daftar data pendaftar'
			],
			[
        		'name' => 'questionnaire-list',
        		'display_name' => 'Menampilkan isian kuesioner kriteria',
        		'description' => 'Menampilkan isian kuesioner kriteria'
        	],
        	[
        		'name' => 'questionnaire-create',
        		'display_name' => 'Mengisi kuesioner kriteria',
        		'description' => 'Mengisi kuesioner kriteria'
			],
			[
        		'name' => 'selectionschedule-list',
        		'display_name' => 'Menampilkan daftar jadwal seleksi',
        		'description' => 'Menampilkan daftar jadwal seleksi'
        	],
        	[
        		'name' => 'selectionschedule-create',
        		'display_name' => 'Membuat jadwal seleksi',
        		'description' => 'Membuat jadwal seleksi'
        	],
        	[
        		'name' => 'selectionschedule-edit',
        		'display_name' => 'Edit jadwal seleksi',
        		'description' => 'Edit jadwal seleksi'
        	],
        	[
        		'name' => 'selectionschedule-delete',
        		'display_name' => 'Hapus jadwal seleksi',
        		'description' => 'Hapus jadwal seleksi'
        	],
        	[
        		'name' => 'selection-list',
        		'display_name' => 'Menampilkan daftar nilai seleksi',
        		'description' => 'Menampilkan daftar nilai seleksi'
        	],
        	[
        		'name' => 'selection-edit',
        		'display_name' => 'Memasukkan nilai seleksi',
        		'description' => 'Memasukkan nilai seleksi'
			],
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
