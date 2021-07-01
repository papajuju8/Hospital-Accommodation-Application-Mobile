//-***************************************
//-*               MAIN
//-***************************************
//-*

$(document).ready(function () {
  // Login, Search, Trailer Variables
  var modal = document.getElementById("id01");
  var modal2 = document.getElementById("trailerModal");
  var search = document.getElementById("search");

  // Movie Profile Variables
  var movie_id;
  var day;
  var datePrint;
  var today;
  var theater;
  var date;
  var time;
  var price;
  var quantity;
  var seats = "";
  var seat_a1 = "";
  var seat_a2 = "";
  var seat_a3 = "";
  var seat_a4 = "";
  var seat_a5 = "";
  var seat_a6 = "";
  var seat_a7 = "";
  var seat_a8 = "";
  var seat_b1 = "";
  var seat_b2 = "";
  var seat_b3 = "";
  var seat_b4 = "";
  var seat_b5 = "";
  var seat_b6 = "";
  var seat_b7 = "";
  var seat_b8 = "";
  var seat_b9 = "";
  var seat_b10 = "";
  var seat_c1 = "";
  var seat_c2 = "";
  var seat_c3 = "";
  var seat_c4 = "";
  var seat_c5 = "";
  var seat_c6 = "";
  var seat_c7 = "";
  var seat_c8 = "";
  var seat_c9 = "";
  var seat_c10 = "";
  var seat_d1 = "";
  var seat_d2 = "";
  var seat_d3 = "";
  var seat_d4 = "";
  var seat_d5 = "";
  var seat_d6 = "";
  var seat_d7 = "";
  var seat_d8 = "";
  var seat_e1 = "";
  var seat_e2 = "";
  var seat_e3 = "";
  var seat_e4 = "";
  var seat_e5 = "";
  var seat_e6 = "";
  var seat_e7 = "";
  var seat_e8 = "";
  var seat_f1 = "";
  var seat_f2 = "";
  var seat_f3 = "";
  var seat_f4 = "";
  var seat_f5 = "";
  var seat_f6 = "";
  var seat_f7 = "";
  var seat_f8 = "";
  var seat_f9 = "";
  var seat_f10 = "";
  var seat_g1 = "";
  var seat_g2 = "";
  var seat_g3 = "";
  var seat_g4 = "";
  var seat_g5 = "";
  var seat_g6 = "";
  var seat_g7 = "";
  var seat_g8 = "";
  var seat_g9 = "";
  var seat_g10 = "";
  var seat_h1 = "";
  var seat_h2 = "";
  var seat_h3 = "";
  var seat_h4 = "";
  var seat_h5 = "";
  var seat_h6 = "";
  var seat_h7 = "";
  var seat_h8 = "";
  var seat_h9 = "";
  var seat_h10 = "";

  /********************************************************************************************/
  // login, Search, Trailer

  //Close when clicked outside
  window.onclick = function (event) {
    // Login
    if (event.target == modal) {
      modal.style.display = "none";
      document.getElementById("error1").style.display = "none";
      document.getElementById("error2").style.display = "none";
      document.getElementById("uText").value = "";
      document.getElementById("pText").value = "";
    }
    // Search
    else if (event.target == search) {
      $('.form-search-custom input[type="text"]').on(
        "keyup input",
        function () {
          /* Get input value on change */
          let inputVal = $(this).val();
          let resultDropdown = $(this).siblings(".search-result");
          if (inputVal.length) {
            $.get("../config/functions.php", {
              search_term: inputVal,
            }).done(function (data) {
              // Display the returned data in browser
              resultDropdown.html(data);
            });
          } else {
            resultDropdown.empty();
          }
        }
      );

      // Set search input value on click of result item
      $(document).on("click", ".search-result p", function () {
        $(this)
          .parents(".form-search-custom")
          .find('input[type="text"]')
          .val($(this).text());
        $("#search_button").trigger("click");
        $(this).parent(".search-result").empty();
      });
    } else if (event.target == modal2) {
      $("#trailer").each(function () {
        let el_src = $(this).attr("src");
        $(this).attr("src", el_src);
      });
    }
  };

  /********************************************************************************************/
  // Movie Profile

  // Theater
  if (!$("#inputSelectTheater").val()) {
    $("#inputSelectDate").attr("disabled", true);
    $("#inputSelectTime").attr("disabled", true);

    // Disable all seats
    disableSeats();
  }

  $("#inputSelectTheater").change(function () {
    $("#inputSelectDate").attr("disabled", false);
    $("#inputSelectDate").val("Select Date");
    theater = $("#inputSelectTheater").val();

    $("#printTotal").text("0");
    $("#printSubtotal").text("0");
    $("#checkCount").text("0");

    // Reset Variables
    if (theater == 1) {
      $(".branch-title").text("SM Manila");
    } else if (theater == 2) {
      $(".branch-title").text("SM Marikina");
    } else if (theater == 3) {
      $(".branch-title").text("SM North Edsa");
    } else {
      $(".branch-title").text("SM Bacoor");
    }
    $(".branch-date").text("");
    $(".branch-time").text("");
    $(".branch-quantity").text("");
    $(".branch-price").text("");
    seats = "";
    price = "";
    quantity = undefined;
    resetSeatsVar();

    // Disable all seats
    disableSeats();
    // Uncheck all seats
    uncheckSeats();
  });

  //Date
  $("#inputSelectDate").change(function () {
    $("#inputSelectTime").attr("disabled", false);
    $("#inputSelectTime").val("Select Time");

    $("#printTotal").text("0");
    $("#printSubtotal").text("0");
    $("#checkCount").text("0");

    // Disable all seats
    disableSeats();
    // Uncheck all seats
    uncheckSeats();

    today = new Date().toISOString().split("T")[0];
    date = $("#inputSelectDate").val().substr(1);
    if (today === date) {
      let d = new Date(); //without params it defaults to "now"
      let t = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
      if (t.substr(0, 1) != 1 && t.substr(0, 1) != 2) {
        t = "0" + t;
      }
      if (t > "10:30:00") {
        $("#time1").attr("disabled", true);
      }
      if (t > "14:00:00") {
        $("#time2").attr("disabled", true);
      }
      if (t > "17:30:00") {
        $("#time3").attr("disabled", true);
      }
    } else {
      $("#time1").attr("disabled", false);
      $("#time2").attr("disabled", false);
      $("#time3").attr("disabled", false);
    }

    // Reset Variables
    day = $("#inputSelectDate").val().substr(0, 1);
    datePrint = new Date(date).toDateString();
    if (day == 1) {
      $(".branch-date").text(datePrint);
    } else if (day == 2) {
      $(".branch-date").text(datePrint);
    } else if (day == 3) {
      $(".branch-date").text(datePrint);
    } else if (day == 4) {
      $(".branch-date").text(datePrint);
    } else if (day == 5) {
      $(".branch-date").text(datePrint);
    } else if (day == 6) {
      $(".branch-date").text(datePrint);
    } else {
      $(".branch-date").text(datePrint);
    }
    $(".branch-time").text("");
    $(".branch-quantity").text("");
    $(".branch-price").text("");
    seats = "";
    price = "";
    quantity = undefined;
    resetSeatsVar();
  });

  // Time
  $("#inputSelectTime").change(function () {
    // Uncheck all seats
    uncheckSeats();
    // Enable seats
    enableSeats();

    $("#printTotal").text("0");
    $("#printSubtotal").text("0");
    $("#checkCount").text("0");
    time = $("#inputSelectTime").val();
    movie_id = $(".movie_id").attr("id");
    day = $("#inputSelectDate").val().substr(0, 1);

    $.ajax({
      url: "../config/server/reservation_data.php",
      method: "POST",
      data: {
        movie_id: movie_id,
        theater: theater,
        day: day,
        time: time,
      },
      dataType: "json",
      success: function (data) {
        $(".movie_id").val(movie_id);

        // Set Reserved Seats
        // A
        if (data.a1 == "A1") {
          $("#customCheckA1").attr("disabled", true);
          $("#customCheckA1").prop("checked", true);
        } else {
          $("#customCheckA1").attr("disabled", false);
          $("#customCheckA1").prop("checked", false);
        }
        if (data.a2 == "A2") {
          $("#customCheckA2").attr("disabled", true);
          $("#customCheckA2").prop("checked", true);
        } else {
          $("#customCheckA2").attr("disabled", false);
          $("#customCheckA2").prop("checked", false);
        }
        if (data.a3 == "A3") {
          $("#customCheckA3").attr("disabled", true);
          $("#customCheckA3").prop("checked", true);
        } else {
          $("#customCheckA3").attr("disabled", false);
          $("#customCheckA3").prop("checked", false);
        }
        if (data.a4 == "A4") {
          $("#customCheckA4").attr("disabled", true);
          $("#customCheckA4").prop("checked", true);
        } else {
          $("#customCheckA4").attr("disabled", false);
          $("#customCheckA4").prop("checked", false);
        }
        if (data.a5 == "A5") {
          $("#customCheckA5").attr("disabled", true);
          $("#customCheckA5").prop("checked", true);
        } else {
          $("#customCheckA5").attr("disabled", false);
          $("#customCheckA5").prop("checked", false);
        }
        if (data.a6 == "A6") {
          $("#customCheckA6").attr("disabled", true);
          $("#customCheckA6").prop("checked", true);
        } else {
          $("#customCheckA6").attr("disabled", false);
          $("#customCheckA6").prop("checked", false);
        }
        if (data.a7 == "A7") {
          $("#customCheckA7").attr("disabled", true);
          $("#customCheckA7").prop("checked", true);
        } else {
          $("#customCheckA7").attr("disabled", false);
          $("#customCheckA7").prop("checked", false);
        }
        if (data.a8 == "A8") {
          $("#customCheckA8").attr("disabled", true);
          $("#customCheckA8").prop("checked", true);
        } else {
          $("#customCheckA8").attr("disabled", false);
          $("#customCheckA8").prop("checked", false);
        }
        // B
        if (data.b1 == "B1") {
          $("#customCheckB1").attr("disabled", true);
          $("#customCheckB1").prop("checked", true);
        } else {
          $("#customCheckB1").attr("disabled", false);
          $("#customCheckB1").prop("checked", false);
        }
        if (data.b2 == "B2") {
          $("#customCheckB2").attr("disabled", true);
          $("#customCheckB2").prop("checked", true);
        } else {
          $("#customCheckB2").attr("disabled", false);
          $("#customCheckB2").prop("checked", false);
        }
        if (data.b3 == "B3") {
          $("#customCheckB3").attr("disabled", true);
          $("#customCheckB3").prop("checked", true);
        } else {
          $("#customCheckB3").attr("disabled", false);
          $("#customCheckB3").prop("checked", false);
        }
        if (data.b4 == "B4") {
          $("#customCheckB4").attr("disabled", true);
          $("#customCheckB4").prop("checked", true);
        } else {
          $("#customCheckB4").attr("disabled", false);
          $("#customCheckB4").prop("checked", false);
        }
        if (data.b5 == "B5") {
          $("#customCheckB5").attr("disabled", true);
          $("#customCheckB5").prop("checked", true);
        } else {
          $("#customCheckB5").attr("disabled", false);
          $("#customCheckB5").prop("checked", false);
        }
        if (data.b6 == "B6") {
          $("#customCheckB6").attr("disabled", true);
          $("#customCheckB6").prop("checked", true);
        } else {
          $("#customCheckB6").attr("disabled", false);
          $("#customCheckB6").prop("checked", false);
        }
        if (data.b7 == "B7") {
          $("#customCheckB7").attr("disabled", true);
          $("#customCheckB7").prop("checked", true);
        } else {
          $("#customCheckB7").attr("disabled", false);
          $("#customCheckB7").prop("checked", false);
        }
        if (data.b8 == "B8") {
          $("#customCheckB8").attr("disabled", true);
          $("#customCheckB8").prop("checked", true);
        } else {
          $("#customCheckB8").attr("disabled", false);
          $("#customCheckB8").prop("checked", false);
        }
        if (data.b9 == "B9") {
          $("#customCheckB9").attr("disabled", true);
          $("#customCheckB9").prop("checked", true);
        } else {
          $("#customCheckB9").attr("disabled", false);
          $("#customCheckB9").prop("checked", false);
        }
        if (data.b10 == "B10") {
          $("#customCheckB10").attr("disabled", true);
          $("#customCheckB10").prop("checked", true);
        } else {
          $("#customCheckB10").attr("disabled", false);
          $("#customCheckB10").prop("checked", false);
        }
        // C
        if (data.c1 == "C1") {
          $("#customCheckC1").attr("disabled", true);
          $("#customCheckC1").prop("checked", true);
        } else {
          $("#customCheckC1").attr("disabled", false);
          $("#customCheckC1").prop("checked", false);
        }
        if (data.c2 == "C2") {
          $("#customCheckC2").attr("disabled", true);
          $("#customCheckC2").prop("checked", true);
        } else {
          $("#customCheckC2").attr("disabled", false);
          $("#customCheckC2").prop("checked", false);
        }
        if (data.c3 == "C3") {
          $("#customCheckC3").attr("disabled", true);
          $("#customCheckC3").prop("checked", true);
        } else {
          $("#customCheckC3").attr("disabled", false);
          $("#customCheckC3").prop("checked", false);
        }
        if (data.c4 == "C4") {
          $("#customCheckC4").attr("disabled", true);
          $("#customCheckC4").prop("checked", true);
        } else {
          $("#customCheckC4").attr("disabled", false);
          $("#customCheckC4").prop("checked", false);
        }
        if (data.c5 == "C5") {
          $("#customCheckC5").attr("disabled", true);
          $("#customCheckC5").prop("checked", true);
        } else {
          $("#customCheckC5").attr("disabled", false);
          $("#customCheckC5").prop("checked", false);
        }
        if (data.c6 == "C6") {
          $("#customCheckC6").attr("disabled", true);
          $("#customCheckC6").prop("checked", true);
        } else {
          $("#customCheckC6").attr("disabled", false);
          $("#customCheckC6").prop("checked", false);
        }
        if (data.c7 == "C7") {
          $("#customCheckC7").attr("disabled", true);
          $("#customCheckC7").prop("checked", true);
        } else {
          $("#customCheckC7").attr("disabled", false);
          $("#customCheckC7").prop("checked", false);
        }
        if (data.c8 == "C8") {
          $("#customCheckC8").attr("disabled", true);
          $("#customCheckC8").prop("checked", true);
        } else {
          $("#customCheckC8").attr("disabled", false);
          $("#customCheckC8").prop("checked", false);
        }
        if (data.c9 == "C9") {
          $("#customCheckC9").attr("disabled", true);
          $("#customCheckC9").prop("checked", true);
        } else {
          $("#customCheckC9").attr("disabled", false);
          $("#customCheckC9").prop("checked", false);
        }
        if (data.c10 == "C10") {
          $("#customCheckC10").attr("disabled", true);
          $("#customCheckC10").prop("checked", true);
        } else {
          $("#customCheckC10").attr("disabled", false);
          $("#customCheckC10").prop("checked", false);
        }
        // D
        if (data.d1 == "D1") {
          $("#customCheckD1").attr("disabled", true);
          $("#customCheckD1").prop("checked", true);
        } else {
          $("#customCheckD1").attr("disabled", false);
          $("#customCheckD1").prop("checked", false);
        }
        if (data.d2 == "D2") {
          $("#customCheckD2").attr("disabled", true);
          $("#customCheckD2").prop("checked", true);
        } else {
          $("#customCheckD2").attr("disabled", false);
          $("#customCheckD2").prop("checked", false);
        }
        if (data.d3 == "D3") {
          $("#customCheckD3").attr("disabled", true);
          $("#customCheckD3").prop("checked", true);
        } else {
          $("#customCheckD3").attr("disabled", false);
          $("#customCheckD3").prop("checked", false);
        }
        if (data.d4 == "D4") {
          $("#customCheckD4").attr("disabled", true);
          $("#customCheckD4").prop("checked", true);
        } else {
          $("#customCheckD4").attr("disabled", false);
          $("#customCheckD4").prop("checked", false);
        }
        if (data.d5 == "D5") {
          $("#customCheckD5").attr("disabled", true);
          $("#customCheckD5").prop("checked", true);
        } else {
          $("#customCheckD5").attr("disabled", false);
          $("#customCheckD5").prop("checked", false);
        }
        if (data.d6 == "D6") {
          $("#customCheckD6").attr("disabled", true);
          $("#customCheckD6").prop("checked", true);
        } else {
          $("#customCheckD6").attr("disabled", false);
          $("#customCheckD6").prop("checked", false);
        }
        if (data.d7 == "D7") {
          $("#customCheckD7").attr("disabled", true);
          $("#customCheckD7").prop("checked", true);
        } else {
          $("#customCheckD7").attr("disabled", false);
          $("#customCheckD7").prop("checked", false);
        }
        if (data.d8 == "D8") {
          $("#customCheckD8").attr("disabled", true);
          $("#customCheckD8").prop("checked", true);
        } else {
          $("#customCheckD8").attr("disabled", false);
          $("#customCheckD8").prop("checked", false);
        }
        // E
        if (data.e1 == "E1") {
          $("#customCheckE1").attr("disabled", true);
          $("#customCheckE1").prop("checked", true);
        } else {
          $("#customCheckE1").attr("disabled", false);
          $("#customCheckE1").prop("checked", false);
        }
        if (data.e2 == "E2") {
          $("#customCheckE2").attr("disabled", true);
          $("#customCheckE2").prop("checked", true);
        } else {
          $("#customCheckE2").attr("disabled", false);
          $("#customCheckE2").prop("checked", false);
        }
        if (data.e3 == "E3") {
          $("#customCheckE3").attr("disabled", true);
          $("#customCheckE3").prop("checked", true);
        } else {
          $("#customCheckE3").attr("disabled", false);
          $("#customCheckE3").prop("checked", false);
        }
        if (data.e4 == "E4") {
          $("#customCheckE4").attr("disabled", true);
          $("#customCheckE4").prop("checked", true);
        } else {
          $("#customCheckE4").attr("disabled", false);
          $("#customCheckE4").prop("checked", false);
        }
        if (data.e5 == "E5") {
          $("#customCheckE5").attr("disabled", true);
          $("#customCheckE5").prop("checked", true);
        } else {
          $("#customCheckE5").attr("disabled", false);
          $("#customCheckE5").prop("checked", false);
        }
        if (data.e6 == "E6") {
          $("#customCheckE6").attr("disabled", true);
          $("#customCheckE6").prop("checked", true);
        } else {
          $("#customCheckE6").attr("disabled", false);
          $("#customCheckE6").prop("checked", false);
        }
        if (data.e7 == "E7") {
          $("#customCheckE7").attr("disabled", true);
          $("#customCheckE7").prop("checked", true);
        } else {
          $("#customCheckE7").attr("disabled", false);
          $("#customCheckE7").prop("checked", false);
        }
        if (data.e8 == "E8") {
          $("#customCheckE8").attr("disabled", true);
          $("#customCheckE8").prop("checked", true);
        } else {
          $("#customCheckE8").attr("disabled", false);
          $("#customCheckE8").prop("checked", false);
        }
        // F
        if (data.f1 == "F1") {
          $("#customCheckF1").attr("disabled", true);
          $("#customCheckF1").prop("checked", true);
        } else {
          $("#customCheckF1").attr("disabled", false);
          $("#customCheckF1").prop("checked", false);
        }
        if (data.f2 == "F2") {
          $("#customCheckF2").attr("disabled", true);
          $("#customCheckF2").prop("checked", true);
        } else {
          $("#customCheckF2").attr("disabled", false);
          $("#customCheckF2").prop("checked", false);
        }
        if (data.f3 == "F3") {
          $("#customCheckF3").attr("disabled", true);
          $("#customCheckF3").prop("checked", true);
        } else {
          $("#customCheckF3").attr("disabled", false);
          $("#customCheckF3").prop("checked", false);
        }
        if (data.f4 == "F4") {
          $("#customCheckF4").attr("disabled", true);
          $("#customCheckF4").prop("checked", true);
        } else {
          $("#customCheckF4").attr("disabled", false);
          $("#customCheckF4").prop("checked", false);
        }
        if (data.f5 == "F5") {
          $("#customCheckF5").attr("disabled", true);
          $("#customCheckF5").prop("checked", true);
        } else {
          $("#customCheckF5").attr("disabled", false);
          $("#customCheckF5").prop("checked", false);
        }
        if (data.f6 == "F6") {
          $("#customCheckF6").attr("disabled", true);
          $("#customCheckF6").prop("checked", true);
        } else {
          $("#customCheckF6").attr("disabled", false);
          $("#customCheckF6").prop("checked", false);
        }
        if (data.f7 == "F7") {
          $("#customCheckF7").attr("disabled", true);
          $("#customCheckF7").prop("checked", true);
        } else {
          $("#customCheckF7").attr("disabled", false);
          $("#customCheckF7").prop("checked", false);
        }
        if (data.f8 == "F8") {
          $("#customCheckF8").attr("disabled", true);
          $("#customCheckF8").prop("checked", true);
        } else {
          $("#customCheckF8").attr("disabled", false);
          $("#customCheckF8").prop("checked", false);
        }
        if (data.f9 == "F9") {
          $("#customCheckF9").attr("disabled", true);
          $("#customCheckF9").prop("checked", true);
        } else {
          $("#customCheckF9").attr("disabled", false);
          $("#customCheckF9").prop("checked", false);
        }
        if (data.f10 == "F10") {
          $("#customCheckF10").attr("disabled", true);
          $("#customCheckF10").prop("checked", true);
        } else {
          $("#customCheckF10").attr("disabled", false);
          $("#customCheckF10").prop("checked", false);
        }
        // G
        if (data.g1 == "G1") {
          $("#customCheckG1").attr("disabled", true);
          $("#customCheckG1").prop("checked", true);
        } else {
          $("#customCheckG1").attr("disabled", false);
          $("#customCheckG1").prop("checked", false);
        }
        if (data.g2 == "G2") {
          $("#customCheckG2").attr("disabled", true);
          $("#customCheckG2").prop("checked", true);
        } else {
          $("#customCheckG2").attr("disabled", false);
          $("#customCheckG2").prop("checked", false);
        }
        if (data.g3 == "G3") {
          $("#customCheckG3").attr("disabled", true);
          $("#customCheckG3").prop("checked", true);
        } else {
          $("#customCheckG3").attr("disabled", false);
          $("#customCheckG3").prop("checked", false);
        }
        if (data.g4 == "G4") {
          $("#customCheckG4").attr("disabled", true);
          $("#customCheckG4").prop("checked", true);
        } else {
          $("#customCheckG4").attr("disabled", false);
          $("#customCheckG4").prop("checked", false);
        }
        if (data.g5 == "G5") {
          $("#customCheckG5").attr("disabled", true);
          $("#customCheckG5").prop("checked", true);
        } else {
          $("#customCheckG5").attr("disabled", false);
          $("#customCheckG5").prop("checked", false);
        }
        if (data.g6 == "G6") {
          $("#customCheckG6").attr("disabled", true);
          $("#customCheckG6").prop("checked", true);
        } else {
          $("#customCheckG6").attr("disabled", false);
          $("#customCheckG6").prop("checked", false);
        }
        if (data.g7 == "G7") {
          $("#customCheckG7").attr("disabled", true);
          $("#customCheckG7").prop("checked", true);
        } else {
          $("#customCheckG7").attr("disabled", false);
          $("#customCheckG7").prop("checked", false);
        }
        if (data.g8 == "G8") {
          $("#customCheckG8").attr("disabled", true);
          $("#customCheckG8").prop("checked", true);
        } else {
          $("#customCheckG8").attr("disabled", false);
          $("#customCheckG8").prop("checked", false);
        }
        if (data.g9 == "G9") {
          $("#customCheckG9").attr("disabled", true);
          $("#customCheckG9").prop("checked", true);
        } else {
          $("#customCheckG9").attr("disabled", false);
          $("#customCheckG9").prop("checked", false);
        }
        if (data.g10 == "G10") {
          $("#customCheckG10").attr("disabled", true);
          $("#customCheckG10").prop("checked", true);
        } else {
          $("#customCheckG10").attr("disabled", false);
          $("#customCheckG10").prop("checked", false);
        }
        // C
        if (data.h1 == "H1") {
          $("#customCheckH1").attr("disabled", true);
          $("#customCheckH1").prop("checked", true);
        } else {
          $("#customCheckH1").attr("disabled", false);
          $("#customCheckH1").prop("checked", false);
        }
        if (data.h2 == "H2") {
          $("#customCheckH2").attr("disabled", true);
          $("#customCheckH2").prop("checked", true);
        } else {
          $("#customCheckH2").attr("disabled", false);
          $("#customCheckH2").prop("checked", false);
        }
        if (data.h3 == "H3") {
          $("#customCheckH3").attr("disabled", true);
          $("#customCheckH3").prop("checked", true);
        } else {
          $("#customCheckH3").attr("disabled", false);
          $("#customCheckH3").prop("checked", false);
        }
        if (data.h4 == "H4") {
          $("#customCheckH4").attr("disabled", true);
          $("#customCheckH4").prop("checked", true);
        } else {
          $("#customCheckH4").attr("disabled", false);
          $("#customCheckH4").prop("checked", false);
        }
        if (data.h5 == "H5") {
          $("#customCheckH5").attr("disabled", true);
          $("#customCheckH5").prop("checked", true);
        } else {
          $("#customCheckH5").attr("disabled", false);
          $("#customCheckH5").prop("checked", false);
        }
        if (data.h6 == "H6") {
          $("#customCheckH6").attr("disabled", true);
          $("#customCheckH6").prop("checked", true);
        } else {
          $("#customCheckH6").attr("disabled", false);
          $("#customCheckH6").prop("checked", false);
        }
        if (data.h7 == "H7") {
          $("#customCheckH7").attr("disabled", true);
          $("#customCheckH7").prop("checked", true);
        } else {
          $("#customCheckH7").attr("disabled", false);
          $("#customCheckH7").prop("checked", false);
        }
        if (data.h8 == "H8") {
          $("#customCheckH8").attr("disabled", true);
          $("#customCheckH8").prop("checked", true);
        } else {
          $("#customCheckH8").attr("disabled", false);
          $("#customCheckH8").prop("checked", false);
        }
        if (data.h9 == "H9") {
          $("#customCheckH9").attr("disabled", true);
          $("#customCheckH9").prop("checked", true);
        } else {
          $("#customCheckH9").attr("disabled", false);
          $("#customCheckH9").prop("checked", false);
        }
        if (data.h10 == "H10") {
          $("#customCheckH10").attr("disabled", true);
          $("#customCheckH10").prop("checked", true);
        } else {
          $("#customCheckH10").attr("disabled", false);
          $("#customCheckH10").prop("checked", false);
        }

        // Reset Variables
        if (time == 1) {
          $(".branch-time").text("9:30 am");
        } else if (time == 2) {
          $(".branch-time").text("1:00 pm");
        } else {
          $(".branch-time").text("4:30 pm");
        }
        $(".branch-quantity").text("");
        $(".branch-price").text("");
        seats = "";
        price = "";
        quantity = undefined;
        resetSeatsVar();
      },
    });
  });

  // Count & Store Seats
  $(".checkCounter").change(function () {
    price = $("#printTotal").text();
    quantity = $("#checkCount").text();

    $(".branch-price").text("₱" + price + ".00");

    // Get Seats Value
    getSeatsValue();
  });

  // Transaction
  $("#purchase_button").click(function () {
    // Reset seats record
    seats = " ";

    // Store checked seats
    storeCheckedSeats();

    if (quantity != undefined) {
      $(".branch-quantity").text("( " + quantity + " )");
    }
    $(".branch-seat").text(seats);
  });

  // PayPal Checkout
  paypal
    .Buttons({
      createOrder: function (data, actions) {
        return actions.order.create({
          purchase_units: [
            {
              amount: {
                value: price,
              },
            },
          ],
        });
      },
      onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
          //console.log(details);
          $.ajax({
            url: "../config/server/transaction_update.php",
            method: "POST",
            data: {
              // Post data of variables
              movie_id: movie_id,
              day: day,
              datePrint: datePrint,
              today: today,
              theater: theater,
              date: date,
              time: time,
              price: price,
              quantity: quantity,
              seats: seats,
              seat_a1: seat_a1,
              seat_a2: seat_a2,
              seat_a3: seat_a3,
              seat_a4: seat_a4,
              seat_a5: seat_a5,
              seat_a6: seat_a6,
              seat_a7: seat_a7,
              seat_a8: seat_a8,
              seat_b1: seat_b1,
              seat_b2: seat_b2,
              seat_b3: seat_b3,
              seat_b4: seat_b4,
              seat_b5: seat_b5,
              seat_b6: seat_b6,
              seat_b7: seat_b7,
              seat_b8: seat_b8,
              seat_b9: seat_b9,
              seat_b10: seat_b10,
              seat_c1: seat_c1,
              seat_c2: seat_c2,
              seat_c3: seat_c3,
              seat_c4: seat_c4,
              seat_c5: seat_c5,
              seat_c6: seat_c6,
              seat_c7: seat_c7,
              seat_c8: seat_c8,
              seat_c9: seat_c9,
              seat_c10: seat_c10,
              seat_d1: seat_d1,
              seat_d2: seat_d2,
              seat_d3: seat_d3,
              seat_d4: seat_d4,
              seat_d5: seat_d5,
              seat_d6: seat_d6,
              seat_d7: seat_d7,
              seat_d8: seat_d8,
              seat_e1: seat_e1,
              seat_e2: seat_e2,
              seat_e3: seat_e3,
              seat_e4: seat_e4,
              seat_e5: seat_e5,
              seat_e6: seat_e6,
              seat_e7: seat_e7,
              seat_e8: seat_e8,
              seat_f1: seat_f1,
              seat_f2: seat_f2,
              seat_f3: seat_f3,
              seat_f4: seat_f4,
              seat_f5: seat_f5,
              seat_f6: seat_f6,
              seat_f7: seat_f7,
              seat_f8: seat_f8,
              seat_f9: seat_f9,
              seat_f10: seat_f10,
              seat_g1: seat_g1,
              seat_g2: seat_g2,
              seat_g3: seat_g3,
              seat_g4: seat_g4,
              seat_g5: seat_g5,
              seat_g6: seat_g6,
              seat_g7: seat_g7,
              seat_g8: seat_g8,
              seat_g9: seat_g9,
              seat_g10: seat_g10,
              seat_h1: seat_h1,
              seat_h2: seat_h2,
              seat_h3: seat_h3,
              seat_h4: seat_h4,
              seat_h5: seat_h5,
              seat_h6: seat_h6,
              seat_h7: seat_h7,
              seat_h8: seat_h8,
              seat_h9: seat_h9,
              seat_h10: seat_h10,
            },
            success: function (data) {
              alert(
                "Thank you for purchasing! Please check your email for your ticket redemption."
              );
              location.reload();
            },
          });
        });
      },
      onCancel: function (data) {
        //window.location.replace("home.php");
      },
    })
    .render("#paypal-payment-button");

  /********************************************************************************************/
  // FUNCTIONS CALLED

  // Reset Seats Variable
  function resetSeatsVar() {
    seat_a1 = "";
    seat_a2 = "";
    seat_a3 = "";
    seat_a4 = "";
    seat_a5 = "";
    seat_a6 = "";
    seat_a7 = "";
    seat_a8 = "";
    seat_b1 = "";
    seat_b2 = "";
    seat_b3 = "";
    seat_b4 = "";
    seat_b5 = "";
    seat_b6 = "";
    seat_b7 = "";
    seat_b8 = "";
    seat_b9 = "";
    seat_b10 = "";
    seat_c1 = "";
    seat_c2 = "";
    seat_c3 = "";
    seat_c4 = "";
    seat_c5 = "";
    seat_c6 = "";
    seat_c7 = "";
    seat_c8 = "";
    seat_c9 = "";
    seat_c10 = "";
    seat_d1 = "";
    seat_d2 = "";
    seat_d3 = "";
    seat_d4 = "";
    seat_d5 = "";
    seat_d6 = "";
    seat_d7 = "";
    seat_d8 = "";
    seat_e1 = "";
    seat_e2 = "";
    seat_e3 = "";
    seat_e4 = "";
    seat_e5 = "";
    seat_e6 = "";
    seat_e7 = "";
    seat_e8 = "";
    seat_f1 = "";
    seat_f2 = "";
    seat_f3 = "";
    seat_f4 = "";
    seat_f5 = "";
    seat_f6 = "";
    seat_f7 = "";
    seat_f8 = "";
    seat_f9 = "";
    seat_f10 = "";
    seat_g1 = "";
    seat_g2 = "";
    seat_g3 = "";
    seat_g4 = "";
    seat_g5 = "";
    seat_g6 = "";
    seat_g7 = "";
    seat_g8 = "";
    seat_g9 = "";
    seat_g10 = "";
    seat_h1 = "";
    seat_h2 = "";
    seat_h3 = "";
    seat_h4 = "";
    seat_h5 = "";
    seat_h6 = "";
    seat_h7 = "";
    seat_h8 = "";
    seat_h9 = "";
    seat_h10 = "";
  }

  // Disable all seats
  function disableSeats() {
    // A
    $("#customCheckA1").attr("disabled", true);
    $("#customCheckA2").attr("disabled", true);
    $("#customCheckA3").attr("disabled", true);
    $("#customCheckA4").attr("disabled", true);
    $("#customCheckA5").attr("disabled", true);
    $("#customCheckA6").attr("disabled", true);
    $("#customCheckA7").attr("disabled", true);
    $("#customCheckA8").attr("disabled", true);
    // B
    $("#customCheckB1").attr("disabled", true);
    $("#customCheckB2").attr("disabled", true);
    $("#customCheckB3").attr("disabled", true);
    $("#customCheckB4").attr("disabled", true);
    $("#customCheckB5").attr("disabled", true);
    $("#customCheckB6").attr("disabled", true);
    $("#customCheckB7").attr("disabled", true);
    $("#customCheckB8").attr("disabled", true);
    $("#customCheckB9").attr("disabled", true);
    $("#customCheckB10").attr("disabled", true);
    // C
    $("#customCheckC1").attr("disabled", true);
    $("#customCheckC2").attr("disabled", true);
    $("#customCheckC3").attr("disabled", true);
    $("#customCheckC4").attr("disabled", true);
    $("#customCheckC5").attr("disabled", true);
    $("#customCheckC6").attr("disabled", true);
    $("#customCheckC7").attr("disabled", true);
    $("#customCheckC8").attr("disabled", true);
    $("#customCheckC9").attr("disabled", true);
    $("#customCheckC10").attr("disabled", true);
    // D
    $("#customCheckD1").attr("disabled", true);
    $("#customCheckD2").attr("disabled", true);
    $("#customCheckD3").attr("disabled", true);
    $("#customCheckD4").attr("disabled", true);
    $("#customCheckD5").attr("disabled", true);
    $("#customCheckD6").attr("disabled", true);
    $("#customCheckD7").attr("disabled", true);
    $("#customCheckD8").attr("disabled", true);
    // E
    $("#customCheckE1").attr("disabled", true);
    $("#customCheckE2").attr("disabled", true);
    $("#customCheckE3").attr("disabled", true);
    $("#customCheckE4").attr("disabled", true);
    $("#customCheckE5").attr("disabled", true);
    $("#customCheckE6").attr("disabled", true);
    $("#customCheckE7").attr("disabled", true);
    $("#customCheckE8").attr("disabled", true);
    // F
    $("#customCheckF1").attr("disabled", true);
    $("#customCheckF2").attr("disabled", true);
    $("#customCheckF3").attr("disabled", true);
    $("#customCheckF4").attr("disabled", true);
    $("#customCheckF5").attr("disabled", true);
    $("#customCheckF6").attr("disabled", true);
    $("#customCheckF7").attr("disabled", true);
    $("#customCheckF8").attr("disabled", true);
    $("#customCheckF9").attr("disabled", true);
    $("#customCheckF10").attr("disabled", true);
    // G
    $("#customCheckG1").attr("disabled", true);
    $("#customCheckG2").attr("disabled", true);
    $("#customCheckG3").attr("disabled", true);
    $("#customCheckG4").attr("disabled", true);
    $("#customCheckG5").attr("disabled", true);
    $("#customCheckG6").attr("disabled", true);
    $("#customCheckG7").attr("disabled", true);
    $("#customCheckG8").attr("disabled", true);
    $("#customCheckG9").attr("disabled", true);
    $("#customCheckG10").attr("disabled", true);
    // H
    $("#customCheckH1").attr("disabled", true);
    $("#customCheckH2").attr("disabled", true);
    $("#customCheckH3").attr("disabled", true);
    $("#customCheckH4").attr("disabled", true);
    $("#customCheckH5").attr("disabled", true);
    $("#customCheckH6").attr("disabled", true);
    $("#customCheckH7").attr("disabled", true);
    $("#customCheckH8").attr("disabled", true);
    $("#customCheckH9").attr("disabled", true);
    $("#customCheckH10").attr("disabled", true);
  }

  // Uncheck all seats
  function uncheckSeats() {
    // A
    $("#customCheckA1").prop("checked", false);
    $("#customCheckA2").prop("checked", false);
    $("#customCheckA3").prop("checked", false);
    $("#customCheckA4").prop("checked", false);
    $("#customCheckA5").prop("checked", false);
    $("#customCheckA6").prop("checked", false);
    $("#customCheckA7").prop("checked", false);
    $("#customCheckA8").prop("checked", false);
    // B
    $("#customCheckB1").prop("checked", false);
    $("#customCheckB2").prop("checked", false);
    $("#customCheckB3").prop("checked", false);
    $("#customCheckB4").prop("checked", false);
    $("#customCheckB5").prop("checked", false);
    $("#customCheckB6").prop("checked", false);
    $("#customCheckB7").prop("checked", false);
    $("#customCheckB8").prop("checked", false);
    $("#customCheckB9").prop("checked", false);
    $("#customCheckB10").prop("checked", false);
    // C
    $("#customCheckC1").prop("checked", false);
    $("#customCheckC2").prop("checked", false);
    $("#customCheckC3").prop("checked", false);
    $("#customCheckC4").prop("checked", false);
    $("#customCheckC5").prop("checked", false);
    $("#customCheckC6").prop("checked", false);
    $("#customCheckC7").prop("checked", false);
    $("#customCheckC8").prop("checked", false);
    $("#customCheckC9").prop("checked", false);
    $("#customCheckC10").prop("checked", false);
    // D
    $("#customCheckD1").prop("checked", false);
    $("#customCheckD2").prop("checked", false);
    $("#customCheckD3").prop("checked", false);
    $("#customCheckD4").prop("checked", false);
    $("#customCheckD5").prop("checked", false);
    $("#customCheckD6").prop("checked", false);
    $("#customCheckD7").prop("checked", false);
    $("#customCheckD8").prop("checked", false);
    // E
    $("#customCheckE1").prop("checked", false);
    $("#customCheckE2").prop("checked", false);
    $("#customCheckE3").prop("checked", false);
    $("#customCheckE4").prop("checked", false);
    $("#customCheckE5").prop("checked", false);
    $("#customCheckE6").prop("checked", false);
    $("#customCheckE7").prop("checked", false);
    $("#customCheckE8").prop("checked", false);
    // F
    $("#customCheckF1").prop("checked", false);
    $("#customCheckF2").prop("checked", false);
    $("#customCheckF3").prop("checked", false);
    $("#customCheckF4").prop("checked", false);
    $("#customCheckF5").prop("checked", false);
    $("#customCheckF6").prop("checked", false);
    $("#customCheckF7").prop("checked", false);
    $("#customCheckF8").prop("checked", false);
    $("#customCheckF9").prop("checked", false);
    $("#customCheckF10").prop("checked", false);
    // G
    $("#customCheckG1").prop("checked", false);
    $("#customCheckG2").prop("checked", false);
    $("#customCheckG3").prop("checked", false);
    $("#customCheckG4").prop("checked", false);
    $("#customCheckG5").prop("checked", false);
    $("#customCheckG6").prop("checked", false);
    $("#customCheckG7").prop("checked", false);
    $("#customCheckG8").prop("checked", false);
    $("#customCheckG9").prop("checked", false);
    $("#customCheckG10").prop("checked", false);
    // H
    $("#customCheckH1").prop("checked", false);
    $("#customCheckH2").prop("checked", false);
    $("#customCheckH3").prop("checked", false);
    $("#customCheckH4").prop("checked", false);
    $("#customCheckH5").prop("checked", false);
    $("#customCheckH6").prop("checked", false);
    $("#customCheckH7").prop("checked", false);
    $("#customCheckH8").prop("checked", false);
    $("#customCheckH9").prop("checked", false);
    $("#customCheckH10").prop("checked", false);
  }

  // Enable all seats
  function enableSeats() {
    // A
    $("#customCheckA1").attr("disabled", false);
    $("#customCheckA2").attr("disabled", false);
    $("#customCheckA3").attr("disabled", false);
    $("#customCheckA4").attr("disabled", false);
    $("#customCheckA5").attr("disabled", false);
    $("#customCheckA6").attr("disabled", false);
    $("#customCheckA7").attr("disabled", false);
    $("#customCheckA8").attr("disabled", false);
    // B
    $("#customCheckB1").attr("disabled", false);
    $("#customCheckB2").attr("disabled", false);
    $("#customCheckB3").attr("disabled", false);
    $("#customCheckB4").attr("disabled", false);
    $("#customCheckB5").attr("disabled", false);
    $("#customCheckB6").attr("disabled", false);
    $("#customCheckB7").attr("disabled", false);
    $("#customCheckB8").attr("disabled", false);
    $("#customCheckB9").attr("disabled", false);
    $("#customCheckB10").attr("disabled", false);
    // C
    $("#customCheckC1").attr("disabled", false);
    $("#customCheckC2").attr("disabled", false);
    $("#customCheckC3").attr("disabled", false);
    $("#customCheckC4").attr("disabled", false);
    $("#customCheckC5").attr("disabled", false);
    $("#customCheckC6").attr("disabled", false);
    $("#customCheckC7").attr("disabled", false);
    $("#customCheckC8").attr("disabled", false);
    $("#customCheckC9").attr("disabled", false);
    $("#customCheckC10").attr("disabled", false);
    // D
    $("#customCheckD1").attr("disabled", false);
    $("#customCheckD2").attr("disabled", false);
    $("#customCheckD3").attr("disabled", false);
    $("#customCheckD4").attr("disabled", false);
    $("#customCheckD5").attr("disabled", false);
    $("#customCheckD6").attr("disabled", false);
    $("#customCheckD7").attr("disabled", false);
    $("#customCheckD8").attr("disabled", false);
    // E
    $("#customCheckE1").attr("disabled", false);
    $("#customCheckE2").attr("disabled", false);
    $("#customCheckE3").attr("disabled", false);
    $("#customCheckE4").attr("disabled", false);
    $("#customCheckE5").attr("disabled", false);
    $("#customCheckE6").attr("disabled", false);
    $("#customCheckE7").attr("disabled", false);
    $("#customCheckE8").attr("disabled", false);
    // F
    $("#customCheckF1").attr("disabled", false);
    $("#customCheckF2").attr("disabled", false);
    $("#customCheckF3").attr("disabled", false);
    $("#customCheckF4").attr("disabled", false);
    $("#customCheckF5").attr("disabled", false);
    $("#customCheckF6").attr("disabled", false);
    $("#customCheckF7").attr("disabled", false);
    $("#customCheckF8").attr("disabled", false);
    $("#customCheckF9").attr("disabled", false);
    $("#customCheckF10").attr("disabled", false);
    // G
    $("#customCheckG1").attr("disabled", false);
    $("#customCheckG2").attr("disabled", false);
    $("#customCheckG3").attr("disabled", false);
    $("#customCheckG4").attr("disabled", false);
    $("#customCheckG5").attr("disabled", false);
    $("#customCheckG6").attr("disabled", false);
    $("#customCheckG7").attr("disabled", false);
    $("#customCheckG8").attr("disabled", false);
    $("#customCheckG9").attr("disabled", false);
    $("#customCheckG10").attr("disabled", false);
    // H
    $("#customCheckH1").attr("disabled", false);
    $("#customCheckH2").attr("disabled", false);
    $("#customCheckH3").attr("disabled", false);
    $("#customCheckH4").attr("disabled", false);
    $("#customCheckH5").attr("disabled", false);
    $("#customCheckH6").attr("disabled", false);
    $("#customCheckH7").attr("disabled", false);
    $("#customCheckH8").attr("disabled", false);
    $("#customCheckH9").attr("disabled", false);
    $("#customCheckH10").attr("disabled", false);
  }

  // Get Seats Value
  function getSeatsValue() {
    // A
    $("#customCheckA1").is(":checked") && !$("#customCheckA1").is(":disabled")
      ? (seat_a1 = $("#customCheckA1").val())
      : (seat_a1 = "");
    $("#customCheckA2").is(":checked") && !$("#customCheckA2").is(":disabled")
      ? (seat_a2 = $("#customCheckA2").val())
      : (seat_a2 = "");
    $("#customCheckA3").is(":checked") && !$("#customCheckA3").is(":disabled")
      ? (seat_a3 = $("#customCheckA3").val())
      : (seat_a3 = "");
    $("#customCheckA4").is(":checked") && !$("#customCheckA4").is(":disabled")
      ? (seat_a4 = $("#customCheckA4").val())
      : (seat_a4 = "");
    $("#customCheckA5").is(":checked") && !$("#customCheckA5").is(":disabled")
      ? (seat_a5 = $("#customCheckA5").val())
      : (seat_a5 = "");
    $("#customCheckA6").is(":checked") && !$("#customCheckA6").is(":disabled")
      ? (seat_a6 = $("#customCheckA6").val())
      : (seat_a6 = "");
    $("#customCheckA7").is(":checked") && !$("#customCheckA7").is(":disabled")
      ? (seat_a7 = $("#customCheckA7").val())
      : (seat_a7 = "");
    $("#customCheckA8").is(":checked") && !$("#customCheckA8").is(":disabled")
      ? (seat_a8 = $("#customCheckA8").val())
      : (seat_a8 = "");
    // B
    $("#customCheckB1").is(":checked") && !$("#customCheckB1").is(":disabled")
      ? (seat_b1 = $("#customCheckB1").val())
      : (seat_b1 = "");
    $("#customCheckB2").is(":checked") && !$("#customCheckB2").is(":disabled")
      ? (seat_b2 = $("#customCheckB2").val())
      : (seat_b2 = "");
    $("#customCheckB3").is(":checked") && !$("#customCheckB3").is(":disabled")
      ? (seat_b3 = $("#customCheckB3").val())
      : (seat_b3 = "");
    $("#customCheckB4").is(":checked") && !$("#customCheckB4").is(":disabled")
      ? (seat_b4 = $("#customCheckB4").val())
      : (seat_b4 = "");
    $("#customCheckB5").is(":checked") && !$("#customCheckB5").is(":disabled")
      ? (seat_b5 = $("#customCheckB5").val())
      : (seat_b5 = "");
    $("#customCheckB6").is(":checked") && !$("#customCheckB6").is(":disabled")
      ? (seat_b6 = $("#customCheckB6").val())
      : (seat_b6 = "");
    $("#customCheckB7").is(":checked") && !$("#customCheckB7").is(":disabled")
      ? (seat_b7 = $("#customCheckB7").val())
      : (seat_b7 = "");
    $("#customCheckB8").is(":checked") && !$("#customCheckB8").is(":disabled")
      ? (seat_b8 = $("#customCheckB8").val())
      : (seat_b8 = "");
    $("#customCheckB9").is(":checked") && !$("#customCheckB9").is(":disabled")
      ? (seat_b9 = $("#customCheckB9").val())
      : (seat_b9 = "");
    $("#customCheckB10").is(":checked") && !$("#customCheckB10").is(":disabled")
      ? (seat_b10 = $("#customCheckB10").val())
      : (seat_b10 = "");
    // C
    $("#customCheckC1").is(":checked") && !$("#customCheckC1").is(":disabled")
      ? (seat_c1 = $("#customCheckC1").val())
      : (seat_c1 = "");
    $("#customCheckC2").is(":checked") && !$("#customCheckC2").is(":disabled")
      ? (seat_c2 = $("#customCheckC2").val())
      : (seat_c2 = "");
    $("#customCheckC3").is(":checked") && !$("#customCheckC3").is(":disabled")
      ? (seat_c3 = $("#customCheckC3").val())
      : (seat_c3 = "");
    $("#customCheckC4").is(":checked") && !$("#customCheckC4").is(":disabled")
      ? (seat_c4 = $("#customCheckC4").val())
      : (seat_c4 = "");
    $("#customCheckC5").is(":checked") && !$("#customCheckC5").is(":disabled")
      ? (seat_c5 = $("#customCheckC5").val())
      : (seat_c5 = "");
    $("#customCheckC6").is(":checked") && !$("#customCheckC6").is(":disabled")
      ? (seat_c6 = $("#customCheckC6").val())
      : (seat_c6 = "");
    $("#customCheckC7").is(":checked") && !$("#customCheckC7").is(":disabled")
      ? (seat_c7 = $("#customCheckC7").val())
      : (seat_c7 = "");
    $("#customCheckC8").is(":checked") && !$("#customCheckC8").is(":disabled")
      ? (seat_c8 = $("#customCheckC8").val())
      : (seat_c8 = "");
    $("#customCheckC9").is(":checked") && !$("#customCheckC9").is(":disabled")
      ? (seat_c9 = $("#customCheckC9").val())
      : (seat_c9 = "");
    $("#customCheckC10").is(":checked") && !$("#customCheckC10").is(":disabled")
      ? (seat_c10 = $("#customCheckC10").val())
      : (seat_c10 = "");
    // D
    $("#customCheckD1").is(":checked") && !$("#customCheckD1").is(":disabled")
      ? (seat_d1 = $("#customCheckD1").val())
      : (seat_d1 = "");
    $("#customCheckD2").is(":checked") && !$("#customCheckD2").is(":disabled")
      ? (seat_d2 = $("#customCheckD2").val())
      : (seat_d2 = "");
    $("#customCheckD3").is(":checked") && !$("#customCheckD3").is(":disabled")
      ? (seat_d3 = $("#customCheckD3").val())
      : (seat_d3 = "");
    $("#customCheckD4").is(":checked") && !$("#customCheckD4").is(":disabled")
      ? (seat_d4 = $("#customCheckD4").val())
      : (seat_d4 = "");
    $("#customCheckD5").is(":checked") && !$("#customCheckD5").is(":disabled")
      ? (seat_d5 = $("#customCheckD5").val())
      : (seat_d5 = "");
    $("#customCheckD6").is(":checked") && !$("#customCheckD6").is(":disabled")
      ? (seat_d6 = $("#customCheckD6").val())
      : (seat_d6 = "");
    $("#customCheckD7").is(":checked") && !$("#customCheckD7").is(":disabled")
      ? (seat_d7 = $("#customCheckD7").val())
      : (seat_d7 = "");
    $("#customCheckD8").is(":checked") && !$("#customCheckD8").is(":disabled")
      ? (seat_d8 = $("#customCheckD8").val())
      : (seat_d8 = "");
    // E
    $("#customCheckE1").is(":checked") && !$("#customCheckE1").is(":disabled")
      ? (seat_e1 = $("#customCheckE1").val())
      : (seat_e1 = "");
    $("#customCheckE2").is(":checked") && !$("#customCheckE2").is(":disabled")
      ? (seat_e2 = $("#customCheckE2").val())
      : (seat_e2 = "");
    $("#customCheckE3").is(":checked") && !$("#customCheckE3").is(":disabled")
      ? (seat_e3 = $("#customCheckE3").val())
      : (seat_e3 = "");
    $("#customCheckE4").is(":checked") && !$("#customCheckE4").is(":disabled")
      ? (seat_e4 = $("#customCheckE4").val())
      : (seat_e4 = "");
    $("#customCheckE5").is(":checked") && !$("#customCheckE5").is(":disabled")
      ? (seat_e5 = $("#customCheckE5").val())
      : (seat_e5 = "");
    $("#customCheckE6").is(":checked") && !$("#customCheckE6").is(":disabled")
      ? (seat_e6 = $("#customCheckE6").val())
      : (seat_e6 = "");
    $("#customCheckE7").is(":checked") && !$("#customCheckE7").is(":disabled")
      ? (seat_e7 = $("#customCheckE7").val())
      : (seat_e7 = "");
    $("#customCheckE8").is(":checked") && !$("#customCheckE8").is(":disabled")
      ? (seat_e8 = $("#customCheckE8").val())
      : (seat_e8 = "");
    // F
    $("#customCheckF1").is(":checked") && !$("#customCheckF1").is(":disabled")
      ? (seat_f1 = $("#customCheckF1").val())
      : (seat_f1 = "");
    $("#customCheckF2").is(":checked") && !$("#customCheckF2").is(":disabled")
      ? (seat_f2 = $("#customCheckF2").val())
      : (seat_f2 = "");
    $("#customCheckF3").is(":checked") && !$("#customCheckF3").is(":disabled")
      ? (seat_f3 = $("#customCheckF3").val())
      : (seat_f3 = "");
    $("#customCheckF4").is(":checked") && !$("#customCheckF4").is(":disabled")
      ? (seat_f4 = $("#customCheckF4").val())
      : (seat_f4 = "");
    $("#customCheckF5").is(":checked") && !$("#customCheckF5").is(":disabled")
      ? (seat_f5 = $("#customCheckF5").val())
      : (seat_f5 = "");
    $("#customCheckF6").is(":checked") && !$("#customCheckF6").is(":disabled")
      ? (seat_f6 = $("#customCheckF6").val())
      : (seat_f6 = "");
    $("#customCheckF7").is(":checked") && !$("#customCheckF7").is(":disabled")
      ? (seat_f7 = $("#customCheckF7").val())
      : (seat_f7 = "");
    $("#customCheckF8").is(":checked") && !$("#customCheckF8").is(":disabled")
      ? (seat_f8 = $("#customCheckF8").val())
      : (seat_f8 = "");
    $("#customCheckF9").is(":checked") && !$("#customCheckF9").is(":disabled")
      ? (seat_f9 = $("#customCheckF9").val())
      : (seat_f9 = "");
    $("#customCheckF10").is(":checked") && !$("#customCheckF10").is(":disabled")
      ? (seat_f10 = $("#customCheckF10").val())
      : (seat_f10 = "");
    // G
    $("#customCheckG1").is(":checked") && !$("#customCheckG1").is(":disabled")
      ? (seat_g1 = $("#customCheckG1").val())
      : (seat_g1 = "");
    $("#customCheckG2").is(":checked") && !$("#customCheckG2").is(":disabled")
      ? (seat_g2 = $("#customCheckG2").val())
      : (seat_g2 = "");
    $("#customCheckG3").is(":checked") && !$("#customCheckG3").is(":disabled")
      ? (seat_g3 = $("#customCheckG3").val())
      : (seat_g3 = "");
    $("#customCheckG4").is(":checked") && !$("#customCheckG4").is(":disabled")
      ? (seat_g4 = $("#customCheckG4").val())
      : (seat_g4 = "");
    $("#customCheckG5").is(":checked") && !$("#customCheckG5").is(":disabled")
      ? (seat_g5 = $("#customCheckG5").val())
      : (seat_g5 = "");
    $("#customCheckG6").is(":checked") && !$("#customCheckG6").is(":disabled")
      ? (seat_g6 = $("#customCheckG6").val())
      : (seat_g6 = "");
    $("#customCheckG7").is(":checked") && !$("#customCheckG7").is(":disabled")
      ? (seat_g7 = $("#customCheckG7").val())
      : (seat_g7 = "");
    $("#customCheckG8").is(":checked") && !$("#customCheckG8").is(":disabled")
      ? (seat_g8 = $("#customCheckG8").val())
      : (seat_g8 = "");
    $("#customCheckG9").is(":checked") && !$("#customCheckG9").is(":disabled")
      ? (seat_g9 = $("#customCheckG9").val())
      : (seat_g9 = "");
    $("#customCheckG10").is(":checked") && !$("#customCheckG10").is(":disabled")
      ? (seat_g10 = $("#customCheckG10").val())
      : (seat_g10 = "");
    // H
    $("#customCheckH1").is(":checked") && !$("#customCheckH1").is(":disabled")
      ? (seat_h1 = $("#customCheckH1").val())
      : (seat_h1 = "");
    $("#customCheckH2").is(":checked") && !$("#customCheckH2").is(":disabled")
      ? (seat_h2 = $("#customCheckH2").val())
      : (seat_h2 = "");
    $("#customCheckH3").is(":checked") && !$("#customCheckH3").is(":disabled")
      ? (seat_h3 = $("#customCheckH3").val())
      : (seat_h3 = "");
    $("#customCheckH4").is(":checked") && !$("#customCheckH4").is(":disabled")
      ? (seat_h4 = $("#customCheckH4").val())
      : (seat_h4 = "");
    $("#customCheckH5").is(":checked") && !$("#customCheckH5").is(":disabled")
      ? (seat_h5 = $("#customCheckH5").val())
      : (seat_h5 = "");
    $("#customCheckH6").is(":checked") && !$("#customCheckH6").is(":disabled")
      ? (seat_h6 = $("#customCheckH6").val())
      : (seat_h6 = "");
    $("#customCheckH7").is(":checked") && !$("#customCheckH7").is(":disabled")
      ? (seat_h7 = $("#customCheckH7").val())
      : (seat_h7 = "");
    $("#customCheckH8").is(":checked") && !$("#customCheckH8").is(":disabled")
      ? (seat_h8 = $("#customCheckH8").val())
      : (seat_h8 = "");
    $("#customCheckH9").is(":checked") && !$("#customCheckH9").is(":disabled")
      ? (seat_h9 = $("#customCheckH9").val())
      : (seat_h9 = "");
    $("#customCheckH10").is(":checked") && !$("#customCheckH10").is(":disabled")
      ? (seat_h10 = $("#customCheckH10").val())
      : (seat_h10 = "");
  }

  // Store checked seats
  function storeCheckedSeats() {
    seats = seats + " " + seat_a1;
    seats = seats + " " + seat_a2;
    seats = seats + " " + seat_a3;
    seats = seats + " " + seat_a4;
    seats = seats + " " + seat_a5;
    seats = seats + " " + seat_a6;
    seats = seats + " " + seat_a7;
    seats = seats + " " + seat_a8;
    seats = seats + " " + seat_b1;
    seats = seats + " " + seat_b2;
    seats = seats + " " + seat_b3;
    seats = seats + " " + seat_b4;
    seats = seats + " " + seat_b5;
    seats = seats + " " + seat_b6;
    seats = seats + " " + seat_b7;
    seats = seats + " " + seat_b8;
    seats = seats + " " + seat_b9;
    seats = seats + " " + seat_b10;
    seats = seats + " " + seat_c1;
    seats = seats + " " + seat_c2;
    seats = seats + " " + seat_c3;
    seats = seats + " " + seat_c4;
    seats = seats + " " + seat_c5;
    seats = seats + " " + seat_c6;
    seats = seats + " " + seat_c7;
    seats = seats + " " + seat_c8;
    seats = seats + " " + seat_c9;
    seats = seats + " " + seat_c10;
    seats = seats + " " + seat_d1;
    seats = seats + " " + seat_d2;
    seats = seats + " " + seat_d3;
    seats = seats + " " + seat_d4;
    seats = seats + " " + seat_d5;
    seats = seats + " " + seat_d6;
    seats = seats + " " + seat_d7;
    seats = seats + " " + seat_d8;
    seats = seats + " " + seat_e1;
    seats = seats + " " + seat_e2;
    seats = seats + " " + seat_e3;
    seats = seats + " " + seat_e4;
    seats = seats + " " + seat_e5;
    seats = seats + " " + seat_e6;
    seats = seats + " " + seat_e7;
    seats = seats + " " + seat_e8;
    seats = seats + " " + seat_f1;
    seats = seats + " " + seat_f2;
    seats = seats + " " + seat_f3;
    seats = seats + " " + seat_f4;
    seats = seats + " " + seat_f5;
    seats = seats + " " + seat_f6;
    seats = seats + " " + seat_f7;
    seats = seats + " " + seat_f8;
    seats = seats + " " + seat_f9;
    seats = seats + " " + seat_f10;
    seats = seats + " " + seat_g1;
    seats = seats + " " + seat_g2;
    seats = seats + " " + seat_g3;
    seats = seats + " " + seat_g4;
    seats = seats + " " + seat_g5;
    seats = seats + " " + seat_g6;
    seats = seats + " " + seat_g7;
    seats = seats + " " + seat_g8;
    seats = seats + " " + seat_g9;
    seats = seats + " " + seat_g10;
    seats = seats + " " + seat_h1;
    seats = seats + " " + seat_h2;
    seats = seats + " " + seat_h3;
    seats = seats + " " + seat_h4;
    seats = seats + " " + seat_h5;
    seats = seats + " " + seat_h6;
    seats = seats + " " + seat_h7;
    seats = seats + " " + seat_h8;
    seats = seats + " " + seat_h9;
    seats = seats + " " + seat_h10;
  }
});
