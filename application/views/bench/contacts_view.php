<script>
    var formDataChange = false;
    var formStatus = false;
    var lastSelecetdID;
    var mainFormID = '#contactsMainForm';
    var contactsDatatable = '#contactsDatatable';
    var messageField = '#returned-form-message';
</script>

<? include_once 'application/views/includes/header.php'; ?>
<script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/contacts.screen.js"></script>

<!--middle html-->
<div class="middle-main">

    <!--middle box3 html-->
    <form id="contactsMainForm" action="<?= base_url() ?>bench/contacts/submit" method="post">
        <div class="form-container clearfix">
            <div class="form-datatable-buttons-msgs">
                <button type="submit" id="itemInsert" class="editItemButton" name="insert">Save Contact</button>
                <button type="submit" id="itemUpdate" class="editItemButton" name="update">Update Contact</button>
                <button type="button" id="itemNew" class="newItemButton">New Contact</button>
                <button type="button" id="itemEdit" class="editItemButton">Edit Contact</button>
                <button type="button" id="itemCancel" class="cancelItemButton">Cancel</button>
                <span id="returned-form-message"></span>

            </div>

            <table width="100%" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <td>Ref #</td>
                    <td>
                        <input name="ref" type="text" class="input-text-fields readonly-field" id="ref" readonly>
                        <input name="id" style="display:none;" type="text" class="input-text-fields" id="id">
                    </td>
                    <td>Phone #</td>
                    <td><input name="phone_number" type="text" class="input-text-fields" id="phone_number"></td>
                    <td>Nationality</td>
                    <td>
                        <select name="nationality" chosen="1" class="input-text-fields" id="nationality">
                            <option value="0">Select</option>
                            <option value="pakistan">Pakistani</option>
                            <option value="uk">British</option>
                        </select>
                    </td>
                    <td rowspan="4">Notes</td>
                    <td rowspan="4" align="right" valign="bottom">
                        <br>
                        <textarea name="description" class="input-text-fields" id="description" style="width:180px; height:77px; resize: none; margin-top:-15px;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input name="first_name" type="text" class="input-text-fields" id="first_name" /></td>
                    <td>Mobile #</td>
                    <td><input name="mobile_number" type="text" class="input-text-fields" id="mobile_number" /></td>
                    <td>Country</td>
                    <td>
                        <select name="country" chosen="1" class="input-text-fields" id="country">
                            <option value="0">Select</option>
                            <option value="pakistan">Pakistani</option>
                            <option value="uk">British</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input name="last_name" type="text" class="input-text-fields" id="last_name" /></td>
                    <td>Email</td>
                    <td><input name="email" type="text" class="input-text-fields" id="email" /></td>
                    <td>Address</td>
                    <td><input name="address" type="text" class="input-text-fields" id="address" /></td>
                </tr>
                <tr>
                  <td>Designation</td>
                  <td><input name="designation" type="text" class="input-text-fields" id="designation"/></td>
                  <td>Fax #</td>
                  <td><input name="fax_number" type="text" class="input-text-fields" id="fax_number" /></td>
                  <td>City</td>
                  <td><input name="city" type="text" class="input-text-fields" id="city" /></td>
                </tr>
            </table>
        </div>
    </form>
    <!--middle box3 html end-->

    <div class="datatable-container clearfix">
        <div class="form-datatable-buttons-msgs"></div>
        <form id="search-form">
            <table id="contactsDatatable" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr> 
                        <th></th>
                        <th>Ref</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile #</th>
                        <th>Phone #</th>
                        <th>Fax #</th>
                        <th>Email</th>
                        <th>Nationality</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Address</th>
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
                    </tr>
                </thead>
        </table>
        </form>
    </div>

</div>


<div id="photos-popup" class="reveal-modal">
    <h1>Upload Photos</h1>
    <a class="close-reveal-modal">&#215;</a>
</div>

<!--middle html end-->
<? include_once 'application/views/includes/footer.php'; ?>