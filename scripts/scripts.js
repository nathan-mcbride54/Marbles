"use strict";
// ------------------------------------------------------------------
// NAME: scripts.js
// DESCRIPTION: All of our sites javascript.
// -------------------------------------------------------------------
var genrePages = {
  "action": 0,
  "adventure": 0,
  "animation": 0,
  "comedy": 0,
  "crime": 0,
  "documentary": 0,
  "drama": 0,
  "family": 0,
  "fantasy": 0,
  "history": 0,
  "horror": 0,
  "music": 0,
  "mystery": 0,
  "romance": 0,
  "science-fiction": 0,
  "tv-movie": 0,
  "thriller": 0,
  "war": 0,
  "western": 0
};

/***********************************
  Sliding sidebar nav javascript
***********************************/
function openNav() {
  document.getElementById("mySidenav").style.width = "35%";
  document.getElementById("main").style.marginLeft = "100%";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";

  // Allow user to click outside of sidenav to close it
  $(document).on("mouseup.sidenav-close", function(e) {
    let $sidenav = $(".sidenav");
    alert("one");
    // If the click is not on the modal window then hide it and unbind the listener.
    if (!$sidenav.is(e.target)) {
      alert("yay");
      closeNav();
      $sidenav.off(".sidenav=close");
    }
  });
}
//250px
/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginRight = "0";
  document.body.style.backgroundColor = "white";
}

