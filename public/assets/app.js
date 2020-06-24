$(document).ready(function () {
    $.ajax({
        url: '/',
        type: 'GET', // POST
        //data: {'id': 2},
        success: function (res) {
            console.log(res)
        },
        error: function () {
            alert('Error')
        }
    })
})

$('#send').click(function () {
    $.ajax({
        url: '/',
        type: 'POST',
        //data: {'id': 2},
        success: function (res) {
            console.log(res)
        },
        error: function () {
            alert('Error')
        }
    })
});