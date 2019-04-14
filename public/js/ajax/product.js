function deleteTag(tagId) {
    that = $(this);
    var url = "/admin/product/delete-tag/"+tagId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            document.getElementById(url).style.display = "none";
            document.getElementById(url).innerHTML = "";
        }
    });
    return false;
}

function deletePhoto(photoId) {
    if (confirm('Вы уверены, что хотите удалить эту картинку?')) {
        that = $(this);
        var url = "/admin/product/delete-photo/"+photoId;
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                "data": "some_var_value"
            },
            async: true,
            success: function () {
                document.getElementById(url).style.display = "none";
                document.getElementById(url).innerHTML = "";
            }
        });
        return false;
    }

}

function upPhoto(productId, photoId) {
    that = $(this);
    var url = '/admin/product/photo-move-up/'+productId+'/'+photoId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#div").load(" #div > *");
        }
    });
    return false;
}

function downPhoto(productId, photoId) {
    that = $(this);
    var url = '/admin/product/photo-move-down/'+productId+'/'+photoId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#div").load(" #div > *");
        }
    });
    return false;
}