$(document).ready(function() {

  /***********************************
    Add Video functions
  ***********************************/

  let viderror = [];

  $("#addvid #title").on("blur", function(ev) {
    viderror["title"] = false;
    let $title = $("#addvid #title");
    let $titleerror = $("#addvid #titleerror");
    $titleerror.remove();
    if ($title.val() == "") {
      //If the name actually contains some information then add a span with an error message.
      $("#addvid #errordiv").append("<div class='error' id='titleerror'> This title is invalid. </div>");
      viderror["title"] = true;
    }
  }); // End of #title.blur

  $("#addvid #year").on("blur", function(ev) {
    viderror["year"] = false;
    let $year = $("#addvid #year");
    let $yearerror = $("#addvid #yearerror");
    $yearerror.remove();
    if ($year.val() == "" || parseInt($year.val()) < 1900 || parseInt($year.val()) > 2030) {
      //If the name actually contains some information then add a span with an error message.
      $("#addvid #errordiv").append("<div class='error' id='yearerror'> This year is invalid. Must be between 1900 and 2030. </div>");
      viderror["year"] = true;
    }
  }); // End of #year.blur

  $("#addvid #mpaa-rating").on("blur", function(ev) {
    viderror["mpaa-rating"] = false;
    let $mpaarating = $("#addvid #mpaa-rating");
    let $mpaaratingerror = $("#addvid #mpaaratingerror");
    $mpaaratingerror.remove();
    if ($mpaarating.val() == "") {
      //If the name actually contains some information then add a span with an error message.
      $("#addvid #errordiv").append("<div class='error' id='mpaaratingerror'> Please select an MPAA rating</div>");
      viderror["mpaa-rating"] = true;
    }
  }); // End of #mpaa-rating.blur

  $("#addvid #genre").on("blur", function(ev) {
    viderror["genre"] = false;
    let $genre = $("#addvid #genre");
    let $genreerror = $("#addvid #genreerror");
    $genreerror.remove();
    if ($genre.val() == "0") {
      //If the name actually contains some information then add a span with an error message.
      $("#addvid #errordiv").append("<div class='error' id='genreerror'> This genre is invalid. </div>");
      viderror["genre"] = true;
    }
  }); // End of #genre.blur

  $("#addvid #theatre-release").on("blur", function(ev) {
    viderror["genre"] = false;
    let $theatrerelease = $("#addvid #theatre-release");
    let $theatrereleaseerror = $("#addvid #theatrereleaseerror");
    $theatrereleaseerror.remove();
    if (!dateIsValid($genre.val())) {
      //If the name actually contains some information then add a span with an error message.
      $("#addvid #errordiv").append("<div class='error' id='theatrereleaseerror'> This date is invalid. Please use the date picker. </div>");
      viderror["name"] = true;
    }
  }); // End of #theatrerelease.blur

  $("#addvid input[type=submit]").on("click", function(ev) {
    // Stop form from being submitted if we do find a true value for the error array (If we do find an error).
    if (viderror.indexOf(true) != -1) {
      ev.preventDefault();
    }
  }); // End of submit.on('click')


  $("#plot").keyup(function() {
    showCharCount();
  });

  $("#plot").blur(function() {
    showCharCount();
  });

  function showCharCount() {
    let charCount = $("#plot").val();
    $("#charCount").html(charCount.length + " / 2500");
  }

  $(".upload-btn-wrapper").hover(
    function() {
      $(".button").css({
        backgroundColor: "#d8b573",
        color: "#000"
      });
    },
    function() {
      $(".button").css({
        backgroundColor: "#282828",
        color: "#d8b573"
      });
    }
  );

  $(function() {
    $(".datepicker").datepicker({
      dateFormat: "yy-mm-dd"
    });
  });

  $(function() {
    $(".mpaa-rating input").checkboxradio();
  });

  $(function() {
    $(".video input").checkboxradio();
  });

  // Function for Star rating
  $(function() {
    $("#rateYo").rateYo({
      spacing: "2px",
      minValue: 0,
      maxValue: 5,
      normalFill: 'black',
      ratedFill: '#edc67f',
      halfStar: true
    });

    $("#rateYo").rateYo()
      .on("rateyo.set", function(e, data) {
        createUserRatingCookie(data.rating);
      });

  });

  // Create a cookie that passes movieId from Index.php to deleteconfirmation.php who can then send to deletevid.php
  function createUserRatingCookie(rating) {
    document.cookie = "userRating=" + rating;
  }
  /***********************************
    Modal Window effects
  ***********************************/
  $("#loginBtn").on("click", function() {
    $("#loginModal").css({
      display: "block"
    });
    // Allow user to click outside of modal windows to close them
    $(document).on("mouseup.close", function(e) {
      let $modal = $(".modal-content>#container");
      // If the click is not on the modal window then hide it and unbind the listener.
      if (!$modal.is(e.target) && $modal.has(e.target).length === 0) {
        $("#loginModal").css({
          display: "none"
        });
        $modal.off(".close");
      }
    });
  });

  $("#navLogin").on("click", function() {
    $("#loginModal").css({
      display: "block"
    });
  });

  $("#registerBtn").on("click", function() {
    $("#registerModal").css({
      display: "block"
    });
    // Allow user to click outside of modal windows to close them
    $(document).on("mouseup.close", function(e) {
      let $modal = $(".modal-content>#container");
      // If the click is not on the modal window then hide it and unbind the listener.
      if (!$modal.is(e.target) && $modal.has(e.target).length === 0) {
        $("#registerModal").css({
          display: "none"
        });
        $modal.off(".close");
      }
    });
  });

  $("#navRegister").on("click", function() {
    $("#registerModal").css({
      display: "block"
    });
  });

  // Must use multiselector because wa sonly closing login Modal and not register modal
  $("#loginModal #closeBtn, #registerModal #closeBtn").on("click", function() {
    // Use regex to select all modal?
    $("#loginModal").css({
      display: "none"
    });
    $("#registerModal").css({
      display: "none"
    });
  });





  /***********************************
    register.php jquery stuff
  ***********************************/


  let error = [];

  // Grab the name textbox from the form-register>name input box and on losing focus...
  $("#form-register #name").on("blur", function(ev) {
    error["name"] = false;
    let $name = $("#form-register #name");
    let $nameerror = $("#form-register #nameerror");
    $nameerror.remove();
    if ($name.val() == "") {
      //If the name actually contains some information then add a span with an error message.
      $("#form-register #errordiv").append("<div class='error' id='nameerror'> This name is invalid. </div>");
      error["name"] = true;
    }
  }); // End of #name.blur

  $("#form-register #email").on("blur", function(ev) {
    error["email"] = false;
    let $email = $("#form-register #email");
    let $emailerror = $("#form-register #emailerror");
    $emailerror.remove();
    // Pass value in the email textbox to emailIsValid function
    if (!emailIsValid($email.val())) {
      //If the name actually contains some information then add a span with an error message.
      $("#form-register #errordiv").append("<div class='error' id='emailerror'> This email is invalid. </div>");
      error["email"] = true;
    }
  }); // End of #email.blur

  $("#form-register input[type=submit]").on("click", function(ev) {
    // Stop form from being submitted if we do find a true value for the error array (If we do find an error).
    if (error.indexOf(true) != -1) {
      ev.preventDefault();
    }
  }); // End of submit.on('click')


  //Function that uses checkusername.php once user leaves the textbox.
  let $username = $("#form-register #username");
  $username.on('blur', function() {
    error["username"] = false;

    //Make a requiest to checkusername.php and pass it the value of the textbox with id#username
    //2. get requires url to send the get to, and following params are the actual parameters to be passed to that url.
    $.get("checkusername.php",
        //1. Selects username by id and then gets value. Saves in anonymous JSON object (key-value pair)
        {
          username: $("#form-register #username").val()
        })
      .done(function(data) {
        //JQuery selector to grab span to be created
        let $usernameerror = $("#form-register #usernameerror");
        $usernameerror.remove();

        if (data) {
          //If the username already exists in table marbles_Users then add a div with an error message.
          $("#form-register #errordiv").append("<div class='error' id='usernameerror'> This username has already registered </div>");
          error["username"] = true;
        }
      })
      //The entire AJAX request fails, eg. incorrect url to .php file.
      .fail(function(jqXHR, textStatus, errorThrown) {
        $("main").prepend("<span class='error'>" + jqXHR.responseText + "</span>");
      });
  });

  $("#form-register #password").on("blur", function(ev) {
    error["password"] = false;
    let $password = $("#form-register #password");
    let $passworderror = $("#form-register #passworderror");
    $passworderror.remove();
    $(".passwordsuggestions").remove();
    let r = zxcvbn($password.val());
    console.log(r);
    if (r.score < 3) {
      $("#form-register #errordiv").append("<div class='error' id='passworderror'> Password Strength: " + r.score + " </div>");
      for (let i = 0; i < r.feedback.suggestions.length; i++) {
        $("#form-register #errordiv").append("<div class='warning passwordsuggestions'> " + r.feedback.suggestions[i] + " </div>");
      }
      error["password"] = true;
    }
  }); // End of #password.blur

  // Grab the name textbox from the form-register>name input box and on losing focus...
  $("#form-register #name").on("blur", function(ev) {
    error["email"] = false;
    let $name = $("#form-register #name");
    let $nameerror = $("#form-register #nameerror");
    $nameerror.remove();
    if ($name.val() == "") {
      //If the name actually contains some information then add a span with an error message.
      $("#form-register #errordiv").append("<div class='error' id='nameerror'> This name is invalid. </div>");
      error["name"] = true;
    }
  }); // End of #name.blur


  /***********************************
    deleteconfirmation.php jquery stuff
  ***********************************/
  //On clicking the Delete icon to open the modal window...
  $(".deleteBtn").on("click", function() {
    //Display the window
    $("#deleteModal").css({
      display: "block"
    });
    //get cookie value from movieId
    let movieId = document.cookie.replace(/(?:(?:^|.*;\s*)movieId\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    // Update the elements to the new values
    $("#movieidInput").val(movieId);

    //Create a listener once modal is brought up
    // Allow user to click outside of modal windows to close them
    $(document).on("mouseup.close", function(e) {
      let $modal = $(".modal-content>#container");
      // If the click is not on the modal window then hide it and unbind the listener.
      if (!$modal.is(e.target) && $modal.has(e.target).length === 0) {
        $("#deleteModal").css({
          display: "none"
        });
        $modal.off(".close");
      }
    });
  });

  // Must use multiselector because wa sonly closing login Modal and not register modal
  $("#deleteModal .closeBtn").on("click", function() {
    // Use regex to select all modal?
    $("#deleteModal").css({
      display: "none"
    });
    $("#deleteModal #input", this).val();
  });


  ////////////////////////// Ajax request
  const url = "https://api.themoviedb.org/3/search/movie?api_key=1978368ea43a13164e532b495dc2e291&query=";
  $("#search").on("click", function(ev) {
    let keywords = $("#title").val();
    let query = url + keywords;

    //Make an AJAX request for a JSON object. Do this before moving onto the next stuff.
    $.when($.getJSON(query, function(response) {
      console.log(response); //this response is a bunch of movies
    })).done( //Once the previous ajax call has finished, do this:
      function(response) {
        let movieId = response.results[0].id;
        console.log(response);
        query = "https://api.themoviedb.org/3/movie/" + movieId + "?api_key=1978368ea43a13164e532b495dc2e291";
        $.when($.getJSON(query, function(response) {
          console.log(response); //this reponse returns a single movie and all of its information
        })).done( //Once the previous ajax call has finished, do this:
          function(response) {

            // Selecting HTML elements
            let $year = $("#addvid #year");
            let $studio = $("#addvid #studio");
            let $runtime = $("#addvid #runtime");
            let $theatrerelease = $("#addvid #dp1555268692190");
            let $plot = $("#addvid #plot");
            let $genre = $("#addvid #genre");
            let $file = $("#addvid #externalCover");
            let $movieInfo = response; //Let $movieInfo be the JSON object from the second call to themoviedb api
            //Set text in HTMl element to information from JSON object
            $year.val($movieInfo.release_date.substr(0, 4));
            console.log($year.val());
            $studio.val($movieInfo.production_companies[0].name);
            $runtime.val($movieInfo.runtime);
            $theatrerelease.val($movieInfo.release_date);
            $plot.val($movieInfo.overview);
            $genre.val($movieInfo.genres[0].name);
            $file.val("https://image.tmdb.org/t/p/w500" + $movieInfo.poster_path);
          });
      });
  });

  ///NextBtn  stuffs

  $(".nextBtn").on('click', function(ev) { //parent() is movierow | parent-parent is genre | parent-parent-children returns all children of parent-parent | parent-parent-children-first gets the first child
  // $(this).prev().prev().removeClass('linkhide');
  //   $(this).prev().prev().addClass('linkshow');
  $(this).prev().prev().css("visibility", "visible");
    ev.preventDefault(); //does not reload page on click
    let genre = $(this).parent().parent().children().first().text().trim().toLowerCase(); //the genre type
    let genreCount = $(this).parent().parent().children().eq(1).text(); //number of movies with that genre

    genrePages[genre]++;
    if ((genrePages[genre]+1) * 4 > genreCount) {
    $(this).css("visibility", "hidden");
}
    let link = $(this).attr('href');
    link += "&pageNum=" + genrePages[genre];
    //  $.get( "movierownext.php", { genre: $(this).parent().parent().children().first().val() } ) //gets the genre type
    $(this).prev().load(link); //Takes the results of this request and dumps all of it intothe movierow html element
  });

  $(".prevBtn").on('click', function(ev) { //parent() is movierow | parent-parent is genre | parent-parent-children returns all children of parent-parent | parent-parent-children-first gets the first child
    ev.preventDefault(); //does not reload page on click
    $(this).next().next().css("visibility", "visible");
    let genre = $(this).parent().parent().children().first().text().trim().toLowerCase();
    let genreCount = $(this).parent().parent().children().eq(1).text();
    if (genrePages[genre] != 0) {
      genrePages[genre]--;
    }
    if (!genrePages[genre] != 0){
      $(this).css("visibility", "hidden");
    }
    let link = $(this).attr('href');
    link += "&pageNum=" + genrePages[genre];
    //  $.get( "movierownext.php", { genre: $(this).parent().parent().children().first().val() } ) //gets the genre type
    $(this).next().load(link); //Takes the results of this request and dumps all of it intothe movierow html element
  });


});
/********************************************************************************************************************************************************************************************************
                                                                                          END OF DOCUMENT.READY
*********************************************************************************************************************************************************************************************************/
//Index finished loading
$("#container-index").ready(function(ev) {

   $(".prevBtn").css("visibility", "hidden");
  let genreCount = $(".genreCount");
  $.each(genreCount, function(key, genre) {
    //var $genre = $(genre);
    if ($(genre).text() <= 4) {
      $(genre).next().children().last().css("visibility", "hidden"); //HIDE THE NEXT BUTTON
    }
  });
});

function emailIsValid(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function dateIsValid(date) {
  return /^[0,1]\d\/[0-3]\d\/[1-2]\d\d\d$/.test(date);
}
