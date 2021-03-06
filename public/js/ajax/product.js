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
            $("#divTag").load(" #divTag > *");
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



function upModification(productId, modificationId) {
    that = $(this);
    var url = '/admin/product/modification-move-up/'+productId+'/'+modificationId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divMod").load(" #divMod > *");
        }
    });
    return false;
}

function downModification(productId, modificationId) {
    that = $(this);
    var url = '/admin/product/modification-move-down/'+productId+'/'+modificationId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divMod").load(" #divMod > *");
        }
    });
    return false;
}

function deleteMod(modId) {
    if (confirm('Вы уверены, что хотите удалить эту характеристику?')) {
        that = $(this);
        var url = "/admin/product/delete-mod/"+modId;
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                "data": "some_var_value"
            },
            async: true,
            success: function () {
                $("#divMod").load(" #divMod > *");
            }
        });
        return false;
    }
}

function upTag(productId, tagId) {
    that = $(this);
    var url = '/admin/product/tag-move-up/'+productId+'/'+tagId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divTag").load(" #divTag > *");
        }
    });
    return false;
}

function downTag(productId, tagId) {
    that = $(this);
    var url = '/admin/product/tag-move-down/'+productId+'/'+tagId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divTag").load(" #divTag > *");
        }
    });
    return false;
}


function deleteProduct(productId) {
    if (confirm('Вы уверены, что хотите удалить этот товар?')) {
        that = $(this);
        var url = "/admin/product/delete-product/"+productId;
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                "data": "some_var_value"
            },
            async: true,
            success: function () {
                $("#deleteProduct").load(" #deleteProduct > *");
            }
        });
        return false;
    }
}


function upChoice(productId, choiceId) {
    that = $(this);
    var url = '/admin/product/choice-move-up/'+productId+'/'+choiceId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divChoice").load(" #divChoice > *");
        }
    });
    return false;
}

function downChoice(productId, choiceId) {
    that = $(this);
    var url = '/admin/product/choice-move-down/'+productId+'/'+choiceId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divChoice").load(" #divChoice > *");
        }
    });
    return false;
}


function deleteChoice(choiceId) {
    if (confirm('Вы уверены, что хотите удалить этоту модификацию?')) {
        that = $(this);
        var url = "/admin/product/delete-choice/"+choiceId;
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                "data": "some_var_value"
            },
            async: true,
            success: function () {
                $("#divChoice").load(" #divChoice > *");
            }
        });
        return false;
    }
}