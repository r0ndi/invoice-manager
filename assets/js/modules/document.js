$(document).ready(function () {

    var $net = $('#document_form_positionNetPrice'),
        $netValue = $('#document_form_positionNetValue'),
        $gross = $('#document_form_positionGrossPrice'),
        $grossValue = $('#document_form_positionGrossValue'),
        $quantity = $('#document_form_positionQuantity'),
        $tax = $('#document_form_positionTax');

    var refreshPrices = function () {
        var $netPrice = $net.val();
        if (!$netPrice) {
            return false;
        }

        $.ajax({
            url:'/document/refresh-prices',
            dataType: 'json',
            type: 'POST',
            async: true,
            data: {
                'quantity': $quantity.val(),
                'netPrice': $netPrice,
                'tax': $tax.val()
            },
            success: function (response) {
                if (!response) {
                    return false;
                }

                $gross.val(response.gross);
                $netValue.val(response.netValue);
                $grossValue.val(response.grossValue);
            }
        });
    };

    if ($net.length && $quantity.length && $tax.length) {
        $net.change(refreshPrices);
        $tax.change(refreshPrices);
        $quantity.change(refreshPrices);
    }

});
