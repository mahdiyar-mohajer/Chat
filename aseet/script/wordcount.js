
$(document).ready(function () {
    function getAllContact() {
        $.ajax({
                url: URL,
                success: function (res) {
                    console.log(res)
                    res.forEach(contact => {
                        generateContact()
                    });
                }
            }
        )
    }

    getAllContact()
    $("#message").on("input", function () {
        const charLeft = 10 - $(this).val().length;
        const sText = `${charLeft}`;
        $("#text-count").text(sText);
        $("#submit").show();
        if (charLeft <= 0) {
            $("#submit").hide();
            $("#text-count").removeClass("text-green-600");
            $("#text-count").addClass("text-red-600");
            // $("input").prop('disabled', true);

        } else {
            $("#text-count").addClass("text-green-600");
            $("#text-count").removeClass("text-red-600");
            // $("input").prop('disabled', false);
        }
    })
})

