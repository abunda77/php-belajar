$(document).ready(function() {
  // how to show elements on page load

  
  
    $('#userForm').submit(function() {
      // showing that something is loading
      $('#response').html("<br><br><p align='center'><b>Process please wait...</b><br><br><img src='assets/loader.gif' width='100' height='100'></p>");
      /*
       * 'post_receiver.php' - where you will be passing the form dataw
       * $(this).serialize() - for reading form data quickly
       * function(data){... - data includes the response from post_receiver.php
       */
      $.ajax({
          type: 'POST',
          url: 'api.php',
          data: $(this).serialize()
        })
        .done(function(data) {
          // demonstrate the response
          $('#response').html(data);
        })
        .fail(function() {
          // if posting your form failed
          alert("Posting failed.");
        });
      // to restrain from refreshing the whole page, it
      return false;
    });
  });