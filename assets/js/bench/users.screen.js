$(document).ready(function() {
    initMainForm(mainFormID);
    
    var oUserTable = $(usersDatatable).dataTable( {
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
            "mDataProp": "type"
        },
        {
            "mDataProp": "name"
        },
        {
            "mDataProp": "email"
        },
        {
            "mDataProp": "mobile_no"
        },
        {
            "mDataProp": "phone_no"
        },
        {
            "mDataProp": "fax_no"
        },
        {
            "mDataProp": "country"
        },
        {
            "mDataProp": "city"
        },
        {
            "mDataProp": "dateadded"
        },
        {
            "mDataProp": "dateupdated"
        }
        ],
        "aaSorting" : [[ 7, 'desc' ]],
        "bRegex": true,
        "sAjaxSource": base_url+"bench/users/datatable",
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
                $('#users_row #'+lastSelecetdID+' td').addClass('yellowCSS');
            } );
        }
    });
        
    jQuery("thead input").keyup( function () {
        oUserTable.fnFilter( this.value, $(this).attr('search-id') );
        jQuery('#reset-filter').css('display', '');
    } );
        
    jQuery("thead select").change( function () {
        oUserTable.fnFilter( this.value, $(this).attr('search-id') );
        jQuery('#reset-filter').css('display', '');
    } );
    
    jQuery("#reset-filter").click(function () {
        jQuery("#search-form")[ 0 ].reset();
        oUserTable.fnDraw(false);
        oUserTable.fnFilterClear(true);
        $('#reset-filter').css('display', 'none');
    });
        
    $(usersDatatable).on('click', "tr", function(event) {
        if(formDataChange==false){
            $("td.hilight-row-yellow", oUserTable.fnGetNodes()).removeClass('hilight-row-yellow');
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
                    name: {
                        required: true,
                        minlength:2
                    }, 
                    last_name: {
                        required: true,
                        minlength:2
                    },
                    email: {
                        required: true,
                        email:true,
                        minlength:5
                    },
                    type: {
                        required: true
                    },
                    password: {
                        number:true,
                        minlength:3,
                        required: function(element) {
                            return $("#id").val() == 0;
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
            oUserTable.fnDraw();
        }
    }); 
    
});


        
function getSingleItem(itemID){
            
    $.getJSON(base_url+"bench/users/single/?itemID="+itemID, function(jsonData){ 
        $.each(jsonData[itemID], function(field, value) {
            $(mainFormID).find('#'+field).val(value);
        });
        $('[chosen=1]').trigger("chosen:updated");
    });
}

        