<? include_once 'includes/header.php'; ?>
<!--middle html-->

<div class="overflow-hidden" style="width:100%;">
    <div class="homepage-search-picture">
        <form action="<?= base_url() ?>search-results/" method="GET">
        <div class="homepage-search-area">
            
            <div class="styled-select-searchbox left-search-filter-selects">
                <select chosen="search" class="left-filter-chose-items select-120px" data-placeholder="Type" id="cities" name="type">
                    <? foreach ($parameters["p_main_types"] as $dataChunk): ?>
                        <option value="<?= $dataChunk["id"] ?>"><?= $dataChunk["name"] ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="styled-select-searchbox left-search-filter-selects">
                <select chosen="search" class="left-filter-chose-items select-150px" id="property_sub_type" name="property_sub_type">
                    <option value="">Property Type</option>
                    <?
                    foreach ($parameters["p_types"] as $dataChunk):
                        $typesArray[$dataChunk["parent_id"]][$dataChunk["id"]] = ucwords(trim($dataChunk["name"]));
                    endforeach;
                    ?>
                    <? foreach ($typesArray[0] as $mainKey => $mainValue): ?>
                        <optgroup label="<?= $mainValue ?>">
                            <? foreach ($typesArray[$mainKey] as $subKey => $subValue): ?>
                                <option type="<?= $mainKey ?>" value="<?= $subKey ?>"><?= $subValue ?></option>
                            <? endforeach; ?>
                        </optgroup>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="styled-select-searchbox left-search-filter-selects">
                <select chosen="search" class="left-filter-chose-items select-150px" data-placeholder="Select Cities" id="cities" name="cities">
                    <option value="">City</option>
                    <? foreach ($parameters["p_cities"] as $dataChunk): ?>
                        <option value="<?= $dataChunk["id"] ?>"><?= $dataChunk["name"] ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <button type="submit" class="green-button home-search-button">Go Search!</button>

        </div>
        </form>
    </div>

    <img class="hero" src="<?= ASSETS_URL ?>images/searchBanner.jpg" alt="Cottages" width="100%" style="min-height: 150px; min-width: 1200px;">


</div>

<div class="middle-main">
    <div class="middle-box1 clearfix">
        <div class="container">
            <ul class="tabs">
                <div class="tab-heading">Featured <span>Properties</span></div>
                <li><a href="#tab1">New Properties</a></li>
                <li><a href="#tab2">Bahira Town</a></li>
            </ul>
            <div class="tab_container">
                <div id="tab1" class="tab_content">
                    <div id='left_scroll'><a href='javascript:slide("left");'><img src='<?= ASSETS_URL ?>images/right.png' /></a></div>
                    <div id='right_scroll'><a href='javascript:slide("right");'><img src='<?= ASSETS_URL ?>images/left.png' /></a></div>
                    <div id='carousel_inner'>
                        <ul id='carousel_ul'>
                            <? foreach ($latest_properties as $dataChunk): ?>
                                <li>
                                    <a href='#'><img src="<?= ASSETS_URL ?>images/img1.jpg" alt="" /></a>
                                    <div class="caro-text">
                                        <?= substr($dataChunk['title'],0, 24) ?>...
                                        <span><?= $parameters['p_cities'][$dataChunk["area_city_id"]]['name'] ?></span>
                                    </div>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div id="tab2" class="tab_content"> Content being updated! Please check back later. </div>
            </div>
        </div>
        <img src="<?= ASSETS_URL ?>images/middle-left-banner1.jpg" class="middle-left-banner1" alt="" /> </div>
</div>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $(".tab_content").hide(); 
            $("ul.tabs li:first").addClass("active").show(); 
            $(".tab_content:first").show(); 
            $("ul.tabs li").click(function() {
                $("ul.tabs li").removeClass("active"); 
                $(this).addClass("active"); 
                $(".tab_content").hide(); 
                var activeTab = $(this).find("a").attr("href"); 
                $(activeTab).fadeIn(); 
                return false;
            });
        });
    });
    $(document).ready(function() {
        var auto_slide = 1;
        var hover_pause = 1;
        var key_slide = 1;
        var auto_slide_seconds = 5000;
        $('#carousel_ul li:first').before($('#carousel_ul li:last')); 
        if(auto_slide == 1){
            var timer = setInterval('slide("right")', auto_slide_seconds); 
            $('#hidden_auto_slide_seconds').val(auto_slide_seconds);
        }
        if(hover_pause == 1){
            $('#carousel_ul').hover(function(){
                clearInterval(timer)
            },function(){
                timer = setInterval('slide("right")', auto_slide_seconds); 
            });
        }
        if(key_slide == 1){
            $(document).bind('keypress', function(e) {
                if(e.keyCode==37){
                    slide('left');
                }else if(e.keyCode==39){
                    slide('right');
                }
            });
        }  
    }); 
    function slide(where){
        var item_width = $('#carousel_ul li').outerWidth() + 10;
        if(where == 'left'){
            var left_indent = parseInt($('#carousel_ul').css('left')) + item_width;
        }else{
            var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;
        }
        $('#carousel_ul:not(:animated)').animate({'left' : left_indent},500,function(){    
            if(where == 'left'){
                $('#carousel_ul li:first').before($('#carousel_ul li:last'));
            }else{
                $('#carousel_ul li:last').after($('#carousel_ul li:first')); 
            }
            $('#carousel_ul').css({'left' : '-210px'});
        });  
    }
</script>
<!--middle html end-->
<? include_once 'includes/footer.php'; ?>