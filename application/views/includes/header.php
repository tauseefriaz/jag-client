<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?= !empty($SiteTitle) ? $SiteTitle : $parameters["init_settings"][1]['title']; ?></title>
        <meta name="description" content="<?= !empty($SiteDescription) ? $SiteDescription : $parameters["init_settings"][1]['description']; ?>" />
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <script type="text/javascript" src="<?= ASSETS_URL ?>js/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="<?= ASSETS_URL ?>js/common-app.js"></script>
        <script type="text/javascript" src="<?= ASSETS_URL ?>js/jquery.pjax.js"></script>

        <script type="text/javascript" src="<?= ASSETS_URL ?>js/chosen.jquery.js"></script>
        <link href="<?= ASSETS_URL ?>css/chosen.css" rel="stylesheet" type="text/css">

        <link href="<?= ASSETS_URL ?>css/reset.css" rel="stylesheet" type="text/css">
        <link href="<?= ASSETS_URL ?>css/main.css" rel="stylesheet" type="text/css">


        <link href="<?= ASSETS_URL ?>bootstrap/reveal.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?= ASSETS_URL ?>bootstrap/jquery.reveal.js"></script>

        <?
        if (!empty($properties["pagination_data"]['rel_meta_links'])) {
            echo $properties["pagination_data"]['rel_meta_links'];
        }
        ?>
    </head>
    <?
    if (!empty($parameters["p_cities"])) {
        foreach ($parameters["p_cities"] as $dataChunk):
            $citiesArray[$dataChunk["state_id"]]['0' . $dataChunk["id"]] = ucwords(trim($dataChunk["name"]));
        endforeach;
    }
    if (!empty($parameters["p_locations"])) {
        foreach ($parameters["p_locations"] as $dataChunk):
            $locationsArray[$dataChunk["city_id"]]['0' . $dataChunk["id"]] = ucwords(trim($dataChunk["name"]));
        endforeach;
    }
    if (!empty($parameters["p_sub_locations"])) {
        foreach ($parameters["p_sub_locations"] as $dataChunk):
            $subLocationsArray[$dataChunk["parent_id"]]['0' . $dataChunk["id"]] = ucwords(trim($dataChunk["name"]));
        endforeach;
    }
    ?>
    <script>
        var statesArray         = <?= json_encode($parameters["p_states"]) ?>;
        var citiesArray         = <?= json_encode($citiesArray) ?>;
        var locationsArray      = <?= json_encode($locationsArray) ?>;
        var subLocationsArray   = <?= json_encode($subLocationsArray) ?>;
    </script>
    <body>
        <div class="main-rawp">
            <!--header top bar html-->
            <div class="header-topbar-main">
                <div class="header-topbar clearfix">
                    <div class="header-logo"><img style="height: 30px;" src="<?= ASSETS_URL ?>images/top_logo.png" alt="Property Brunch" /></div>

                    <ul class="nav-top">
                        <? foreach ($parameters["p_main_types"] as $dataChunk): ?><li><a href="<?= base_url($dataChunk['slug']) ?>"><?= $dataChunk['name'] ?></a></li><? endforeach; ?><li><a href="#">Blog</a></li><li><a href="#">Contact Us</a></li>
                    </ul>

                    <? if (empty($this->sessionUserData)): ?>
                        <div class="header-user-area">
                            <a href="# Login" id="header-login">Log in</a> | <a href="<?= base_url('register/') ?>" >Create An Account</a>
                        </div>
                        <div class="login-header-box">
                            <form action="<?= base_url('login/verify') ?>" method="POST">
                                <input type="text" name="email" class="in_put1 header-topbar-inputs" placeholder="Email address">
                                <input type="password" name="password" class="in_put1 header-topbar-inputs" placeholder="Password">
                                <input type="submit" id="header_login" class="blue-button header-login-button" value="Log in">
                                <a href="<?= base_url('forgot-password') ?>">Forgot Password</a>
                            </form>
                        </div>
                    <? else: ?>
                        <div class="header-user-area">
                            Hello! <?= $this->sessionUserData["name"] ?> | 
                            <a href="<?= base_url('bench/dashboard/') ?>">myJageer</a> | 
                            <a href="<?= base_url('bench/messages/') ?>">Messages</a> | 
                            <a href="<?= base_url('logout/') ?>">Logout</a>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <!--header top bar html end-->
            <? if ($this->uri->segment(1) != "bench"): ?>
                <!--header html-->

                <div class="header-main">
                    <div class="inner-header-main clearfix"> 
                        <a href="<?= base_url() ?>" class="logo">
                            <img style="height: 50px;" src="<?= ASSETS_URL ?>images/logo.png" alt="Property Brunch" />
                        </a>
                        <div class="inner-head-img"></div>
                    </div>
                    <div class="inner-top-line"></div>
                </div>

                <!--header html end-->
            <? else: ?>
                <link href="<?= ASSETS_URL ?>css/bench/main-bench.css" rel="stylesheet" type="text/css">
                <script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/common-bench-app.js"></script>

                <script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/jquery.form.min.js"></script>
                <script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/jquery.validate.js"></script>

                <script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/jquery.dataTables.min.js"></script>
                <link href="<?= ASSETS_URL ?>css/bench/jquery.dataTables.css" rel="stylesheet" type="text/css">

                <script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/jquery.uploadifive.min.js"></script>
                <link href="<?= ASSETS_URL ?>css/bench/uploadifive.css" rel="stylesheet" type="text/css">


                <div style="height: 50px;"></div>

                <? $active_menu = $this->uri->segment(2); ?>
                <div class="bench_nav clearfix">
                    <ul>
                        <li><a class="<? echo $active_menu == 'dashboard' ? 'active' : ''; ?>" href="<?= base_url('bench/dashboard/') ?>">Dashboard</a></li>
                        <li><a class="<? echo $active_menu == 'listings' ? 'active' : ''; ?>" href="<?= base_url('bench/listings/') ?>">Listings</a>
                            <ul style="display: none;">
                                <li><a href="#">Rental</a></li>
                                <li><a href="#">Sales</a></li>
                                <li style="display: none;"><a href="#">Web Design</a>
                                    <ul>
                                        <li><a href="#">Test 1</a></li>
                                        <li><a href="#">Test 2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a class="<? echo $active_menu == 'contacts' ? 'active' : ''; ?>" href="<?= base_url('bench/contacts/') ?>">Contacts</a></li>
                        <li><a class="<? echo $active_menu == 'leads' ? 'active' : ''; ?>" href="<?= base_url('bench/leads/') ?>">Leads</a></li>
                        <li><a class="<? echo $active_menu == 'messages' ? 'active' : ''; ?>" href="<?= base_url('bench/messages/') ?>">Messages</a></li>
                        <li><a class="<? echo $active_menu == 'sms' ? 'active' : ''; ?>" href="<?= base_url('bench/sms/') ?>">SMS</a></li>
                        <li><a class="<? echo $active_menu == 'reports' ? 'active' : ''; ?>" href="<?= base_url('bench/reports/') ?>">Reports</a></li>
                        <li><a class="<? echo $active_menu == 'profile' ? 'active' : ''; ?>" href="<?= base_url('bench/profile/') ?>">Profile</a></li>
                        <li><a class="<? echo $active_menu == 'users' ? 'active' : ''; ?>" href="<?= base_url('bench/users/') ?>">Users</a></li>
                    </ul>
                </div>

            <? endif; ?>

            <script>
                var base_url = '<?= base_url() ?>';
            </script>