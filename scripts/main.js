(function(){
  $('td:contains("Green")').css('color', 'green');
  $('td:contains("Amber")').css('color', 'orange');
  $('td:contains("Red")').css('color', 'red');
  
  var filters = [];
  
  function getCheckedBoxes() {
    var checkboxes = $('input[type="checkbox"]');
    // loop over them all
    for (var i=0; i<checkboxes.length; i++) {
       // And stick the checked ones onto an array...
       if (checkboxes[i].checked) {
          filters.push(checkboxes[i]['name']);
          filters.push([checkboxes[i]['name'], $('input[name="'+ checkboxes[i]['name'] +'-amber-kpi"]').val(), $('input[name="'+ checkboxes[i]['name'] +'-red-kpi"]').val()]);
       }
    }
    return filters;
  }
  
  console.log(getCheckedBoxes());
  
})();