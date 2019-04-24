function addToBasket(quantity, pricePerItem, userId, productId) {
    that = $(this);
    var url = "/basket/" + quantity + "/" + pricePerItem + "/" + userId + "/" + productId;

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


function addToBasketIntermediate(objName, userId, productId) {
    var obj = document.getElementById(objName);
    var objPrice = document.getElementById('price');

    var quantity = obj.getAttribute('quantity');

    var productPrice = document.getElementById("price");

    that = $(this);
    var url = "/basket/" + obj.getAttribute('quantity') + "/" + objPrice.getAttribute('value') + "/" + userId + "/" + productId;

    alert("/basket/" + obj.getAttribute('quantity') + "/" + objPrice.getAttribute('value') + "/" + userId + "/" + productId)

    if (userId == null) {
        alert("Вам нужно зарегистрироваться");
        return;
    }
    if (objPrice.getAttribute('value') == null) {
        alert("Выберите модификацию");
        return;
    }

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divProduct").load(" #divProduct > *");
            $('#BasketModal').modal('show')
        }
    });
    return false;
}

function deleteProductFromBasket(basketId) {
    that = $(this);
    var url = "/basket/delete/" + basketId;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": "some_var_value"
        },
        async: true,
        success: function () {
            $("#divProduct").load(" #divProduct > *");
        }
    });
    return false;
}