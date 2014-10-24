<div class="user-panel">
    <div class="pull-left image">
        <img src="{{{ Auth::user()->image }}}" class="img-circle" alt="User Image" />
    </div>
    <div class="pull-left info">
        <p>Olá, <br /> {{{ Auth::user()->name }}}</p>

        <!--
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        -->
    </div>
</div>