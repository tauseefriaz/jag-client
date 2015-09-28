<script>
    var formDataChange = false;
    var formStatus = false;
    var lastSelecetdID;
    var mainFormID = '#usersMainForm';
    var usersDatatable = '#usersDatatable';
    var messageField = '#returned-form-message';
</script>

<? include_once 'application/views/includes/header.php'; ?>
<script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/users.screen.js"></script>

<!--middle html-->
<div class="middle-main">

    <!--middle box3 html-->
    <form id="usersMainForm" action="<?= base_url() ?>bench/users/submit" method="post">
        <div class="form-container clearfix">
            <div class="form-datatable-buttons-msgs">
                <button type="submit" id="itemInsert" class="editItemButton" name="insert">Save User</button>
                <button type="submit" id="itemUpdate" class="editItemButton" name="update">Update User</button>
                <button type="button" id="itemNew" class="newItemButton">New User</button>
                <button type="button" id="itemEdit" class="editItemButton">Edit User</button>
                <button type="button" id="itemCancel" class="cancelItemButton">Cancel</button>
                <span id="returned-form-message"></span>

            </div>

            <table width="100%" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <td>Name</td>
                    <td>
                        <input name="name" type="text" class="input-text-fields" id="name">
                        <input name="id" style="display:none;" type="text" class="input-text-fields" id="id">
                    </td>
                    <td>Phone #</td>
                    <td><input name="phone_no" type="text" class="input-text-fields" id="phone_no"></td>
                    <td>Fax #</td>
                    <td><input name="fax_no" type="text" class="input-text-fields" id="fax_no" /></td>
                    <td>Address</td>
                    <td align="left" valign="bottom"><input name="address" type="text" class="input-text-fields" id="address" /></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td>
                        <select name="type" chosen="1" class="input-text-fields" id="type">
                            <option value="0">Select</option>
                            <option value="1">Individual</option>
                            <option value="2">Company</option>
                        </select>
                    </td>
                    <td>Mobile #</td>
                    <td><input name="mobile_no" type="text" class="input-text-fields" id="mobile_no" /></td>
                    <td>City</td>
                    <td><input name="city" type="text" class="input-text-fields" id="city" /></td>
                    <td>&nbsp;</td>
                    <td align="right" valign="bottom">&nbsp;</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input name="password" type="password" class="input-text-fields" id="password" placeholder="New/Change Password" /></td>
                    <td>Email</td>
                    <td><input name="email" type="text" class="input-text-fields" id="email" /></td>
                    <td>Country</td>
                    <td><select name="country" chosen="1" class="input-text-fields" id="country">
                            <option value="0">Select</option>
                            <option value="pakistan">Pakistani</option>
                            <option value="uk">British</option>
                        </select></td>
                    <td>&nbsp;</td>
                    <td align="right" valign="bottom">&nbsp;</td>
                </tr>
            </table>
        </div>
    </form>
    <!--middle box3 html end-->

    <div class="datatable-container clearfix">
        <div class="form-datatable-buttons-msgs"></div>
        <form id="search-form">
            <table id="usersDatatable" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr> 
                        <th></th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile #</th>
                        <th>Phone #</th>
                        <th>Fax #</th>
                        <th>Country</th>
                        <th>City</th>
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
                    </tr>
                </thead>
            </table>
        </form>
    </div>

</div>

<!--middle html end-->
<? include_once 'application/views/includes/footer.php'; ?>