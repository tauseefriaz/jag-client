<? include_once 'includes/header.php'; ?>

<script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/jquery.form.min.js"></script>
<script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/jquery.validate.js"></script>

<!--middle html-->
<div class="middle-main">
    <div class="middle clearfix">
        <div class="detail-page-area">
            <div class="register-left-area">
                <h2>Register an account with Jageer.pk</h2>
                <ul class="register-style">
                    <li><span>Selling HUD Homes</span></li>
                    <li>Register to Sell HUD Homes</li>
                    <li>Glosssary of Listing Codes</li>
                    <li>Introduction to selling HUD Homes</li>
                    <li>Current listings - find homes on our Marketing and Management (M M) contractors' website</li>
                    <li>Good Neighbor Next Door</li>
                    <li><span>Help For Your Buyers</span></li>
                    <li>HUD Homes For Sale</li>
                    <li>Local homeownership assistance programs</li>
                    <li>Housing counseling - free or low-cost counseling services for buying, renting, defaults, foreclosure, credit issues and reverse mortgages </li>
                    <li>Homeownership voucher program - some Housing Choice (Section 8) voucher holders may be able to purchase a home</li>
                    <li>Avoid foreclosure - help for former clients that may be facing foreclosure</li>
                    <li><span>General Information</span></li>
                    <li>SAMS Broker Application</li>
                    <li>SAMS Selling Broker Certification</li>
                    <li>Redelegation of Authority -- M</li>
                    <li>M&M Contractors and Information</li>
                    <li>Real Estate Settlement Procedure Act (RESPA)</li>
                    <li>Settlement costs</li>
                    <li>Healthy homes and lead hazard control</li>
                    <li>Manufactured housing</li>
                </ul>
            </div>
            <div class="register-right-area">
                <div class="container6">
                    <ul class="tabs6">
                        <li tab-id="#tab1" class="tab1">Create an account</li>
                        <li tab-id="#tab2" class="tab2">Log in</li>
                    </ul>
                    <div class="tab_container6">
                        <div id="tab1" class="tab_content6">
                            <form method="POST" action="<?= base_url("login/create_account") ?>" id="register-main">

                                <div class="register-label">Your Name</div>
                                <div id="er-name" style="position: relative; height: 5px;"></div>
                                <input type="text" class="register-input in_put1" name="name" placeholder="Your Name">

                                <div class="register-label">Your Email Address</div>
                                <div id="er-email"  style="position: relative;  height: 5px;"></div>
                                <input type="text" class="register-input in_put1" name="email" placeholder="Email Address">

                                <div class="register-label">Password</div>
                                <div id="er-password"  style="position: relative;  height: 5px;"></div>
                                <input type="text" class="register-input in_put1" name="password" id="password" placeholder="Password">

                                <div class="register-label">Verify Password</div>
                                <div id="er-verify-password"  style="position: relative;  height: 5px;"></div>
                                <input type="text" class="register-input in_put1" name="verify-password" id="verify-password" placeholder="Verify Password">

                                <span style="display: none;">
                                    <div class="register-captcha">
                                        <img height="40" src="http://wpcontent.answcdn.com/wikipedia/commons/6/69/Captcha.jpg" alt="" />
                                    </div>

                                    <input type="text" class="register-input in_put1" name="captcha" placeholder="Type the characters you see above">
                                </span>

                                <div class="register-message"></div>

                                <input type="submit" class="green-button login_register" value="Create an Account"> 

                                <div class="re-text"><input type="checkbox" class="checkbox" checked> Sign up for jageer newsletters</div>
                                <div class="re-text"><span>By clicking Create an Account you confirm that you agree to our website <a href="#">terms of use</a> and our <a href="#">privacy policy.</a></span></div>

                            </form>
                        </div>

                        <div id="tab2" class="tab_content6">

                            <form method="POST" action="<?= base_url('login/verify') ?>" id="login-main">
                                <div class="register-label">Your Email Address</div>
                                <div id="er-login-email" style="position: relative; height: 5px;"></div>
                                <input type="text" class="register-input in_put1" name="email" placeholder="Your Email">

                                <div class="register-label">Your Password</div>
                                <div id="er-login-password" style="position: relative; height: 5px;"></div>
                                <input type="password" class="register-input in_put1" name="password" placeholder="Your Password">

                                <div class="register-message"></div>

                                <input type="submit" class="green-button login_register" value="Sign In">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".tab_content6").hide(); 
            $("ul.tabs6 li:first").addClass("active6").show(); 
            $(".tab_content6:first").show(); 
            $("ul.tabs6 li").click(function() {
                $("ul.tabs6 li").removeClass("active6"); 
                $(this).addClass("active6"); 
                $(".tab_content6").hide(); 
                var activeTab = $(this).attr("tab-id"); 
                $(activeTab).fadeIn(); 
                return false;
            });
            
<? if ($this->uri->segment('1') == 'login') { ?>
            $('.tab2').trigger('click');
<? } ?>
    
<? if ($error = $this->input->get('error')) {
    if ($error == 1) $error_msg = "Invalid email or password."; if ($error == 2) $error_msg = "Session expired or not logged in."; ?>
            $('#login-main .register-message').html('<?= $error_msg ?>').attr('style','border-color: #de7272; background-color: #ffd4d4;').fadeIn('fast');
<? } ?>
            
        $('#register-main').ajaxForm({
            beforeSubmit : function() { 
                return $('#register-main').validate({
                    rules: {
                        "name": {
                            minlength: 2,
                            maxlength: 50,
                            required: true
                        }, 
                        "email": {
                            required: true,
                            email: true
                        },
                        "password": {
                            minlength: 6,
                            maxlength: 20,
                            required: true
                        }, 
                        "verify-password": {
                            equalTo: "#password",
                            required: true
                        }
                    },
                    errorPlacement: function (error, element) {
                             
                        $('#er-'+element.attr('name')).html(error).find('label').addClass('error-label')
                    }
                }).form() ;
            },
            target: '#register-main .register-message',
            success: function(data) {
                if(data=='success'){
                    $('#register-main .register-message').attr('style','border-color: green; background-color: #D5FF9C;').fadeIn('fast');
                    window.location.href = base_url+"bench/dashboard";
                }else{
                    $('#register-main .register-message').attr('style','border-color: #de7272; background-color: #ffd4d4;').fadeIn('fast');
                }
                    
            }
        }); 
            
        $('#login-main').ajaxForm({
            beforeSubmit : function() { 
                return $('#login-main').validate({
                    rules: {
                        "email": {
                            required: true,
                            email: true
                        },
                        "password": {
                            minlength: 6,
                            maxlength: 20,
                            required: true
                        }
                    },
                    errorPlacement: function (error, element) {
                             
                        $('#er-login-'+element.attr('name')).html(error).find('label').addClass('error-label')
                    }
                }).form() ;
            },
            target: '#login-main .register-message',
            success: function(data) {
                if(data=='success'){
                    $('#login-main .register-message').attr('style','border-color: green; background-color: #D5FF9C;').fadeIn('fast');
                    window.location.href = base_url+"bench/dashboard";
                }else{
                    $('#login-main .register-message').attr('style','border-color: #de7272; background-color: #ffd4d4;').fadeIn('fast');
                }
                    
            }
        });
    
    });
    </script>
</div>
<!--middle html end-->
<? include_once 'includes/footer.php'; ?>