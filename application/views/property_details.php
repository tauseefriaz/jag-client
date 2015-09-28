<? include_once 'includes/header.php'; ?>
<script language="javascript" type="text/javascript" src="<?= ASSETS_URL ?>js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="<?= ASSETS_URL ?>css/flexslider.css" type="text/css" media="screen" />
<!--middle html-->
<div class="middle-main">
    <div class="middle clearfix">
        <h1 class="property-title-h1"><?= $property[0]["title"] ?></h1>
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
            </div>
        <? endif; ?>

        <div class="detail-page-area">
            <div class="detail-slider-area">
                <div id="container">

                    <div class="flexslider">
                        <ul class="slides">
                            <? if (!empty($pictures)): ?>
                                <? foreach ($pictures as $dataChunk): ?>
                                    <li data-thumb="<?= base_url(PHOTOS_THUMBS_PATH . $dataChunk["filename"]) ?>">
                                        <img height="300px" width="467" src="<?= base_url(PHOTOS_RESIZED_PATH . $dataChunk["filename"]) ?>" alt="" title="" />
                                    </li>
                                <? endforeach; ?>
                            <? else: ?>
                                <li data-thumb="<?= ASSETS_URL . "images/property-picture-not-found.jpg" ?>">
                                    <img height="300px" width="467" src="<?= ASSETS_URL . "images/property-picture-not-found.jpg" ?>" alt="" title="" />
                                </li>
                            <? endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="property-details-area">
                <div>
                    <button type="button" id="" class="green-button">Send Enquiry</button>
                    <button type="button" class="phone-no-details"><?= $userdata[0]["mobile_no"] ?> <? if ($userdata[0]["phone_no"]) echo " / " . $userdata[0]["phone_no"] ?></button>
                    <button type="button" class="blue-button show-phone-number" style="float: right;"> Show Phone Number </button>
                </div>

                <div class="property-agent-details">
                    Property By <?= $userdata[0]["name"] ?>
                </div>

                <div class="property-heading">Property Description</div>
                <div class="property-description" style="font-size:14px; height: 140px; overflow-y: scroll; "><?= $property[0]["description"] ?></div>

                <div class="property-other-details">
                    <table border="1" class="property-details-table">
                        <tr>
                            <td>Ref</td>
                            <td>PK-0000<?= $property[0]["ref"] ?></td> 
                            <td>Area</td>
                            <td><?= $property[0]["area"] ?></td>
                        </tr>
                        <tr>
                            <td>Bedrooms</td>
                            <td><?= $property[0]["beds"] ?></td> 
                            <td>Bathrooms</td>
                            <td><?= $property[0]["baths"] ?></td>
                        </tr>
                        <tr>
                            <td>Bathrooms</td>
                            <td><?= $property[0]["baths"] ?></td> 
                            <td>Last Updated</td>
                            <td><?= date('d-m-Y', $property[0]["dateupdated"]) ?></td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td><?= $parameters['p_types'][$property[0]["type_id"]]['name'] ?></td> 
                            <td>Last Updated</td>
                            <td><?= date('d-m-Y', $property[0]["dateupdated"]) ?></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        <div class="detail-page-area">
            <div id="map-canvas"  style="height: 400px;"></div>
        </div>

        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8ZJBonP56VgiY_iIb6LL1f9dmWq-BWfQ&sensor=TRUE">
        </script>
        <script type="text/javascript">
            
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
            function initialize() {
                var myLatlng = new google.maps.LatLng(33.505004, 73.106718);
                var mapOptions = {
                    zoom: 16,
                    center: myLatlng
                }
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: 'Hello World!'
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </div>
</div>
<!--middle html end-->
<? include_once 'includes/footer.php'; ?>
