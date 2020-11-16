<link rel="stylesheet" href="/static/css/navbar.css">
<nav class="navb">
    <div class="container">
        <div id="navb-main" class="main">
            <div class="btn home">
                <a href="/">
                    monitoring-station

                </a>
            </div>
            <!-- <div class="btn"><a href="http://">Home</a></div> -->
            <?php
            if (session_status() == PHP_SESSION_NONE)
            {
                session_start();
            }
            if(!isset($_SESSION['user_id']))
            {
                print
                '
                    <div class="btn right">
                        <a href="/user/signin">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In
                        </a>
                    </div>
                ';
            }
            else
            {
                    // <div class="btn dropdown">
                    //     <a href="javascript:void(0)" class="dropdown-btn">
                    //         <i class="fas fa-chart-line"></i>
                    //         Chart
                    //     </a>
                    //     <div class="dropdown-menu">
                    //         <a class="dropdown-link" href="/chart-all">
                    //             <i class="fas fa-reply-all"></i>
                    //             All
                    //         </a>
                    //         <a class="dropdown-link" href="/chart-self">
                    //             <i class="fas fa-user-alt"></i>
                    //             Self
                    //         </a>
                    //     </div>
                    // </div>
                print
                '
                    <div class="btn dropdown">
                        <a href="javascript:void(0)" class="dropdown-btn">
                            <i class="fas fa-clipboard-list"></i>
                            Channels
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-limit">
                                <a class="dropdown-link" href="/channel/all">
                                    <i class="fas fa-reply-all"></i>
                                    All
                                </a>
                                <a class="dropdown-link" href="/channel/self">
                                    <i class="fas fa-user-alt"></i>
                                    Self
                                </a>
                            </div>
                        </div>
                    </div>
                ';
                if($_SESSION['user_is_admin'])
                {
                    print
                    '
                        <div class="btn dropdown right">
                            <a href="javascript:void(0)" class="dropdown-btn">
                                <i class="fas fa-user-shield"></i>
                                Admin
                            </a>
                            <div class="dropdown-menu" style="right:0;">
                                <div class="dropdown-limit">
                                    <a href="/user/signup">
                                        <i class="fas fa-user-plus"></i>
                                        New User
                                    </a>
                                    <a href="/user/signout">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Sign Out
                                    </a>
                                </div>
                            </div>
                        </div>
                    ';
                }
                else{
                    print'
                    <div class="btn right">
                        <a href="/user/signout">
                            <i class="fas fa-sign-out-alt"></i>
                            Sign Out
                        </a>
                    </div>
                    ';
                }
            }
            ?>
            <div class="btn menu-trig right">
                <a href="javascript:void(0)" onclick="triggerNav()">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
    </div>
</nav>