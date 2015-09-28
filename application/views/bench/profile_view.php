<script>
    var formDataChange = false;
    var formStatus = true;
    var mainFormID = '#profileMainForm';
    var messageField = '#returned-form-message';
</script>

<? include_once 'application/views/includes/header.php'; ?>
<script type="text/javascript" src="<?= ASSETS_URL ?>js/bench/profile.screen.js"></script>

<!--middle html-->
<div class="middle-main">
    <!--middle box3 html-->
    <form id="profileMainForm" action="<?= base_url() ?>bench/profile/submit" method="post">
        <div class="form-container clearfix">
            <div class="form-datatable-buttons-msgs">
                <button type="submit" id="itemUpdate" class="editItemButton" name="update">Update Profile</button>
                <button type="button" id="itemCancel" class="cancelItemButton">Cancel</button>
                <span id="returned-form-message"></span>
            </div>

            <table width="100%" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <td width="15%">Name</td>
                    <td width="16%">
                        <input name="name" type="text" class="input-text-fields" id="name">
                        <input name="id" style="display:none;" type="text" class="input-text-fields" id="id">
                    </td>
                    <td width="6%">Address</td>
                    <td width="41%"> <input name="address" type="text" class="input-text-fields" style="width:350px;" id="address"/></td>
                  <td width="6%">Logo</td>
                    <td width="16%" colspan="3" align="left"><input name="logo" type="text" class="input-text-fields" id="logo" /></td>
                </tr>
                <tr>
                    <td>You are a</td>
                    <td>
                        <select name="type" chosen="1" class="input-text-fields" id="type">
                            <option value="0">Select</option>
                            <optgroup label="Individual">
                                <option value="1">Owner</option>
                                <option value="2">Investor</option>
                                <option value="3">Tenant</option>
                            </optgroup>
                            <optgroup label="Company">
                                <option value="4">Architect</option>
                                <option value="5">Builder</option>
                                <option value="6">Developer</option>
                                <option value="7">Agent/Broker</option>
                            </optgroup>
                        </select>
                    </td>
                    <td>Description</td>
                    <td width="41%" rowspan="7">
                        <br />
                        <textarea name="description" class="input-text-fields" id="description" style="width:350px; height:183px; resize: none; margin-top:-15px;"></textarea></td>
                  <td>
                    </td>
                    <td width="16%" colspan="3" align="left">&nbsp;</td>
                </tr>
                <tr>
                    <td>Phone # A</td>
                    <td><input name="phone_number_a" type="text" class="input-text-fields" id="phone_number_a" /></td>
                    <td>&nbsp;</td>
                  <td>&nbsp;</td>
                    <td width="16%" colspan="3" align="left">&nbsp;</td>
                </tr>
                <tr>
                    <td>Phone # B</td>
                    <td><input name="phone_number_b" type="text" class="input-text-fields" id="phone_number_b" /></td>
                    <td>&nbsp;</td>
                  <td>Watermark</td>
                    <td width="16%" colspan="3" align="left"><input name="watermark" type="text" class="input-text-fields" id="watermark" /></td>
                </tr>
                <tr>
                    <td>Fax #</td>
                    <td><input name="fax_number" type="text" class="input-text-fields" id="fax_number"/></td>
                    <td>&nbsp;</td>
                  <td rowspan="4">&nbsp;</td>
                    <td width="16%" colspan="3" align="left">&nbsp;</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input name="email" type="text" class="input-text-fields" id="email"/></td>
                  <td>&nbsp;</td>
                    <td width="16%" colspan="3" align="left">&nbsp;</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td><input name="website" type="text" class="input-text-fields" id="website" /></td>
                  <td>&nbsp;</td>
                    <td width="16%" colspan="3" align="left">&nbsp;</td>
                </tr>
                <tr>
                    <td>Reg #</td>
                    <td><input name="registration_no" type="text" class="input-text-fields" id="registration_no" /></td>
                  <td>&nbsp;</td>
                    <td width="16%" colspan="3" align="left">&nbsp;</td>
                </tr>
            </table>
        </div>
    </form>
    <!--middle box3 html end-->

</div>
<script>
    var a = [<?= json_encode($profile) ?>];

    $.each($.parseJSON(a), function (key, data) {
        console.log(key)
        $.each(data, function (field, value) {
            $(mainFormID).find('#'+field).val(value);
           
        });
        $('[chosen=1]').trigger("chosen:updated");
    })
</script>

<div id="photos-popup" class="reveal-modal">
    <h1>Upload Photos</h1>
    <a class="close-reveal-modal">&#215;</a>
</div>

<!--middle html end-->
<? include_once 'application/views/includes/footer.php'; ?>