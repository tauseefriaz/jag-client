$(document).ready(function() {
    $('#header-login').click(function(){
        $('.login-header-box').slideToggle(200);
    });
    
    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y > 100) {
            $('.header-logo').animate({
                width: 'show'
            });
        } else {
            $('.header-logo').animate({
                width: 'hide'
            });
        }
    });
    
    jQuery.fn.slideLeftHide = function(speed, callback) { 
        this.animate({ 
            width: "hide", 
            paddingLeft: "hide", 
            paddingRight: "hide", 
            marginLeft: "hide", 
            marginRight: "hide" 
        }, speed, callback);
    }

    jQuery.fn.slideLeftShow = function(speed, callback) { 
        this.animate({ 
            width: "show", 
            paddingLeft: "show", 
            paddingRight: "show", 
            marginLeft: "show", 
            marginRight: "show" 
        }, speed, callback);
    }
    /* Header search boxes */
    $("[chosen=search]").chosen({
        disable_search_threshold: 4,
        no_results_text: "Oops, nothing found!",
        width: "158px",
        inherit_select_classes: true
    });
        
    var statesField = ".inner-middle-left-menu #states";
    var citiesField = ".inner-middle-left-menu #cities";
    var locationsField = ".inner-middle-left-menu #locations";
    var subLocationsField = ".inner-middle-left-menu #sub_locations";
                    
    $(statesField).change( function () {
        plotLocations(citiesArray[$(this).val()], citiesField);
    });
                    
    $(citiesField).change( function () {
        plotLocations(locationsArray[$(this).val()], locationsField);
    });
                    
    $(locationsField).change( function () {
        plotLocations(subLocationsArray[$(this).val()], subLocationsField);
    });
                    
                    
    function plotLocations(locationData, field){
        var optionsString = '<option id="" value="0">Select</option>';
        if(locationData!=undefined){
            $.each(locationData, function(id,name){
                optionsString += '<option value="'+id * 1+'">'+name+'</option>';
            });
        }
                        
        $(field).html(optionsString);
        $(field).trigger("chosen:updated");
        $(field).attr('disabled', false).trigger("chosen:updated");
    }
    
    /* Header search boxes end */
    
    
    $(".inner-middle-left-menu select, .inner-middle-left-menu input[name='type']").change( function () {
        applyFilter();
    });
    
    function applyFilter(){
        $("#left-side-filter-button").trigger('click');
    }
    
    $(".inner-middle-left-menu .reset-filter").click( function () {
        window.location.href = base_url+"search-results/";
    });
    
    
    $(function(){
        var pop = function(){
            $('#darkout-div').css({
                "display": "block", 
                opacity: 0.7, 
                "width":$(document).width(),
                "height":$(document).height()
            });
            $('#box').css({
                "display": "block"
            }).click(function(){
                $(this).css("display", "none");
                $('#screen').css("display", "none")
            });
        }
        $('#button').click(pop);
    });
    
    /* show hide phone no */
                
    $(document).on("click",".show-phone-number", function(e){
        e.preventDefault();
        $('.blue-button').fadeOut('fast', function(){
            $('.phone-no-details').fadeIn('fast');
        });
    });
    
    $(document).on("click",".show-phone-no-small", function(e){
        if($(this).hasClass('show-phone-no-small')){
            var property_id = $(this).attr('property_id');
            var user_id     = $(this).attr('user_id');
            $('#'+property_id+' .phone-no-details').html('Loading..');
            $.post(base_url+"operations/get_phone_number", {
                property_id: property_id,
                user_id:user_id
            }, function(data) {
                $('#'+property_id+' .phone-no-details').html(data);
            });
        }
        e.preventDefault();
        $('#'+property_id+' .blue-button').fadeOut('fast', function(){
            $('#'+property_id+' .phone-no-details').fadeIn('fast');
        });
    });
    
    $("#enq-send").click(function(e){
        var enq_name            = $("#enq-name");
        var enq_email           = $("#enq-email");
        var enq_number          = $("#enq-number");
        var enq_message         = $("#enq-message");
        var enq_status          = $("#enq-status");
        var enq_status_red      = enq_status.css("color", "red");
        var enq_form            = $("#enq-form");
        
        enq_form.find("input").attr('style', 'border-color:#dadada !important;');
        
        if(enq_name.val()=="" || enq_name.val().length<2){
            enq_name.attr('style', 'border-color:red !important;');
            enq_status.html("Please enter a proper name.").enq_status_red;
        }else if(!isValidEmailAddress( enq_email.val() )){
            enq_email.attr('style', 'border-color:red !important;');
            enq_status.html("Please enter a valid email.").enq_status_red;
        }else if(!$.isNumeric(enq_number.val()) || enq_number.val().length<5){
            enq_number.attr('style', 'border-color:red !important;');
            enq_status.html("Please enter a valid phone number.").enq_status_red;
        }else if(enq_message.val()=="" || enq_message.val().length<5){
            enq_message.attr('style', 'border-color:red !important;');
            enq_status.html("Please type in a proper message.").enq_status_red;
        }else{
            $.post(base_url+"operations/send_enquiry_email",
                jQuery(enq_form).serialize(), function(data) {
                    alert(data);
                });
            enq_form.find("input").attr('style', 'border-color:#dadada !important;');
            enq_status.html("Enquiry sent successfully.").css("color", "green");
        }
        
    });
    
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    };

});