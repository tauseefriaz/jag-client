$(document).ready(function() {
    initMainForm(mainFormID);
    
    var oContactTable = $(contactsDatatable).dataTable( {
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
            "mDataProp": "first_name"
        },
        {
            "mDataProp": "last_name"
        },
        {
            "mDataProp": "mobile_number"
        },
        {
            "mDataProp": "phone_number"
        },
        {
            "mDataProp": "fax_number"
        },
        {
            "mDataProp": "email"
        },
        {
            "mDataProp": "nationality"
        },
        {
            "mDataProp": "country"
        },
        {
            "mDataProp": "city"
        },
        {
            "mDataProp": "address"
        },
        {
            "mDataProp": "dateadded"
        },
        {
            "mDataProp": "dateupdated"
        }
        ],
        "aaSorting" : [[ 13, 'desc' ]],
        "bRegex": true,
        "sAjaxSource": base_url+"bench/contacts/datatable",
        "iDisplayStart": 0,
        "iDisplayLength": 10,
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            aoData.push({
                "name": "", 
                "value":  ""
            } );
            $.getJSON( sSource, aoData, function (json) { 
                fnCallback(json)
                $('#contacts_row #'+lastSelecetdID+' td').addClass('yellowCSS');
            } );
        }
    });
        
    jQuery("thead input").keyup( function () {
        oContactTable.fnFilter( this.value, $(this).attr('search-id') );
        jQuery('#reset-filter').css('display', '');
    } );
        
    jQuery("thead select").change( function () {
        oContactTable.fnFilter( this.value, $(this).attr('search-id') );
        jQuery('#reset-filter').css('display', '');
    } );
    
    jQuery("#reset-filter").click(function () {
        jQuery("#search-form")[ 0 ].reset();
        oContactTable.fnDraw(false);
        oContactTable.fnFilterClear(true);
        $('#reset-filter').css('display', 'none');
    });
        
    $(contactsDatatable).on('click', "tr", function(event) {
        if(formDataChange==false){
            $("td.hilight-row-yellow", oContactTable.fnGetNodes()).removeClass('hilight-row-yellow');
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
                    first_name: {
                        required: true,
                        minlength:2
                    }, 
                    last_name: {
                        required: true,
                        minlength:2
                    },
                    mobile_number: {
                        number:true,
                        required: function(element) {
                            return $("#phone_number").val() < 3;
                        },
                        minlength:5
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
            oContactTable.fnDraw();
        }
    }); 
    
});


        
function getSingleItem(itemID){
            
    $.getJSON(base_url+"bench/contacts/single/?itemID="+itemID, function(jsonData){ 
        $.each(jsonData[itemID], function(field, value) {
            $(mainFormID).find('#'+field).val(value);
        });
        $('[chosen=1]').trigger("chosen:updated");
    });
}

        