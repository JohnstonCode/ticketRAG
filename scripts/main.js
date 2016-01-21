(function(){
  $('td:contains("Green")').css('color', 'green');
  $('td:contains("Amber")').css('color', 'orange');
  $('td:contains("Red")').css('color', 'red');
  
  $('.sub').next('td > input').prop('disabled', true);
  
})();