(function(){
  $('td:contains("Green")').css('color', 'green');
  $('td:contains("Amber")').css('color', 'orange');
  $('td:contains("Red")').css('color', 'red');
  
  var filters = [];
  
  function getCheckedBoxes() {
    var checkboxes = $('input[type="checkbox"]');
    for (var i=0; i<checkboxes.length; i++) {
       if (checkboxes[i].checked) {
          filters.push(checkboxes[i]['name']);
          filters.push($('input[name="'+ checkboxes[i]['name'] +'-amber-kpi"]').val());
          filters.push($('input[name="'+ checkboxes[i]['name'] +'-red-kpi"]').val());
       }
    }
    return filters;
  }
  
  $('#settings-button').on('click', function(){
    
    var data = JSON.stringify(getCheckedBoxes());
    
    $('#test').val(data);
    document.forms["filter"].submit();
      
  });
  
  $("#JLP-Table").tablesorter();
  
})();