$("#coupon-modal").ready(function () {

    console.log("ready Coupon Modal")

    // console.log("popState => ", localStorage.getItem('date-shown'))

    // var currentDate = getDate()

    // console.log("Current date", currentDate)

    // if (localStorage.getItem('date-shown') != currentDate) {

        // var completeDate = getDate()

        // localStorage.setItem("date-shown", completeDate);

        // console.log("date shown => ", localStorage.getItem('date-shown'))

        setTimeout(function () {

            $('#coupon-modal').modal('show');

        }, 300000);  // 120000 (5 min)
    // }
});


// function getDate() 
// {
//     var date = new Date();

//     var day = String(date.getDay())

//     var month = String(date.getMonth())

//     var year =  String(date.getFullYear())

//     var completeDate = day + "-" + month + "-" + year

//     return completeDate
// }