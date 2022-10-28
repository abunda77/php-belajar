$(document).ready(function() {
    $('#userForm').submit(function() {
      // showing that something is loading
      $('#response').html("<b>Loading response...</b>");
      /*
       * 'post_receiver.php' - where you will be passing the form data
       * $(this).serialize() - for reading form data quickly
       * function(data){... - data includes the response from post_receiver.php
       */
      $.post('resi.php', $(this).serialize(), function(data) {
        // demonstrate the response
        $('#response').html(data);
      }).fail(function() {
        //if posting your form fails
        alert("Posting failed.");
      });
      // to restrain from refreshing the whole page, the page
      return false;
    });
  });