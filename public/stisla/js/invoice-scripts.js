"use strict";

$('input').on('change, keyup', function() {
    var currentInput = $(this).val();
    var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
    $(this).val(fixedInput);
});

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function calcTask() 
{
    const rate_task = document.getElementsByName('rate_task');
    const qty_task = document.getElementsByName('qty_task');
    const arr1 = [...rate_task].map(input => parseFloat(input.value));
    const arr2 = [...qty_task].map(input => parseFloat(input.value));

    var total = [];
    var row =$(".total-task") 
    let sum = 0;

    for(let i=0;i<arr1.length;i++){
        total[i] = parseFloat(arr1[i]) * parseFloat(arr2[i]);
        if(isNaN(total[i])){
            row[i].value = 0;
        } else {
            row[i].value = total[i];
        }
        sum += total[i];
    };
    if(isNaN(sum)){
        document.getElementById("subtotal_task").value = 0;
    } else {
        document.getElementById("subtotal_task").value = sum;
    }

    totalAll();
}

function calcTS() 
{
    const rate_ts = document.getElementsByName('rate_ts');
    const qty_ts = document.getElementsByName('qty_ts');
    const arr1 = [...rate_ts].map(input => input.value);
    const arr2 = [...qty_ts].map(input => parseFloat(input.value));

    var total = [];
    var row =$(".total-ts") 
    let sum = 0;

    for(let i=0;i<arr1.length;i++){
        total[i] = parseFloat(arr1[i]) * parseFloat(arr2[i]);
        if(isNaN(total[i])){
            row[i].value = 0;
        } else {
            row[i].value = total[i];
        }
        sum += total[i];
    };

    if(isNaN(sum)){
        document.getElementById("subtotal_ts").value = 0;
    } else {
        document.getElementById("subtotal_ts").value = sum;
    }

    totalAll();
}

function totalAll()
{
    var st_task = parseFloat(document.getElementById("subtotal_task").value);
    var st_ts = parseFloat(document.getElementById("subtotal_ts").value);
    var st_exp = parseFloat(document.getElementById("subtotal_expenses").value);

    var tax = parseFloat(document.getElementById("tax").value)
    var discount = parseFloat(document.getElementById("discount").value)

    var total = 0;

    if(isNaN(tax)){
        total = (st_task + st_ts + st_exp) - discount;
    } else if(isNaN(discount)) {
        total = (st_task + st_ts + st_exp) - tax;
    } else {
        total = (st_task + st_ts + st_exp) - tax - discount;
    }   

    if(total < 0){
        document.getElementById("total_all").value = 0;
    } else {
        document.getElementById("total_all").value = total;
    }
}