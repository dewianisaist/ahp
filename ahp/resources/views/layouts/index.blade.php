<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Seleksi Peserta Pelatihan</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">        
        <link rel="stylesheet" href={{ asset('user_theme/assets/bootstrap/css/bootstrap.min.css') }}>
        <link rel="stylesheet" href={{ asset('user_theme/assets/font-awesome/css/font-awesome.min.css') }}>
        <link rel="stylesheet" href={{ asset('user_theme/assets/css/animate.css') }}>
		<link rel="stylesheet" href={{ asset('user_theme/assets/css/form-elements.css') }}>
        <link rel="stylesheet" href={{ asset('user_theme/assets/css/style.css') }}>
        <link rel="stylesheet" href={{ asset('user_theme/assets/css/media-queries.css') }}>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="user_theme/assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="user_theme/assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="user_theme/assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="user_theme/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="user_theme/assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>
    
        <!-- Loader -->
    	<div class="loader">
    		<div class="loader-img"></div>
    	</div>

		<!-- Top menu -->
		<nav class="navbar navbar-inverse navbar-fixed-top navbar-no-bg" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">Sistem Seleksi Peserta Pelatihan</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="top-navbar-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a class="scroll-link" href="#top-content">Home</a></li>
						<li><a class="scroll-link" href="#features">Program</a></li>
						<li><a class="scroll-link" href="#alur">Alur</a></li>
						<li><a class="scroll-link" href="#tentang">Tentang</a></li>
                        <li><a class="scroll-link" href="#hubungi">Hubungi</a></li>
						<li><a href="/login" target="_blank">Login</a></li>
					</ul>
				</div>
			</div>
		</nav>
        
        @yield('content')
        
        <!-- Footer -->
        <footer>
	        <div class="container">
	            <div class="row">
                    <div class="col-sm-12 footer-copyright">
                    	&copy; 2017-2018 Dewi Anisa Istiqomah
                    </div>
                    <div>Magister Ilmu Komputer Universitas Gadjah Mada</div>
                </div>
	        </div>
        </footer>


        <!-- Javascript -->
        <script src={{ asset('user_theme/assets/js/jquery-1.11.1.min.js') }}></script>
        <script src={{ asset('user_theme/assets/bootstrap/js/bootstrap.min.js') }}></script>
        <script src={{ asset('user_theme/assets/js/jquery.backstretch.min.js') }}></script>
        <script src={{ asset('user_theme/assets/js/wow.min.js') }}></script>
        <script src={{ asset('user_theme/assets/js/retina-1.1.0.min.js') }}></script>
        <script src={{ asset('user_theme/assets/js/waypoints.min.js') }}></script>
        <script src={{ asset('user_theme/assets/js/scripts.js') }}></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>