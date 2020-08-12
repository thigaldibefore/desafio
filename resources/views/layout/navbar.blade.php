<nav class="navbar navbar-expand-md fixed-top am-top-header">
    <div class="container-fluid ">
        <div class="am-navbar-header">
            <div class="page-title"><span>Home</span></div>
            <a class="am-toggle-left-sidebar navbar-toggle collapsed" href="/home"><span
                        class="icon-bar"><span></span><span></span><span></span></span></a><a class="navbar-brand"
                                                                                              href="/home"></a>
        </div>
        <button class="navbar-toggler hidden-md-up collapsed" data-toggle="collapse" data-target="#am-navbar-collapse">
            <span class="icon s7-angle-down"></span></button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="am-navbar-collapse">
            <ul class="nav navbar-nav am-user-nav">
                <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                                        aria-expanded="false"><img
                                src="{{ \Auth::user() ? asset(\Auth::user()->avatar) : ''}}" height="40px" width="40px"><span
                                class="user-name">{{Auth::user()->name}}</span><span class="angle-down s7-angle-down"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><span class="icon s7-user"></span>{{Auth::user()->name}}</li>
                        <div class="dropdown-divider"></div>
                        <li><a href="/logout"> <span class="icon s7-power"></span>Sair</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav am-top-menu">
                <li><a href="/">Home</a></li>
            </ul>
        </div>
        <a id="menuRigth" class="am-toggle-right-sidebar" href="#"><span class="icon s7-menu2"></span></a>
    </div>
</nav>