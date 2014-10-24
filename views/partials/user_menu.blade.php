<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="glyphicon glyphicon-user"></i>
    <span>{{{ Auth::user()->name }}} <i class="caret"></i></span>
</a>
<ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header bg-light-blue">
        <img src="{{ Auth::user()->image }}" class="img-circle" alt="User Image" />
        <p>
            {{{ Auth::user()->name }}}
            <small>Administrador</small>
        </p>
    </li>
    <!-- Menu Body -->
    {{--
    <li class="user-body">
        <div class="col-xs-4 text-center">
            <a href="#">Followers</a>
        </div>
        <div class="col-xs-4 text-center">
            <a href="#">Sales</a>
        </div>
        <div class="col-xs-4 text-center">
            <a href="#">Friends</a>
        </div>
    </li>
    --}}

    <!-- Menu Footer-->
    <li class="user-footer">
        <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Informações</a>
        </div>
        <div class="pull-right">
            <a href="{{{ URL::to('/logout') }}}" class="btn btn-default btn-flat">Sair</a>
        </div>
    </li>
</ul>