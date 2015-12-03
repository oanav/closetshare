$(document).ready(function(){
    $(".opt_delete_account a").click(function(){
        $("#dialog-delete-account").dialog('open');
    });

    $("#dialog-delete-account").dialog({
        autoOpen: false,
        modal: true,
        buttons: [
            {
                text: osclasswizards.langs.delete,
                click: function() {
                    window.location = osclasswizards.base_url + '?page=user&action=delete&id=' + osclasswizards.user.id  + '&secret=' + osclasswizards.user.secret;
                }
            },
            {
                text: osclasswizards.langs.cancel,
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
});