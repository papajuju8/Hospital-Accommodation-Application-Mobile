//-***************************************
//-*               ADMIN
//-***************************************
//-*

$(document).ready(function () {
  /********************************************************************************************/
  // SALES
  // Fetch
  var salesTable = $("#sales_table").DataTable({
    scrollY: "50vh",
    scrollCollapse: true,
    paging: false,
    processing: true,
    serverSide: true,
    order: [],
    info: true,
    ajax: {
      url: "../config/server/sales_list.php",
      type: "POST",
    },
    columnDefs: [
      {
        orderable: false,
        targets: [0, 1, 2],
      },
    ],
  });

  /********************************************************************************************/
  // TRANSACTIONS
  // Fetch
  var transacTable = $("#transac_table").DataTable({
    scrollY: "50vh",
    scrollCollapse: true,
    paging: false,
    processing: true,
    serverSide: true,
    order: [],
    info: true,
    ajax: {
      url: "../config/server/transaction_list.php",
      type: "POST",
    },
    columnDefs: [
      {
        orderable: false,
        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
      },
    ],
  });

  /********************************************************************************************/
  // CINEMA
  // Fetch
  var cinemaTable = $("#cinema_table").DataTable({
    scrollY: "50vh",
    scrollCollapse: true,
    paging: false,
    processing: true,
    serverSide: true,
    order: [],
    info: true,
    ajax: {
      url: "../config/server/cinema_list.php",
      type: "POST",
    },
    columnDefs: [
      {
        orderable: false,
        targets: [0, 1, 2, 3, 4],
      },
    ],
  });

  /********************************************************************************************/
  // USERS

  // Fetch
  var userTable = $("#user_table").DataTable({
    scrollY: "50vh",
    scrollCollapse: true,
    paging: false,
    processing: true,
    serverSide: true,
    order: [],
    info: true,
    ajax: {
      url: "../config/server/user_list.php",
      type: "POST",
    },
    columnDefs: [
      {
        orderable: false,
        targets: [0, 1, 2, 3, 4, 5],
      },
    ],
  });

  // Insert
  $(document).on("submit", "#user_form", function (user) {
    user.preventDefault();
    $.ajax({
      url: "../config/server/user_update.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        $("#user_form")[0].reset();
        $("#userModal").modal("hide");
        userTable.ajax.reload();
      },
    });
  });

  // Update
  $(document).on("click", ".edit-user", function () {
    $("#user_transac_table").empty();

    var account_id = $(this).attr("id");
    $.ajax({
      url: "../config/server/user_data.php",
      method: "POST",
      data: {
        account_id: account_id,
      },
      dataType: "json",
      success: function (data) {
        $("#userModal").modal("show");
        $("#user_operation").val("Edit");
        $("#account_id").val(account_id);

        $(".account_id").text(data.account_id);
        $(".user_id").text(data.user_id);
        $(".name").text(data.name);
        $(".username").text(data.username);
        $(".email").text(data.email);
        $(".password").text(data.password);
        $(".address").text(data.address);
        $(".contact").text(data.contact);
        data.gender == 1
          ? $(".gender").text("Male")
          : $(".gender").text("Female");
        $(".birthdate").text(data.birthdate);
        $(".age").text(data.age);
        $(".code").text(data.code);
        data.type == "ADMIN"
          ? $("#type_admin").prop("checked", true)
          : $("#type_user").prop("checked", true);
        data.active == 0
          ? $("#user_inactive").prop("checked", true)
          : $("#user_active").prop("checked", true);

        $(".user-title").text("Edit User Details");

        $(".accountID").text(data.transac1);

        var content = '<table class="table table-bordered table-striped">';
        content +=
          '<thead class="thead-dark"><th>TRANSACTION DATE</th><th>MOVIE</th><th>BRANCH</th><th>CINEMA DATE</th><th>TIME</th><th>TICKETS</th><th>TOTAL</th></thead>';

        var trans_tDate;
        var trans_movie;
        var trans_branch;
        var trans_cDate;
        var trans_time;
        var trans_ticket;
        var trans_total;

        for (i = 0; i < data.count; i++) {
          trans_tDate = "data." + "transac_tDate" + i;
          trans_movie = "data." + "transac_movie" + i;
          trans_branch = "data." + "transac_branch" + i;
          trans_cDate = "data." + "transac_cDate" + i;
          trans_time = "data." + "transac_time" + i;
          trans_ticket = "data." + "transac_seats" + i;
          trans_total = "data." + "transac_price" + i;
          content +=
            "<tr><td>" +
            eval(trans_tDate) +
            "</td><td>" +
            eval(trans_movie) +
            "</td><td>" +
            eval(trans_branch) +
            "</td><td>" +
            eval(trans_cDate) +
            "</td><td>" +
            eval(trans_time) +
            "</td><td>" +
            eval(trans_ticket) +
            "</td><td>" +
            eval(trans_total) +
            "</td></tr>";
        }

        if (data.count == "empty") {
          content +=
            '<tr><td colspan="7" class="text-center">NO TRANSACTIONS YET</td></tr>';
        }

        content += "</table>";

        $("#user_transac_table").append(content);
      },
    });
  });

  /********************************************************************************************/
  // MOVIES

  $("#add_button").click(function () {
    $("#movie_form")[0].reset();
    $(".movie-title").text("Add Movie Details");
    $("#action").val("Add");
    $("#operation").val("Add");
    $(".p-title").text("Movie Poster *");
    $(".pbg-title").text("Movie Poster Background");
    $(".delete").hide();

    // Hide on close
    $("#movie_branch").hide();
    $("#cinema_manila").hide();
    $("#cinema_marikina").hide();
    $("#cinema_north").hide();
    $("#cinema_bacoor").hide();
  });

  // Movies - show branch
  $('input[name="movie_active"]').change(function () {
    if (this.value == 2) {
      $("#movie_branch").show();

      // Update
      $("#active_now").prop("checked", true);
      if ($("#active_now").is(":checked")) {
        var movie_active = $(this).attr("id");
        $.ajax({
          url: "../config/server/movie_data.php",
          method: "POST",
          data: {
            movie_active: movie_active,
          },
          dataType: "json",
          success: function (data) {
            // Manila
            // 1
            if (data.act_1 == 1) {
              $("#1_manila").attr("disabled", true);
            } else {
              $("#1_manila").attr("disabled", false);
            }
            // 2
            if (data.act_2 == 1) {
              $("#2_manila").attr("disabled", true);
            } else {
              $("#2_manila").attr("disabled", false);
            }
            // 3
            if (data.act_3 == 1) {
              $("#3_manila").attr("disabled", true);
            } else {
              $("#3_manila").attr("disabled", false);
            }
            // 4
            if (data.act_4 == 1) {
              $("#4_manila").attr("disabled", true);
            } else {
              $("#4_manila").attr("disabled", false);
            }
            // 5
            if (data.act_5 == 1) {
              $("#5_manila").attr("disabled", true);
            } else {
              $("#5_manila").attr("disabled", false);
            }

            // Marikina
            // 1
            if (data.act_6 == 1) {
              $("#1_marikina").attr("disabled", true);
            } else {
              $("#1_marikina").attr("disabled", false);
            }
            // 2
            if (data.act_7 == 1) {
              $("#2_marikina").attr("disabled", true);
            } else {
              $("#2_marikina").attr("disabled", false);
            }
            // 3
            if (data.act_8 == 1) {
              $("#3_marikina").attr("disabled", true);
            } else {
              $("#3_marikina").attr("disabled", false);
            }
            // 4
            if (data.act_9 == 1) {
              $("#4_marikina").attr("disabled", true);
            } else {
              $("#4_marikina").attr("disabled", false);
            }
            // 5
            if (data.act_10 == 1) {
              $("#5_marikina").attr("disabled", true);
            } else {
              $("#5_marikina").attr("disabled", false);
            }

            // North
            // 1
            if (data.act_11 == 1) {
              $("#1_north").attr("disabled", true);
            } else {
              $("#1_north").attr("disabled", false);
            }
            // 2
            if (data.act_12 == 1) {
              $("#2_north").attr("disabled", true);
            } else {
              $("#2_north").attr("disabled", false);
            }
            // 3
            if (data.act_13 == 1) {
              $("#3_north").attr("disabled", true);
            } else {
              $("#3_north").attr("disabled", false);
            }
            // 4
            if (data.act_14 == 1) {
              $("#4_north").attr("disabled", true);
            } else {
              $("#4_north").attr("disabled", false);
            }
            // 5
            if (data.act_15 == 1) {
              $("#5_north").attr("disabled", true);
            } else {
              $("#5_north").attr("disabled", false);
            }

            // Bacoor
            // 1
            if (data.act_16 == 1) {
              $("#1_bacoor").attr("disabled", true);
            } else {
              $("#1_bacoor").attr("disabled", false);
            }
            // 2
            if (data.act_17 == 1) {
              $("#2_bacoor").attr("disabled", true);
            } else {
              $("#2_bacoor").attr("disabled", false);
            }
            // 3
            if (data.act_18 == 1) {
              $("#3_bacoor").attr("disabled", true);
            } else {
              $("#3_bacoor").attr("disabled", false);
            }
            // 4
            if (data.act_19 == 1) {
              $("#4_bacoor").attr("disabled", true);
            } else {
              $("#4_bacoor").attr("disabled", false);
            }
            // 5
            if (data.act_20 == 1) {
              $("#5_bacoor").attr("disabled", true);
            } else {
              $("#5_bacoor").attr("disabled", false);
            }
          },
        });
      }
    } else {
      $("#movie_branch").hide();
      $("#cinema_manila").hide();
      $("#cinema_marikina").hide();
      $("#cinema_north").hide();
      $("#cinema_bacoor").hide();
      $("#Manila").prop("checked", false);
      $("#Marikina").prop("checked", false);
      $("#North").prop("checked", false);
      $("#Bacoor").prop("checked", false);
      $('input[name="cinema_manila"]').prop("checked", false);
      $('input[name="cinema_marikina"]').prop("checked", false);
      $('input[name="cinema_north"]').prop("checked", false);
      $('input[name="cinema_bacoor"]').prop("checked", false);
    }
  });

  // Movies - show cinema
  $('input[name="Manila"]').change(function () {
    if ($("#Manila").is(":checked")) {
      $("#cinema_manila").show();
    } else {
      $("#cinema_manila").hide();
      $('input[name="cinema_manila"]').prop("checked", false);
    }
  });
  $('input[name="Marikina"]').change(function () {
    if ($("#Marikina").is(":checked")) {
      $("#cinema_marikina").show();
    } else {
      $("#cinema_marikina").hide();
      $('input[name="cinema_marikina"]').prop("checked", false);
    }
  });
  $('input[name="North"]').change(function () {
    if ($("#North").is(":checked")) {
      $("#cinema_north").show();
    } else {
      $("#cinema_north").hide();
      $('input[name="cinema_north"]').prop("checked", false);
    }
  });
  $('input[name="Bacoor"]').change(function () {
    if ($("#Bacoor").is(":checked")) {
      $("#cinema_bacoor").show();
    } else {
      $("#cinema_bacoor").hide();
      $('input[name="cinema_bacoor"]').prop("checked", false);
    }
  });

  // Fetch
  var movieTable = $("#movie_table").DataTable({
    scrollY: "50vh",
    scrollCollapse: true,
    paging: false,
    processing: true,
    serverSide: true,
    order: [],
    info: true,
    ajax: {
      url: "../config/server/movie_list.php",
      type: "POST",
    },
    columnDefs: [
      {
        orderable: false,
        targets: [0, 1, 2, 3, 4, 5],
      },
    ],
  });

  // Insert
  $(document).on("submit", "#movie_form", function (movie) {
    movie.preventDefault();
    var movie = $("#movie").val();
    var description = $("#description").val();
    var duration = $("#duration").val();
    var rated = $("input[name='rated']:checked").val();
    var rating_user = $("#rating_user").val();
    var rating_title = $("#rating_title").val();
    if ($("#action_").is(":checked")) {
      var action = $("#action_").val();
    } else {
      var action = 0;
    }
    if ($("#adventure").is(":checked")) {
      var adventure = $("#adventure").val();
    } else {
      var adventure = 0;
    }
    if ($("#animation").is(":checked")) {
      var animation = $("#animation").val();
    } else {
      var animation = 0;
    }
    if ($("#comedy").is(":checked")) {
      var comedy = $("#comedy").val();
    } else {
      var comedy = 0;
    }
    if ($("#drama").is(":checked")) {
      var drama = $("#drama").val();
    } else {
      var drama = 0;
    }
    if ($("#family").is(":checked")) {
      var family = $("#family").val();
    } else {
      var family = 0;
    }
    if ($("#fantasy").is(":checked")) {
      var fantasy = $("#fantasy").val();
    } else {
      var fantasy = 0;
    }
    if ($("#horror").is(":checked")) {
      var horror = $("#horror").val();
    } else {
      var horror = 0;
    }
    if ($("#musical").is(":checked")) {
      var musical = $("#musical").val();
    } else {
      var musical = 0;
    }
    if ($("#mystery").is(":checked")) {
      var mystery = $("#mystery").val();
    } else {
      var mystery = 0;
    }
    if ($("#romance").is(":checked")) {
      var romance = $("#romance").val();
    } else {
      var romance = 0;
    }
    if ($("#sci").is(":checked")) {
      var sci = $("#sci").val();
    } else {
      var sci = 0;
    }
    if ($("#thriller").is(":checked")) {
      var thriller = $("#thriller").val();
    } else {
      var thriller = 0;
    }
    var trailer = $("#trailer").val();
    var premiereDate = $("#premiereDate").val();
    var price = $("#price").val();
    var movie_active = $("input[name='movie_active']:checked").val();
    if ($("#Manila").is(":checked")) {
      var Manila = $("#Manila").val();
    } else {
      var Manila = 0;
    }
    if ($("#Marikina").is(":checked")) {
      var Marikina = $("#Marikina").val();
    } else {
      var Marikina = 0;
    }
    if ($("#North").is(":checked")) {
      var North = $("#North").val();
    } else {
      var North = 0;
    }
    if ($("#Bacoor").is(":checked")) {
      var Bacoor = $("#Bacoor").val();
    } else {
      var Bacoor = 0;
    }
    var cinema_manila = $("input[name='cinema_manila']:checked").val();
    var cinema_marikina = $("input[name='cinema_marikina']:checked").val();
    var cinema_north = $("input[name='cinema_north']:checked").val();
    var cinema_bacoor = $("input[name='cinema_bacoor']:checked").val();

    if (
      movie != "" &&
      description != "" &&
      duration != "" &&
      rated != undefined &&
      rating_user != "" &&
      rating_title != "" &&
      trailer != "" &&
      premiereDate != "" &&
      price != "" &&
      movie_active != ""
    ) {
      if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 0 &&
        North == 0 &&
        Bacoor == 0
      ) {
        alert("Movie Branch is required. (1 or more)");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 2 &&
        North == 0 &&
        Bacoor == 0 &&
        cinema_marikina == undefined
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 0 &&
        North == 3 &&
        Bacoor == 0 &&
        cinema_north == undefined
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 0 &&
        North == 0 &&
        Bacoor == 4 &&
        cinema_bacoor == undefined
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 2 &&
        North == 3 &&
        Bacoor == 0 &&
        ((cinema_marikina == undefined && cinema_north == undefined) ||
          (cinema_marikina != undefined && cinema_north == undefined) ||
          (cinema_marikina == undefined && cinema_north != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 2 &&
        North == 0 &&
        Bacoor == 4 &&
        ((cinema_marikina == undefined && cinema_bacoor == undefined) ||
          (cinema_marikina != undefined && cinema_bacoor == undefined) ||
          (cinema_marikina == undefined && cinema_bacoor != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 2 &&
        North == 3 &&
        Bacoor == 4 &&
        ((cinema_marikina == undefined &&
          cinema_north == undefined &&
          cinema_bacoor == undefined) ||
          (cinema_marikina != undefined &&
            cinema_north == undefined &&
            cinema_bacoor == undefined) ||
          (cinema_marikina != undefined &&
            cinema_north != undefined &&
            cinema_bacoor == undefined) ||
          (cinema_marikina != undefined &&
            cinema_north == undefined &&
            cinema_bacoor != undefined) ||
          (cinema_marikina == undefined &&
            cinema_north != undefined &&
            cinema_bacoor != undefined) ||
          (cinema_marikina == undefined &&
            cinema_north != undefined &&
            cinema_bacoor == undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 0 &&
        Marikina == 0 &&
        North == 3 &&
        Bacoor == 4 &&
        ((cinema_north == undefined && cinema_bacoor == undefined) ||
          (cinema_north != undefined && cinema_bacoor == undefined) ||
          (cinema_north == undefined && cinema_bacoor != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 0 &&
        North == 0 &&
        Bacoor == 0 &&
        cinema_manila == undefined
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 2 &&
        North == 0 &&
        Bacoor == 0 &&
        ((cinema_manila == undefined && cinema_marikina == undefined) ||
          (cinema_manila != undefined && cinema_marikina == undefined) ||
          (cinema_manila == undefined && cinema_marikina != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 0 &&
        North == 3 &&
        Bacoor == 0 &&
        ((cinema_manila == undefined && cinema_north == undefined) ||
          (cinema_manila != undefined && cinema_north == undefined) ||
          (cinema_manila == undefined && cinema_north != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 0 &&
        North == 0 &&
        Bacoor == 4 &&
        ((cinema_manila == undefined && cinema_bacoor == undefined) ||
          (cinema_manila != undefined && cinema_bacoor == undefined) ||
          (cinema_manila == undefined && cinema_bacoor != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 2 &&
        North == 3 &&
        Bacoor == 0 &&
        ((cinema_manila == undefined &&
          cinema_marikina == undefined &&
          cinema_north == undefined) ||
          (cinema_manila != undefined &&
            cinema_marikina == undefined &&
            cinema_north == undefined) ||
          (cinema_manila != undefined &&
            cinema_marikina != undefined &&
            cinema_north == undefined) ||
          (cinema_manila != undefined &&
            cinema_marikina == undefined &&
            cinema_north != undefined) ||
          (cinema_manila == undefined &&
            cinema_marikina != undefined &&
            cinema_north != undefined) ||
          (cinema_manila == undefined &&
            cinema_marikina != undefined &&
            cinema_north == undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 2 &&
        North == 0 &&
        Bacoor == 4 &&
        ((cinema_manila == undefined &&
          cinema_marikina == undefined &&
          cinema_bacoor == undefined) ||
          (cinema_manila != undefined &&
            cinema_marikina == undefined &&
            cinema_bacoor == undefined) ||
          (cinema_manila != undefined &&
            cinema_marikina != undefined &&
            cinema_bacoor == undefined) ||
          (cinema_manila != undefined &&
            cinema_marikina == undefined &&
            cinema_bacoor != undefined) ||
          (cinema_manila == undefined &&
            cinema_marikina != undefined &&
            cinema_bacoor != undefined) ||
          (cinema_manila == undefined &&
            cinema_marikina != undefined &&
            cinema_bacoor == undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 0 &&
        North == 3 &&
        Bacoor == 4 &&
        ((cinema_manila == undefined &&
          cinema_north == undefined &&
          cinema_bacoor == undefined) ||
          (cinema_manila != undefined &&
            cinema_north == undefined &&
            cinema_bacoor == undefined) ||
          (cinema_manila != undefined &&
            cinema_north != undefined &&
            cinema_bacoor == undefined) ||
          (cinema_manila != undefined &&
            cinema_north == undefined &&
            cinema_bacoor != undefined) ||
          (cinema_manila == undefined &&
            cinema_north != undefined &&
            cinema_bacoor != undefined))
      ) {
        alert("Cinema is required.");
      } else if (
        movie_active == 2 &&
        Manila == 1 &&
        Marikina == 2 &&
        North == 3 &&
        Bacoor == 4
      ) {
        if (
          cinema_manila == undefined &&
          cinema_marikina == undefined &&
          cinema_north == undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina != undefined &&
          cinema_north == undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina == undefined &&
          cinema_north != undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina != undefined &&
          cinema_north != undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina == undefined &&
          cinema_north == undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina != undefined &&
          cinema_north != undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina == undefined &&
          cinema_north != undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila == undefined &&
          cinema_marikina != undefined &&
          cinema_north == undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila != undefined &&
          cinema_marikina == undefined &&
          cinema_north == undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila != undefined &&
          cinema_marikina != undefined &&
          cinema_north == undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila != undefined &&
          cinema_marikina != undefined &&
          cinema_north != undefined &&
          cinema_bacoor == undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila != undefined &&
          cinema_marikina != undefined &&
          cinema_north == undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila != undefined &&
          cinema_marikina == undefined &&
          cinema_north != undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else if (
          cinema_manila != undefined &&
          cinema_marikina == undefined &&
          cinema_north == undefined &&
          cinema_bacoor != undefined
        ) {
          alert("Cinema is required.");
        } else {
          // Add or Update
          $.ajax({
            url: "../config/server/movie_update.php",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (data) {
              if (data == "invalid") {
                alert("Invalid or Empty File.");
              } else {
                $("#movie_form")[0].reset();
                $("#movieModal").modal("hide");
                movieTable.ajax.reload();
                cinemaTable.ajax.reload();
                salesTable.ajax.reload();
              }
            },
          });
        }
      }
      // Add or Update
      else {
        $.ajax({
          url: "../config/server/movie_update.php",
          method: "POST",
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function (data) {
            if (data == "invalid") {
              alert("Invalid or Empty File.");
            } else {
              $("#movie_form")[0].reset();
              $("#movieModal").modal("hide");
              movieTable.ajax.reload();
              cinemaTable.ajax.reload();
              salesTable.ajax.reload();
            }
          },
        });
      }
    } else {
      alert("* fields are required.");
    }
  });

  // Update
  $(document).on("click", ".edit-movie", function () {
    var movie_id = $(this).attr("id");
    $.ajax({
      url: "../config/server/movie_data.php",
      method: "POST",
      data: {
        movie_id: movie_id,
      },
      dataType: "json",
      success: function (data) {
        $("#movie").val(data.movie);
        $("#description").val(data.description);
        $("#duration").val(data.duration);
        $("#rated").val(data.rated);
        if (data.rated == "G") {
          $("#rated_g").prop("checked", true);
        } else if (data.rated == "PG") {
          $("#rated_pg").prop("checked", true);
        } else if (data.rated == "PG-13") {
          $("#rated_pg_13").prop("checked", true);
        } else if (data.rated == "R") {
          $("#rated_r").prop("checked", true);
        } else {
          $("#rated_nc").prop("checked", true);
        }
        $("#rating_user").val(data.rating_user);
        $("#rating_title").val(data.rating_title);
        if (data.action == 1) {
          $("#action_").prop("checked", true);
        } else {
          $("#action_").prop("checked", false);
        }
        if (data.adventure == 2) {
          $("#adventure").prop("checked", true);
        } else {
          $("#adventure").prop("checked", false);
        }
        if (data.animation == 3) {
          $("#animation").prop("checked", true);
        } else {
          $("#animation").prop("checked", false);
        }
        if (data.comedy == 4) {
          $("#comedy").prop("checked", true);
        } else {
          $("#comedy").prop("checked", false);
        }
        if (data.drama == 5) {
          $("#drama").prop("checked", true);
        } else {
          $("#drama").prop("checked", false);
        }
        if (data.family == 6) {
          $("#family").prop("checked", true);
        } else {
          $("#family").prop("checked", false);
        }
        if (data.fantasy == 7) {
          $("#fantasy").prop("checked", true);
        } else {
          $("#fantasy").prop("checked", false);
        }
        if (data.horror == 8) {
          $("#horror").prop("checked", true);
        } else {
          $("#horror").prop("checked", false);
        }
        if (data.musical == 9) {
          $("#musical").prop("checked", true);
        } else {
          $("#musical").prop("checked", false);
        }
        if (data.mystery == 10) {
          $("#mystery").prop("checked", true);
        } else {
          $("#mystery").prop("checked", false);
        }
        if (data.romance == 11) {
          $("#romance").prop("checked", true);
        } else {
          $("#romance").prop("checked", false);
        }
        if (data.sci == 12) {
          $("#sci").prop("checked", true);
        } else {
          $("#sci").prop("checked", false);
        }
        if (data.thriller == 13) {
          $("#thriller").prop("checked", true);
        } else {
          $("#thriller").prop("checked", false);
        }
        $("#trailer").val(data.trailer);
        $("#premiereDate").val(data.premiereDate);
        $("#price").val(data.price);
        $("#movie_active").val(data.movie_active);
        if (data.movie_active == 0) {
          $("#active_inactive").prop("checked", true);
          $("#movie_branch").hide();
          $("#cinema_manila").hide();
          $("#cinema_marikina").hide();
          $("#cinema_north").hide();
          $("#cinema_bacoor").hide();
          $("#Manila").prop("checked", false);
          $("#Marikina").prop("checked", false);
          $("#North").prop("checked", false);
          $("#Bacoor").prop("checked", false);
          $('input[name="cinema_manila"]').prop("checked", false);
          $('input[name="cinema_marikina"]').prop("checked", false);
          $('input[name="cinema_north"]').prop("checked", false);
          $('input[name="cinema_bacoor"]').prop("checked", false);
        } else if (data.movie_active == 1) {
          $("#active_coming").prop("checked", true);
          $("#movie_branch").hide();
          $("#cinema_manila").hide();
          $("#cinema_marikina").hide();
          $("#cinema_north").hide();
          $("#cinema_bacoor").hide();
          $("#Manila").prop("checked", false);
          $("#Marikina").prop("checked", false);
          $("#North").prop("checked", false);
          $("#Bacoor").prop("checked", false);
          $('input[name="cinema_manila"]').prop("checked", false);
          $('input[name="cinema_marikina"]').prop("checked", false);
          $('input[name="cinema_north"]').prop("checked", false);
          $('input[name="cinema_bacoor"]').prop("checked", false);
        } else if (data.movie_active == 2) {
          $("#active_now").prop("checked", true);
          $("#movie_branch").show();
          if (data.Manila == 1) {
            $("#Manila").prop("checked", true);
            $("#cinema_manila").show();
            if (data.cinema_manila == 1) {
              $("#1_manila").prop("checked", true);
            } else if (data.cinema_manila == 2) {
              $("#2_manila").prop("checked", true);
            } else if (data.cinema_manila == 3) {
              $("#3_manila").prop("checked", true);
            } else if (data.cinema_manila == 4) {
              $("#4_manila").prop("checked", true);
            } else {
              $("#5_manila").prop("checked", true);
            }
          } else {
            $("#Manila").prop("checked", false);
            $("#cinema_manila").hide();
            $('input[name="cinema_manila"]').prop("checked", false);
          }
          if (data.Marikina == 2) {
            $("#Marikina").prop("checked", true);
            $("#cinema_marikina").show();
            if (data.cinema_marikina == 1) {
              $("#1_marikina").prop("checked", true);
            } else if (data.cinema_marikina == 2) {
              $("#2_marikina").prop("checked", true);
            } else if (data.cinema_marikina == 3) {
              $("#3_marikina").prop("checked", true);
            } else if (data.cinema_marikina == 4) {
              $("#4_marikina").prop("checked", true);
            } else {
              $("#5_marikina").prop("checked", true);
            }
          } else {
            $("#Marikina").prop("checked", false);
            $("#cinema_marikina").hide();
            $('input[name="cinema_marikina"]').prop("checked", false);
          }
          if (data.North == 3) {
            $("#North").prop("checked", true);
            $("#cinema_north").show();
            if (data.cinema_north == 1) {
              $("#1_north").prop("checked", true);
            } else if (data.cinema_north == 2) {
              $("#2_north").prop("checked", true);
            } else if (data.cinema_north == 3) {
              $("#3_north").prop("checked", true);
            } else if (data.cinema_north == 4) {
              $("#4_north").prop("checked", true);
            } else {
              $("#5_north").prop("checked", true);
            }
          } else {
            $("#North").prop("checked", false);
            $("#cinema_north").hide();
            $('input[name="cinema_north"]').prop("checked", false);
          }
          if (data.Bacoor == 4) {
            $("#Bacoor").prop("checked", true);
            $("#cinema_bacoor").show();
            if (data.cinema_bacoor == 1) {
              $("#1_bacoor").prop("checked", true);
            } else if (data.cinema_bacoor == 2) {
              $("#2_bacoor").prop("checked", true);
            } else if (data.cinema_bacoor == 3) {
              $("#3_bacoor").prop("checked", true);
            } else if (data.cinema_bacoor == 4) {
              $("#4_bacoor").prop("checked", true);
            } else {
              $("#5_bacoor").prop("checked", true);
            }
          } else {
            $("#Bacoor").prop("checked", false);
            $("#cinema_bacoor").hide();
            $('input[name="cinema_bacoor"]').prop("checked", false);
          }

          // Disable
          if ($("#active_now").prop("checked") == true) {
            var movie_active = data.movie_active;
            $.ajax({
              url: "../config/server/movie_data.php",
              method: "POST",
              data: {
                movie_active: movie_active,
              },
              dataType: "json",
              success: function (data) {
                // Manila
                // 1
                if (data.act_1 == 1) {
                  if ($("#1_manila").is(":checked")) {
                    $("#1_manila").attr("disabled", false);
                  } else {
                    $("#1_manila").attr("disabled", true);
                  }
                } else {
                  $("#1_manila").attr("disabled", false);
                }
                // 2
                if (data.act_2 == 1) {
                  if ($("#2_manila").is(":checked")) {
                    $("#2_manila").attr("disabled", false);
                  } else {
                    $("#2_manila").attr("disabled", true);
                  }
                } else {
                  $("#2_manila").attr("disabled", false);
                }
                // 3
                if (data.act_3 == 1) {
                  if ($("#3_manila").is(":checked")) {
                    $("#3_manila").attr("disabled", false);
                  } else {
                    $("#3_manila").attr("disabled", true);
                  }
                } else {
                  $("#3_manila").attr("disabled", false);
                }
                // 4
                if (data.act_4 == 1) {
                  if ($("#4_manila").is(":checked")) {
                    $("#4_manila").attr("disabled", false);
                  } else {
                    $("#4_manila").attr("disabled", true);
                  }
                } else {
                  $("#4_manila").attr("disabled", false);
                }
                // 5
                if (data.act_5 == 1) {
                  if ($("#5_manila").is(":checked")) {
                    $("#5_manila").attr("disabled", false);
                  } else {
                    $("#5_manila").attr("disabled", true);
                  }
                } else {
                  $("#5_manila").attr("disabled", false);
                }

                // Marikina
                // 1
                if (data.act_6 == 1) {
                  if ($("#1_marikina").is(":checked")) {
                    $("#1_marikina").attr("disabled", false);
                  } else {
                    $("#1_marikina").attr("disabled", true);
                  }
                } else {
                  $("#1_marikina").attr("disabled", false);
                }
                // 2
                if (data.act_7 == 1) {
                  if ($("#2_marikina").is(":checked")) {
                    $("#2_marikina").attr("disabled", false);
                  } else {
                    $("#2_marikina").attr("disabled", true);
                  }
                } else {
                  $("#2_marikina").attr("disabled", false);
                }
                // 3
                if (data.act_8 == 1) {
                  if ($("#3_marikina").is(":checked")) {
                    $("#3_marikina").attr("disabled", false);
                  } else {
                    $("#3_marikina").attr("disabled", true);
                  }
                } else {
                  $("#3_marikina").attr("disabled", false);
                }
                // 4
                if (data.act_9 == 1) {
                  if ($("#4_marikina").is(":checked")) {
                    $("#4_marikina").attr("disabled", false);
                  } else {
                    $("#4_marikina").attr("disabled", true);
                  }
                } else {
                  $("#4_marikina").attr("disabled", false);
                }
                // 5
                if (data.act_10 == 1) {
                  if ($("#5_marikina").is(":checked")) {
                    $("#5_marikina").attr("disabled", false);
                  } else {
                    $("#5_marikina").attr("disabled", true);
                  }
                } else {
                  $("#5_marikina").attr("disabled", false);
                }

                // North
                // 1
                if (data.act_11 == 1) {
                  if ($("#1_north").is(":checked")) {
                    $("#1_north").attr("disabled", false);
                  } else {
                    $("#1_north").attr("disabled", true);
                  }
                } else {
                  $("#1_north").attr("disabled", false);
                }
                // 2
                if (data.act_12 == 1) {
                  if ($("#2_north").is(":checked")) {
                    $("#2_north").attr("disabled", false);
                  } else {
                    $("#2_north").attr("disabled", true);
                  }
                } else {
                  $("#2_north").attr("disabled", false);
                }
                // 3
                if (data.act_13 == 1) {
                  if ($("#3_north").is(":checked")) {
                    $("#3_north").attr("disabled", false);
                  } else {
                    $("#3_north").attr("disabled", true);
                  }
                } else {
                  $("#3_north").attr("disabled", false);
                }
                // 4
                if (data.act_14 == 1) {
                  if ($("#4_north").is(":checked")) {
                    $("#4_north").attr("disabled", false);
                  } else {
                    $("#4_north").attr("disabled", true);
                  }
                } else {
                  $("#4_north").attr("disabled", false);
                }
                // 5
                if (data.act_15 == 1) {
                  if ($("#5_north").is(":checked")) {
                    $("#5_north").attr("disabled", false);
                  } else {
                    $("#5_north").attr("disabled", true);
                  }
                } else {
                  $("#5_north").attr("disabled", false);
                }

                // Bacoor
                // 1
                if (data.act_16 == 1) {
                  if ($("#1_bacoor").is(":checked")) {
                    $("#1_bacoor").attr("disabled", false);
                  } else {
                    $("#1_bacoor").attr("disabled", true);
                  }
                } else {
                  $("#1_bacoor").attr("disabled", false);
                }
                // 2
                if (data.act_17 == 1) {
                  if ($("#2_bacoor").is(":checked")) {
                    $("#2_bacoor").attr("disabled", false);
                  } else {
                    $("#2_bacoor").attr("disabled", true);
                  }
                } else {
                  $("#2_bacoor").attr("disabled", false);
                }
                // 3
                if (data.act_18 == 1) {
                  if ($("#3_bacoor").is(":checked")) {
                    $("#3_bacoor").attr("disabled", false);
                  } else {
                    $("#3_bacoor").attr("disabled", true);
                  }
                } else {
                  $("#3_bacoor").attr("disabled", false);
                }
                // 4
                if (data.act_19 == 1) {
                  if ($("#4_bacoor").is(":checked")) {
                    $("#4_bacoor").attr("disabled", false);
                  } else {
                    $("#4_bacoor").attr("disabled", true);
                  }
                } else {
                  $("#4_bacoor").attr("disabled", false);
                }
                // 5
                if (data.act_20 == 1) {
                  if ($("#5_bacoor").is(":checked")) {
                    $("#5_bacoor").attr("disabled", false);
                  } else {
                    $("#5_bacoor").attr("disabled", true);
                  }
                } else {
                  $("#5_bacoor").attr("disabled", false);
                }
              },
            });
          }
        }

        $("#movieModal").modal("show");
        $(".movie-title").text("Edit Movie Details");
        $(".p-title").text("Update Movie Poster");
        $(".pbg-title").text("Update Movie Poster Background");
        $("#movie_id").val(movie_id);
        $("#action").val("Save");
        $("#operation").val("Edit");
        $(".delete").hide(); // TEMP HIDE
        $(".delete").prop("id", movie_id);
      },
    });
  });

  /* 
  // Delete - Not working, because movie has foreign key
  $(document).on("click", ".delete", function () {
    var movie_id = $(this).attr("id");
    if (confirm("Confirm Delete Movie ID: " + movie_id + "?")) {
      $.ajax({
        url: "../config/server/movie_delete.php",
        method: "POST",
        data: {
          movie_id: movie_id,
        },
        success: function (data) {
          movieTable.ajax.reload();
          cinemaTable.ajax.reload();
          $("#movieModal").modal("hide");
          alert(data);
        },
      });
    } else {
      return false;
    }
  });
  */
});
