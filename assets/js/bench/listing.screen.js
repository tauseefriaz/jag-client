$(document).ready(function() {
    initMainForm(mainFormID);
    
    var oListingTable = $(listingsDatatable).dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "sDom": 'R<>rt<ilp><"clear">',
        "scrollX": true,
        "aoColumnDefs": [ 
        {
            "render": function ( data, type, row ) {
                return '<div style="text-align:center;" id="item_action"><input type=\"checkbox\" name="user_datatable_ids" value="'+ data[0] +'"></div>';
            },
            "targets": 0
        },
        {
            "bSortable": false, 
            "aTargets": [ 0 ]
        }
                
        ],
        "aoColumns": [
        {
            "mDataProp": "id"
        },


        {
            "mDataProp": "ref"
        },
        {
            "mDataProp": "status"
        },
        {
            "mDataProp": "main_type_id"
        },
        {
            "mDataProp": "type_id"
        },
        {
            "mDataProp": "sub_type_id"
        },
        {
            "mDataProp": "area_state_id"
        },
        {
            "mDataProp": "area_city_id"
        },
        {
            "mDataProp": "area_location_id"
        },
        {
            "mDataProp": "area_sub_location_id"
        },
        {
            "mDataProp": "unit_no"
        },
        {
            "mDataProp": "plot_no"
        },
        {
            "mDataProp": "price"
        },
        {
            "mDataProp": "area"
        },
        {
            "mDataProp": "beds"
        },
        {
            "mDataProp": "baths"
        },
        {
            "mDataProp": "parking"
        },
        {
            "mDataProp": "dateadded"
        },
        {
            "mDataProp": "dateupdated"
        },
        ],
        "aaSorting" : [[ 18, 'desc' ]],
        "bRegex": true,
        "sAjaxSource": base_url+"bench/listings/datatable",
        "iDisplayStart": 0,
        "iDisplayLength": 10,
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            aoData.push({
                "name": "due_dateS", 
                "value":  $('#due_dateS').val()
            } );
            $.getJSON( sSource, aoData, function (json) { 
                fnCallback(json)
                $('#listings_row #'+lastSelecetdID+' td').addClass('yellowCSS');
            } );
        }
    });
        
    jQuery("thead input").keyup( function () {
        oListingTable.fnFilter( this.value, $(this).attr('search-id') );
        jQuery('#reset-filter').css('display', '');
    } );
        
    jQuery("thead select").change( function () {
        oListingTable.fnFilter( this.value, $(this).attr('search-id') );
        jQuery('#reset-filter').css('display', '');
    } );
    
    jQuery("#reset-filter").click(function () {
        jQuery("#search-form")[ 0 ].reset();
        oListingTable.fnDraw(false);
        oListingTable.fnFilterClear(true);
        $('#reset-filter').css('display', 'none');
    });
        
    $(listingsDatatable).on('click', "tr", function(event) {
        if(formDataChange==false){
            $("td.hilight-row-yellow", oListingTable.fnGetNodes()).removeClass('hilight-row-yellow');
            $(event.target).parent().find("td").addClass('hilight-row-yellow');
            readMainForm(mainFormID);
            getSingleItem($(this).attr('id'));
        }   
    });

    $(mainFormID).ajaxForm({
        beforeSubmit : function() { 
            return $(mainFormID).validate({
                ignore: ":hidden:not(select)" ,
                rules: {
                    price: {
                        number: true
                    }, 
                    size: {
                        number: true
                    }
                },
                errorClass: 'form-field-required',  
                errorPlacement: function(error, element) {		
                }
            }).form() ;
        },
        //target: '#returned-form-message',
        success: function(data) {
            var returnData = data.split('|');
            $(mainFormID).find('#id').val(returnData[0]);
            cancelMainForm(mainFormID);
            oListingTable.fnDraw();
        }
    }); 
        
    $("#area_state_id").change( function () {
        var value = $(this).val();
        var optionsString = '<option id="" value="0">Select</option>';
        var locationData = citiesArray[value];
            
        if(locationData!=undefined){
            $.each(locationData, function(id,name){
                optionsString += '<option value="'+id * 1+'">'+name+'</option>';
            });
        }
            
        $('#area_city_id').html(optionsString);
        $('#area_city_id').trigger("chosen:updated");
    });
        
    $("#area_city_id").change( function () {
        var value = $(this).val();
        var optionsString = '<option id="" value="0">Select</option>';
        var locationData = locationsArray[value];
            
        if(locationData!=undefined){
            $.each(locationData, function(id,name){
                optionsString += '<option value="'+id * 1+'">'+name+'</option>';
            });
        }
            
        $('#area_location_id').html(optionsString);
        $('#area_location_id').trigger("chosen:updated");
    });
        
    $("#area_location_id").change( function () {
        var value = $(this).val();
        var optionsString = '<option id="" value="0">Select</option>';
        var locationData = subLocationsArray[value];
            
        if(locationData!=undefined){
            $.each(locationData, function(id,name){
                optionsString += '<option value="'+id * 1+'">'+name+'</option>';
            });
        }
            
        $('#area_sub_location_id').html(optionsString);
        $('#area_sub_location_id').trigger("chosen:updated");
    });
        
    $("#sub_type_id").change( function () {
        $('#type_id').val($(this).find(':selected').attr("type"));
    });
        
    $('#file_upload').uploadifive({
        'uploadScript'      : base_url+'bench/listings/upload_photo/',
        'cancelImg'         : base_url+'application/views/uploadify/cancel.png',
        'folder'            : 'uploads',
        'buttonText'        : "Select Images",
        'width'             : '150px',
        'fileType'          : 'image',
        'fileExt'           : '*.jpg; *.jpeg; *.gif; *.png; *.tiff;',
        'fileSizeLimit'     : 4 * 1024 * 1024,
        'queueSizeLimit'    : 20,
        'removeCompleted'   : true,
        'multi'             : true,	
        'auto'              : true,
        'method'            : 'post',
        'onQueueFull'       : function(event, queueSizeLimit) {
            alert("Please don't put anymore files in me! You can upload " + queueSizeLimit + " files at once");
            return false;
        },
        'onUploadComplete': function(file, data) {
            if(data){
                var ids_and_counts = data.split("|");
            }
            $('#photos').val(ids_and_counts[2]);
            $("#show-photos").load(base_url+"bench/listings/get_photos/"+$('input#id').val()+"/");
        }
    });
    
});


        
function getSingleItem(itemID){
    var areaA, areaB, areaC, areaD = '';
            
    $.getJSON(base_url+"bench/listings/single/?itemID="+itemID, function(jsonData){ 
        $.each(jsonData[itemID], function(field, value) {
                    
            if(field=="features" && value!=null){
                $.each(value.split(','), function( index, value ) {
                    $("#feature_"+value).attr("checked","checked");
                });
            }
                    
            $(mainFormID).find('#'+field).val(value);
            field === 'area_state_id'        ?  areaA = value: '';
            field === 'area_city_id'         ? areaB = value: '';
            field === 'area_location_id'     ? areaC = value: '';
            field === 'area_sub_location_id' ? areaD = value: '';
                    
        });
                
        var formData = {
            'property_id' : itemID
        };
        $('#file_upload').data('uploadifive').settings.formData = formData;
        $('[chosen=1]').trigger("chosen:updated");  
        setTriggerLocations('#area_state_id', areaA);
        setTriggerLocations('#area_city_id', areaB);
        setTriggerLocations('#area_location_id', areaC);
        setTriggerLocations('#area_sub_location_id', areaD);
    });
}
        
function setTriggerLocations(field, value){
    $(field).val(value);
    $(field).trigger('change');
    $(field).trigger("chosen:updated");
}
        