{{--  pegawai  --}}

{{--  Only staf can see "Data Pengguna"  --}}
@if(Auth::user()->roleId() == 1)
<li {{ substr( \Request::route()->getName(), 0, 6 ) == 'users.' ? 'class=active' : '' }}>
    <a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span>Data Pengguna</span></a>
</li>
@endif

{{--  All user except pendaftar can see "Data Pendaftar"  --}}
@if(Auth::user()->roleId() == 1 || Auth::user()->roleId() == 3 || Auth::user()->roleId() == 4 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
<li {{ substr( \Request::route()->getName(), 0, 19 ) == 'manage_registrants.' ? 'class=active' : '' }}>
  <a href="{{ route('manage_registrants.index') }}"><i class="fa fa-users"></i> <span>Data Pendaftar</span></a>
</li>
@endif

{{--  Only staf can see "Data Role"  --}}
@if(Auth::user()->roleId() == 1)
<li {{ substr( \Request::route()->getName(), 0, 6 ) == 'roles.' ? 'class=active' : '' }}>
    <a href="{{ route('roles.index') }}"><i class="fa fa-key"></i>  <span>Data <dfn>Role</dfn></span></a>
</li>
@endif

{{--  Kajur, kepala, koor. instruktur can see "Nilai Seleksi"  --}}
@if(Auth::user()->roleId() == 3 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
<li {{ substr( \Request::route()->getName(), 0, 11 ) == 'selections.' ? 'class=active' : '' }}>
  <a href="{{ route('selections.index') }}"><i class="fa fa-balance-scale"></i>  <span>Nilai Seleksi</span></a>
</li>
@endif

{{--  All user except pendaftar can see "Kriteria"  --}}
@if(Auth::user()->roleId() == 1 || Auth::user()->roleId() == 3 || Auth::user()->roleId() == 4 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
<li {{ explode( ".",\Request::route()->getName() )[0] == 'criterias' || 
  explode( ".",\Request::route()->getName() )[0] == 'criteriagroup' 
  ? 'class=active treeview menu-open' : '' }}>
  @if(Auth::user()->roleId() == 1)
    <a href="{{ route('criterias.index') }}">
  @elseif(Auth::user()->roleId() == 3 || Auth::user()->roleId() == 4 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
    <a href="{{ route('criteriagroup.index') }}">
  @endif
    <i class="fa fa-list"></i>
    <span>Kriteria</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    {{--  Only staf can see "Kriteria dari Kajian Pustaka"  --}}
    @if(Auth::user()->roleId() == 1)
      <li {{ substr( \Request::route()->getName(), 0, 10 ) == 'criterias.' ? 'class=active' : '' }}>
        <a href="{{ route('criterias.index') }}"><i class="fa fa-list"></i> Kriteria dari Kajian Pustaka</a></li>
    @endif
    @if(Auth::user()->roleId() == 3 || Auth::user()->roleId() == 4 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
      <li {{ substr( \Request::route()->getName(), 0, 14 ) == 'criteriagroup.' ? 'class=active' : '' }}>
        <a href="{{ route('criteriagroup.index') }}"><i class="fa fa-list"></i> Hierarki Kriteria</a>
      </li>
    @endif
  </ul>
</li>
@endif

{{--  Only kepala can see "Bobot/Pairwise Comparison"  --}}
@if(Auth::user()->roleId() == 3)
<li {{ substr( \Request::route()->getName(), 0, 8 ) == 'weights.' ? 'class=active' : '' }}>
  <a href="{{ route('weights.index') }}"><i class="fa fa-balance-scale"></i>  <span>Bobot</span></a>
</li>
@endif

{{--  All user except pendaftar can see "Penilaian"  --}}
@if(Auth::user()->roleId() == 1 || Auth::user()->roleId() == 3 || Auth::user()->roleId() == 4 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
<li {{ explode( ".",\Request::route()->getName() )[0] == 'preferences' || 
  explode( ".",\Request::route()->getName() )[0] == 'result_selection' ||
  explode( ".",\Request::route()->getName() )[0] == 'result' 
  ? 'class=active treeview menu-open' : '' }}>
  @if(Auth::user()->roleId() == 3)
    <a href="{{ route('preferences.index') }}">
  @elseif(Auth::user()->roleId() == 1 || Auth::user()->roleId() == 4 || Auth::user()->roleId() == 5 || Auth::user()->roleId() == 6)
    <a href="{{ route('result.index') }}">
  @endif
    <i class="fa fa-hourglass-half"></i>
    <span>Penilaian</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    {{--  Only kepala can see "Data Alternatif and Tipe Preferensi"  --}}
    @if(Auth::user()->roleId() == 3)
      <li {{ substr( \Request::route()->getName(), 0, 12 ) == 'preferences.' ? 'class=active' : '' }}>
        <a href="{{ route('preferences.index') }}"><i class="fa fa-hourglass-half"></i> Tipe Preferensi</a>
      </li>
      <li {{ substr( \Request::route()->getName(), 0, 17 ) == 'result_selection.' ? 'class=active' : '' }}>
        <a href="{{ route('result_selection.index') }}"><i class="fa fa-hourglass-half"></i> Data Alternatif</a>
      </li>
    @endif
    <li {{ substr( \Request::route()->getName(), 0, 7 ) == 'result.' ? 'class=active' : '' }}>
      <a href="{{ route('result.index') }}"><i class="fa fa-hourglass-half"></i> Hasil</a>
    </li>
  </ul>
</li>
@endif


{{--  pendaftar  --}}

{{--  Only pendaftar can see "Profil Pendaftar"  --}}
@if(Auth::user()->roleId() == 2)
<li {{ explode( ".",\Request::route()->getName() )[0] == 'registrants' 
  ? 'class=active treeview menu-open' : '' }}>
  <a href="{{ route('registrants.index') }}">
    <i class="fa fa-user"></i>
    <span>Profil</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li {{ substr( \Request::route()->getName(), 0, 12 ) == 'registrants.' ? 'class=active' : '' }}>
      <a href="{{ route('registrants.index') }}"><i class="fa fa-user"></i> Data Diri</a>
    </li>
  </ul>
</li>
@endif
