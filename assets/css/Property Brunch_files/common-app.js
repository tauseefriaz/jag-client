$(document).ready(function() {
    $('#header_login').click(function(){
        $('.login-header-box').slideToggle(200);
    });
    

    /* Header search boxes */
    $("[chosen=search]").chosen({
        disable_search_threshold: 2,
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
    
    
    $(".inner-middle-left-menu input[name='type']").change( function () {
        applyFilter();
    });
    
    function applyFilter(){
        $("#left-side-filter-button").trigger('click');
    }
    
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

});