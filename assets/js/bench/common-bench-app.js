var mainFormID;
var formStatus;
var messageField;

$(mainFormID).find('button').css('display','none');

function initMainForm(formID){
    formStatus = false;
    $(formID).get(0).reset();
    $(formID).find('input, select, textarea').attr('disabled','disabled');
    $(formID).find("[chosen=1]").attr('disabled', true).trigger("chosen:updated");
    $(formID).find('button').css('display','none');
    $(formID).find('#itemNew').css('display','');
    $(formID).find("a[type=popup]").each( function(index){
        $(this).attr("data-reveal-id", "disabled");
    });
//$(formID).find('#itemSave, #itemCancel, #itemInsert, #itemUpdate, #itemEdit').css('display','none');
}
        
function readMainForm(formID){
    initMainForm(formID);
    $(formID).find('button').css('display','none');
    $(formID).find('#itemNew, #itemEdit').css('display','');
}
       
function editMainForm(formID, type){
    formStatus = true;
    $(formID).find('button').css('display','none');
    $(formID).find('#itemCancel, #item'+type).css('display','');
    $(formID).find('input, select, textarea').removeAttr('disabled');
    $(formID).find("[chosen=1]").attr('disabled', false).trigger("chosen:updated");
    $(formID).find("a[type=popup]").each( function(index){
        $(this).attr("data-reveal-id", $(this).attr("popup-id"));
    });
}
        
function cancelMainForm(formID){
    var itemValue =  $(formID).find('#id').val();
    if(itemValue>0){
        getSingleItem(itemValue);
        readMainForm(formID);
    }else{
        initMainForm(formID);
    }
}
        
$(document).ready(function() {
    $(mainFormID+' #itemCancel').click(function(){
        cancelMainForm(mainFormID);
    });
        
    $(mainFormID+' #itemEdit').click(function(){
        editMainForm(mainFormID, "Update");
    });
        
    $(mainFormID+' #itemNew').click(function(){
        $(mainFormID).find('#id').val(0);
        cancelMainForm(mainFormID);
        editMainForm(mainFormID, "Insert");
    });
    
    $(mainFormID).click(function(){
        if(formStatus==false){
            $(messageField).html("Please click on New or Edit button to change the details!");
            setTimeout(function() {
                $(messageField).html('');
            }, 5000);
        }else{
            $(messageField).html('');
        }
    });
    
        
    $("[chosen=1]").chosen({
        disable_search_threshold: 2,
        no_results_text: "Oops, nothing found!",
        width: "137px"
    });
});