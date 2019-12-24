$(function () {
    $("#product_subCategory").attr("disabled", true);
    $("select option").each(function () {
        if($(this).val() == "") {
            $(this).prop("selected", true);
            $(this).prop("disabled", true);
        }
    });
    setTimeout(function () {
        $(".alert, .success").remove();
    }, 2000);
});

$("#product_category").on("change", function () {
    $(".loader").css("display", "flex");
    $.ajax({
        type: "POST",
        url: "/admin/add/product",
        data: {
            id: $('option:selected', this).attr('name'),
            helper: "category"
        },
        success: function(html) {
            $("#product_subCategory").empty();
            $("#product_subCategory").html(html['option']);
            $("#product_subCategory").attr("disabled", false);
            $(".loader").css("display", "none");
        }
    });
});
