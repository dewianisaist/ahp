<li {{ substr( \Request::route()->getName(), 0, 19 ) == 'manage_alternatives.' ? 'class=active' : '' }}>
  <a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-users"></i> <span>Data Pendaftar</span></a>
</li>

<li {{ substr( \Request::route()->getName(), 0, 11 ) == 'selections.' ? 'class=active' : '' }}>
  <a href="{{ route('selections.index') }}"><i class="fa fa-balance-scale"></i>  <span>Nilai Seleksi</span></a>
</li>

<li {{ explode( ".",\Request::route()->getName() )[0] == 'criterias' || 
  explode( ".",\Request::route()->getName() )[0] == 'criteriagroup' 
  ? 'class=active treeview menu-open' : '' }}>
  <a href="{{ route('criteriagroup.index') }}">
    <i class="fa fa-list"></i>
    <span>Kriteria</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li {{ substr( \Request::route()->getName(), 0, 14 ) == 'criteriagroup.' ? 'class=active' : '' }}>
      <a href="{{ route('criteriagroup.index') }}"><i class="fa fa-list"></i> Hierarki Kriteria</a>
    </li>
  </ul>
</li>

<li {{ substr( \Request::route()->getName(), 0, 8 ) == 'weights.' ? 'class=active' : '' }}>
  <a href="{{ route('weights.index') }}"><i class="fa fa-balance-scale"></i>  <span>Bobot</span></a>
</li>

<li {{ explode( ".",\Request::route()->getName() )[0] == 'preferences' || 
  explode( ".",\Request::route()->getName() )[0] == 'result_selection' ||
  explode( ".",\Request::route()->getName() )[0] == 'result' 
  ? 'class=active treeview menu-open' : '' }}>
  <a href="{{ route('preferences.index') }}">
    <i class="fa fa-hourglass-half"></i>
    <span>Penilaian</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li {{ substr( \Request::route()->getName(), 0, 12 ) == 'preferences.' ? 'class=active' : '' }}>
      <a href="{{ route('preferences.index') }}"><i class="fa fa-hourglass-half"></i> Tipe Preferensi</a>
    </li>
    <li {{ substr( \Request::route()->getName(), 0, 17 ) == 'result_selection.' ? 'class=active' : '' }}>
      <a href="{{ route('result_selection.index') }}"><i class="fa fa-hourglass-half"></i> Data Alternatif</a>
    </li>
    <li {{ substr( \Request::route()->getName(), 0, 7 ) == 'result.' ? 'class=active' : '' }}>
      <a href="{{ route('result.index') }}"><i class="fa fa-hourglass-half"></i> Hasil</a>
    </li>
  </ul>
</li>