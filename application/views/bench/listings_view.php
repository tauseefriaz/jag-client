<script>
    var formDataChange = false;
    var formStatus = false;
    var lastSelecetdID;
    var mainFormID = '#listingsMainForm';
    var listingsDatatable = '#listingsDatatable';
    var messageField = '#returned-form-message';
</script>

<? include_once 'application/views/includes/header.php'; ?>
<script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/listing.screen.js"></script>

<!--middle html-->
<div class="middle-main">

    <!--middle box3 html-->
    <form id="listingsMainForm" action="<?= base_url() ?>bench/listings/submit" method="post">
        <div class="form-container clearfix">
            <div class="form-datatable-buttons-msgs">
                <button type="submit" id="itemInsert" class="editItemButton" name="insert">Save Listing</button>
                <button type="submit" id="itemUpdate" class="editItemButton" name="update">Update Listing</button>
                <button type="button" id="itemNew" class="newItemButton">New Listing</button>
                <button type="button" id="itemEdit" class="editItemButton">Edit Listing</button>
                <button type="button" id="itemCancel" class="cancelItemButton">Cancel</button>
                <span id="returned-form-message"></span>

            </div>

            <table width="100%" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <td>Ref #</td>
                    <td><input name="ref" type="text" class="input-text-fields readonly-field" id="ref" readonly><input name="id" style="display:none;" type="text" class="input-text-fields" id="id" readonly></td>
                    <td>Price</td>
                    <td><input name="price" type="text" class="input-text-fields required" id="price"><span style="margin-left:-35px; color: #999999;"><?= $parameters["init_settings"][1]['currency_code'] ?></span></td>
                    <td>Title</td>
                    <td colspan="3"><input name="title" type="text" class="input-text-fields required" id="title" style="width:380px;"></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td>
                        <select name="main_type_id" chosen="1" class="input-text-fields required" id="main_type_id">
                            <option value="">Select</option>
                            <? foreach ($parameters["p_main_types"] as $dataChunk): ?>
                                <option value="<?= $dataChunk["id"] ?>"><?= $dataChunk["name"] ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                    <td>Area</td>
                    <td><input name="area" type="text" class="input-text-fields required" id="area"><span style="margin-left:-51px; color: #999999;"><?= strtoupper($parameters["init_settings"][1]['area_unit']) ?></span></td>
                    <td>Description</td>
                    <td colspan="3" rowspan="4"><br />
                        <textarea name="description" class="input-text-fields required" id="description" style="width:380px; height:100px; resize: none; margin-top:-15px;" ></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>  
                        <select name="sub_type_id" chosen="1" class="input-text-fields" id="sub_type_id">
                            <option value="0">Select</option>
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
                        <input name="type_id" type="text" class="input-text-fields required" id="type_id" style="display: none;" />
                    </td>
                    <td>Bedrooms</td>
                    <td>
                        <input name="beds" type="text" class="input-text-fields required" id="beds" style="width:47px;" />
                        Baths
                        <input name="baths" type="text" class="input-text-fields required" id="baths" style="width:47px;" />
                    </td>
                    <td rowspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>
                        <select name="area_state_id" chosen="1" class="input-text-fields required" id="area_state_id">
                            <option value="0">Select</option>
                            <? foreach ($parameters["p_states"] as $dataChunk): ?>
                                <option value="<?= $dataChunk["id"] ?>"><?= $dataChunk["name"] ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                    <td>Photos</td>
                    <td><input type="text" id="photos" name="photos" class="input-text-fields"><a href="#" type="popup" class="big-link popupPlus" popup-id="photos-popup" data-reveal-id="disabled">+</a></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>
                        <select name="area_city_id" chosen="1" class="input-text-fields required" id="area_city_id">
                            <option value="0">Select</option>
                        </select>
                    </td>
                    <td>Parking</td>
                    <td><input name="parking" type="text" class="input-text-fields" id="parking"></td>
                </tr>
                <tr>
                    <td>Area</td>
                    <td>
                        <select name="area_location_id" chosen="1" class="input-text-fields required" id="area_location_id">
                            <option value="0">Select</option>
                        </select>
                    </td>
                    <td>Unit #</td>
                    <td>
                        <input name="unit_no" type="text" class="input-text-fields" id="unit_no" style="width:47px;"> 
                        Plot # 
                        <input name="plot_no" type="text" class="input-text-fields" id="plot_no" style="width:47px;">
                    </td>
                    <td>Features</td>
                    <td colspan="3" rowspan="2">
                        <? foreach ($parameters["p_features"] as $dataChunk): ?>
                            <div class="form-features"> <input type="checkbox" id="feature_<?= $dataChunk['id']; ?>" value="<?= $dataChunk['id']; ?>" name="features[]"> <?= $dataChunk['name']; ?></div>
                        <? endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td>Sub Area</td>
                    <td>
                        <select name="area_sub_location_id" chosen="1" class="input-text-fields" id="area_sub_location_id">
                            <option value="0">Select</option>
                        </select>
                    </td>
                    <td>Status</td>
                    <td>
                        <select name="status" chosen="1" class="input-text-fields required" id="status">
                            <option value="0">Select</option>
                            <option value="1">Published</option>
                            <option value="2">Unpublished</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </form>
    <!--middle box3 html end-->

    <div class="datatable-container clearfix">
        <div class="form-datatable-buttons-msgs"></div>
        <form id="search-form">
            <table id="listingsDatatable" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Ref</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Location</th>
                        <th>Sub-Location</th>
                        <th>Unit No</th>
                        <th>Plot</th>
                        <th>Price</th>
                        <th>Area</th>
                        <th>Beds</th>
                        <th>Baths</th>
                        <th>Parking</th>
                        <th>Date Added</th>
                        <th>Date Updated</th>
                    </tr>
                </thead>

                <thead>
                    <tr>
                        <td style="text-align:center;">
                            <a style="display:none;" id="reset-filter" href="# Reset">
                                <img style="margin-bottom:-3px;" src="<?= ASSETS_URL ?>images/swap.jpg" title="Reset filter">
                            </a>
                        </td>
                        <td><input search-id='1' type="text"/></td>
                        <td><input search-id='2' type="text"/></td>
                        <td><input search-id='3' type="text"/></td>
                        <td><input search-id='4' type="text"/></td>
                        <td><input search-id='5' type="text"/></td>
                        <td><input search-id='6' type="text"/></td>
                        <td><input search-id='7' type="text"/></td>
                        <td><input search-id='8' type="text"/></td>
                        <td><input search-id='9' type="text"/></td>
                        <td><input search-id='10' type="text"/></td>
                        <td><input search-id='11' type="text"/></td>
                        <td><input search-id='12' type="text"/></td>
                        <td><input search-id='13' type="text"/></td>
                        <td><input search-id='14' type="text"/></td>
                        <td><input search-id='15' type="text"/></td>
                        <td><input search-id='16' type="text"/></td>
                        <td><input search-id='17' type="text"/></td>
                        <td><input search-id='18' type="text"/></td>
                    </tr>
                </thead>
            </table>
        </form>
    </div>

</div>

<!--<a href="#" class="big-link" data-reveal-id="myModal">Fade and Pop</a>	

<a href="#" class="big-link" data-reveal-id="myModal" data-animation="fade">Fade</a>-->

<div id="photos-popup" class="reveal-modal">
    <h1>Upload Photos</h1>
    <div class="photo-upload-button-div">
        <input id="file_upload" type="file" name="file_upload" />
    </div>

    <div id="show-photos" class="photo-container-div"></div>

    <a class="close-reveal-modal">&#215;</a>
</div>


<!--middle html end-->
<? include_once 'application/views/includes/footer.php'; ?>