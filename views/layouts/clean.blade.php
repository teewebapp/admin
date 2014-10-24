<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ Config::get('site.name') }} | Administração</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{ Tee\System\Asset::css() }}
        <!-- css styles -->
        {{ Tee\System\Asset::styles() }}
        <!-- js files (header) -->
        {{ Tee\System\Asset::js('header') }}
        <!-- js scripts (header) -->
        {{ Tee\System\Asset::scripts('header') }}
        <!-- bootstrap 3.0.2 -->
        <link href="{{ moduleAsset('admin', 'css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{ moduleAsset('admin', 'css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{ moduleAsset('admin', 'css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ moduleAsset('admin', 'css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ moduleAsset('admin', 'css/main.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery 1.10.0 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
        <script src="{{ moduleAsset('admin', 'js/knockout-3.2.0.js') }}"></script>
    </head>
    <body class="skin-blue">
        @yield('body_content')
        <!-- Bootstrap -->
        <script src="{{ moduleAsset('admin', 'js/bootstrap.min.js') }}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ moduleAsset('admin', 'js/AdminLTE/app.js') }}" type="text/javascript"></script>
        {{ Tee\System\Asset::js() }}
        {{ Tee\System\Asset::scripts('footer') }}
        <!-- jquery scripts -->
        {{ Tee\System\Asset::scripts('ready') }}
    </body>
</html>