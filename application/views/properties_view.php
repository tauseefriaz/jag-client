<? if ($AJAX_REQUEST != 1): include_once 'includes/header.php'; ?>
    <script>       
        $(document).ready(function() {
            $.pjax.defaults.timeout = 2000;                 
            $(document).on('click', '.page_navigation a', function(event) {
                $.pjax.click(event, '.container4',{'fragment':'.container4'})
            })
                                                                                                                                                                                                                    
            $(document).on('pjax:beforeSend', function() {
            })
                                                                                                                                                                                                                    
            $(document).on('pjax:complete', function() {
                //alert();
            })
            $(document).on('#left-search-form submit', 'form[data-pjax]', function(event) {
                $.pjax.submit(event, '.container4',{'fragment':'.container4'});
            });
        });        
    </script>
    <!--middle html-->
    <div class="middle-main">

        <div class="middle clearfix">
            <form action="<?= base_url() ?>search-results/" id="left-search-form" method="GET" data-pjax-remote="push" data-pjax>
                <div class="inner-middle-left-menu">
                    <div class="inner-left-menu-heading">Filter Your Result</div>

                    <div class="inner-left-menu-heading2">Keyword</div>
                    <ul class="check-list">
                        <li>
                            <input type="text" class="in_put1 in_put3" name="keyword" placeholder="e.g DHA, Bahria etc" value="<?= $this->input->get('keyword') ?>">
                            <input type="submit" id="left-side-filter-button" class="search-button" style="float:right;" value="&#9906;">
                        </li>
                    </ul>

                    <div class="inner-left-menu-heading2">Type</div>
                    <ul class="check-list">
                        <? foreach ($parameters["p_main_types"] as $dataChunk): ?>
                            <li>
                                <input name="type" type="radio" class="checkbox" value="<?= $dataChunk["id"] ?>"<? if ($dataChunk["id"] == $this->input->get('type')) echo " checked"; ?>><?= $dataChunk["name"] ?> <span><?= rand(199, 2009) ?></span>
                            </li>
                        <? endforeach; ?>
                    </ul>


                    <div class="inner-left-menu-heading2">Property Type</div>
                    <div class="styled-select-searchbox left-search-filter-selects">
                        <select chosen="search" class="left-filter-chose-items" id="property_sub_type" name="property_sub_type">
                            <option value="">Select Type</option>
                            <?
                            foreach ($parameters["p_types"] as $dataChunk):
                                $typesArray[$dataChunk["parent_id"]][$dataChunk["id"]] = ucwords(trim($dataChunk["name"]));
                            endforeach;
                            ?>
                            <? foreach ($typesArray[0] as $mainKey => $mainValue): ?>
                                <optgroup label="<?= $mainValue ?>">
                                    <? foreach ($typesArray[$mainKey] as $subKey => $subValue): ?>
                                        <option type="<?= $mainKey ?>" value="<?= $subKey ?>"<? if ($subKey == $this->input->get('property_sub_type')) echo " selected"; ?>><?= $subValue ?></option>
                                    <? endforeach; ?>
                                </optgroup>
                            <? endforeach; ?>
                        </select>
                    </div>

                    <div class="inner-left-menu-heading2">Cities</div>
                    <div class="styled-select-searchbox left-search-filter-selects">
                        <select chosen="search" class="left-filter-chose-items" data-placeholder="Select Cities" id="cities" name="cities">
                            <option value="">Select a city</option>
                            <? foreach ($parameters["p_cities"] as $dataChunk): ?>
                                <option value="<?= $dataChunk["id"] ?>"<? if ($subKey == $this->input->get('cities')) echo " selected"; ?>><?= $dataChunk["name"] ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>

                    <div class="inner-left-menu-heading2">Locations</div>
                    <div class="styled-select-searchbox left-search-filter-selects">
                        <select chosen="search" class="left-filter-chose-items" data-placeholder="Select Location" id="locations" name="locations" disabled="disabled">
                        </select>
                    </div>

                    <div class="inner-left-menu-heading2">Sub-Locations</div>
                    <div class="styled-select-searchbox left-search-filter-selects">
                        <select chosen="search" class="left-filter-chose-items" data-placeholder="Select Sub Location" multiple id="sub_locations" name="sub_locations[]" disabled="disabled">
                        </select>
                    </div>

                    <div class="inner-left-menu-heading2">Bedrooms</div>
                    <ul class="check-list">
                        <li>
                            <input type="text" name="min_beds" id="min_beds" class="searchbox-left-range in_put1" placeholder="Min">
                            <input type="text" name="max_beds" id="max_beds" class="searchbox-left-range in_put1" placeholder="Max">
                            <input type="submit" id="left-side-filter-button" class="search-button" style="float:right;" value="&#9906;">
                        </li>
                    </ul>
                    <div class="inner-left-menu-heading2">Price</div>
                    <ul class="check-list">
                        <li>
                            <input type="text" name="min_price" id="min_price" class="searchbox-left-range in_put1" placeholder="Min">
                            <input type="text" name="max_price" id="max_price" class="searchbox-left-range in_put1" placeholder="Max">
                            <input type="submit" id="left-side-filter-button" class="search-button" style="float:right;" value="&#9906;">
                        </li>
                    </ul>
                    <div class="inner-left-menu-heading2">Area</div>
                    <ul class="check-list">
                        <li>
                            <input type="text" name="min_area" id="min_area" class="searchbox-left-range in_put1" placeholder="Min">
                            <input type="text" name="max_area" id="max_area" class="searchbox-left-range in_put1" placeholder="Max">
                            <input type="submit" id="left-side-filter-button" class="search-button" style="float:right;" value="&#9906;">
                        </li>
                    </ul>
                    <div class="inner-left-menu-heading2">Parking</div>
                    <ul class="check-list">
                        <li>
                            <input type="text" name="min_parking" class="searchbox-left-range in_put1" placeholder="Min">
                            <input type="text" name="max_parking" class="searchbox-left-range in_put1" placeholder="Max">
                            <input type="submit" id="left-side-filter-button" class="search-button" style="float:right;" value="&#9906;">
                        </li>
                    </ul>

                    <div><button type="button" onclick="return false;" class="green-button reset-filter"> Reset Search Filter </button></div>
                </div>
            </form>
        <? endif; ?>
        <div class="container4">
            <? if (!empty($breadcrumb)): ?>
                <div class="breadcrumb"> Jageer 
                    <?
                    $CrumbCount = 0;
                    $TotalCrumb = count($breadcrumb);
                    foreach ($breadcrumb as $dataChunk):++$CrumbCount;
                        ?>
                        <? if ($CrumbCount == $TotalCrumb) { ?> 
                            &#8605; <?= $dataChunk['name'] ?> 
                        <? } else { ?> 
                            &#8605; <a href="<?= $dataChunk['link'] ?>"><?= $dataChunk['name'] ?></a>
                        <? } ?>
                    <? endforeach; ?>
                    <span style="display: inline-block; position:absolute; padding: 7px 0 0 5px; font-size: 11px;">&#10549;</span>
                </div>
            <? endif; ?>

            <? if (!empty($mTagsAndCats['links'])): ?>

                <div class="categories-box">
                    <? foreach ($mTagsAndCats['links'] as $dataChunk): ?>
                        <div><a <? if (@$dataChunk['glow'] == 1) echo 'class="glow-category"'; ?> href="<?= $dataChunk['link'] ?>"><?= $dataChunk['name'] ?></a></div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
            <? if (!empty($properties["listings"])) { ?>
                <ul class="tabs4">
                    <li><a href="#tab11">Result Review</a></li>
                    <li><a href="#tab12">View On Map</a></li>
                    <li><a href="#tab13">Compare</a></li>
                    <div class="styled-select3">
                        <select>
                            <option value="office">Price (Low to High)</option>
                            <option value="office">Price (High to Low)</option>
                            <option value="office">Date (New to Old)</option>
                            <option value="office">Date (Old to New)</option>
                        </select>
                    </div>
                    <div class="tab4-text1"><?= $properties["listingsCounts"] ?></div>
                </ul>
                <? foreach ($properties["listings"] as $listingData): ?>
                    <div class="tab4-inner-box" id="<?= $listingData["id"] ?>">
                        <?
                        $propLink[1] = @$listingData["area"];
                        $propLink[2] = @$parameters["p_types"][$listingData["type_id"]]["slug"];
                        $propLink[3] = @$parameters["p_types"][$listingData["sub_type_id"]]["slug"];
                        $propLink[4] = @$parameters["p_main_types"][$listingData["main_type_id"]]["slug"];
                        $propLink[5] = "in";
                        $propLink[6] = @$parameters["p_cities"][$listingData["area_city_id"]]["slug"];
                        $propLink[7] = @$parameters["p_locations"][$listingData["area_location_id"]]["slug"];
                        $propLink[8] = @$parameters["p_sub_locations"][$listingData["area_sub_location_id"]]["slug"];
                        $propLink[9] = @$listingData["id"];

                        $propLinkUrl = implode('-', array_filter($propLink));
                        ?>
                        <div class="tab4-inner-box-top">
                            PK-<?= $listingData["ref"] ?>
                            <span>
                                <?= $listingData["beds"] ?>-bed | 
                                <?= $parameters["p_types"][$listingData["type_id"]]["name"] ?> | 
                                <?= $parameters["p_cities"][$listingData["area_city_id"]]["name"] ?> | 
                                <?= $parameters["p_locations"][$listingData["area_location_id"]]["name"] ?> | 
                                <?= $listingData["area_sub_location_id"] ? $parameters["p_sub_locations"][$listingData["area_sub_location_id"]]["name"] : ""; ?> 
                            </span> 
                            <span class="tab4-inner-box-top1">
                                <?= number_format($listingData["price"]) ?> <?= $parameters["init_settings"][1]['currency_code'] ?>
                            </span>
                        </div>
                        <div class="photos-div">
                            <a href="<?= base_url($propLinkUrl) ?>.html"><img width="140px" height="110px" src="<?
                        if ($listingData["photo_main"])
                            echo base_url(PHOTOS_THUMBS_PATH . $listingData["photo_main"]);
                        else
                            echo ASSETS_URL . 'images/property-picture-not-found.jpg';
                                ?>" class="tab4-img" alt="" /></a>
                            <? if ($listingData["photos"] > 0) { ?><div class="photos-count"><?= $listingData["photos"] ?> Photos</div> <? } ?>
                        </div>

                        <div class="tab4-text2">
                            <?= $listingData["title"] ?>
                            <span><?= $listingData["description"] ?></span>
                        </div>
                        <div class="tab4-text4">
                            <div class="tab4-box-count">
                                <div class="bedrooms" ><?= $listingData["beds"] ?>  </div>
                                <div class="bathrooms" ><?= $listingData["baths"] ?>  </div>
                                <div class="parkings" ><?= $listingData["parking"] ?>  </div>
                            </div>
                            <button type="button" class="phone-no-details phone-no-details-small"></button>
                            <button type="button" class="blue-button show-phone-no-small" user_id="<?= $listingData["user_id"] ?>" property_id="<?= $listingData["id"] ?>" style="float: right;"> Show Phone Number </button>
                            <button type="button" type="popup" class="green-button send-enquiry-small" data-reveal-id="photos-popup">Send Enquiry</button>
                        </div>
                    </div>
                <? endforeach; ?>
                <div class="clearfix"></div>
                <div class="page_navigation"> <?= @$properties["pagination_data"]['pagination'] ?></div>
                <?
            } else {
                echo "No result found";
            }
            ?>
        </div>
        <? if ($AJAX_REQUEST != 1): ?>         
        </div>
    </div>
    <!--middle html end-->

    <div id="photos-popup" class="reveal-modal medium">
        <h2>Email Enquiry</h2>
        <div class="popup-conetnt-container">
            <form method="POST" id="enq-form">
                <input type="text" id="enq-name" name="enq-name" class="in_put1 in_put3 enquiry-form-fields" placeholder="Your Name">
                <input type="text" id="enq-email" name="enq-email" class="in_put1 in_put3 enquiry-form-fields" placeholder="Your Email">
                <input type="text" id="enq-number" name="enq-number" class="in_put1 in_put3 enquiry-form-fields" placeholder="Your Phone Number">
                <textarea type="text" id="enq-message" name="enq-message" class="in_put1 in_put3 enquiry-form-fields" placeholder="Your Message - at least 10 characters"></textarea>
        </div>

        <div id="enq-status"></div>
        <button type="button" id="enq-send" class="blue-button small-button" style="float: right;"> Send</button>
    </form>
    <a class="close-reveal-modal">&#215;</a>
    </div>

    <? include_once 'includes/footer.php'; ?>
<? endif; ?>