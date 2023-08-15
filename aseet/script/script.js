function adminSave(){
    var admins =$('#admin_form').serializeArray();
    let id = admins[0].value;

    $.ajax({
        url: "save_admin.php",
        method: "GET",
        data: {
            id : id,
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle the error response
            console.log("An error occurred: " + error);
        }
    });
}

function blockSave(){
    var block =$('#block_form').serializeArray();
    let id = block[0].value;

    $.ajax({
        url: "save_block.php",
        method: "GET",
        data: {
            id : id,
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle the error response
            console.log("An error occurred: " + error);
        }
    });
}

function deleteMsg(id){
    $.ajax({
        url: "delete_message.php",
        method: "GET",
        data: {
            id : id,
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle the error response
            console.log("An error occurred: " + error);
        }
    });
}
