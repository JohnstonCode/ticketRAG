(function(){
  $('td:contains("Green")').css('color', 'green');
  $('td:contains("Amber")').css('color', 'orange');
  $('td:contains("Red")').css('color', 'red');
  
  var filters = [];
  
  function getCheckedBoxes() {
    var checkboxes = $('input[type="checkbox"]');
    for (var i= 0; i < checkboxes.length; i++) {
       if (checkboxes[i].checked) {
          filters.push(checkboxes[i].name);
          filters.push($('input[name="'+ checkboxes[i].name +'-amber-kpi"]').val());
          filters.push($('input[name="'+ checkboxes[i].name +'-red-kpi"]').val());
       }
    }
    return filters;
  }
  
  $('#settings-button').on('click', function(){
    
    var data = JSON.stringify(getCheckedBoxes());
    
    $('#test').val(data);
    document.forms.filter.submit();
      
  });
  
  $('#create-filter').on('click', function(){
    
    var filterName = $("input[name='filter-name']").val();
    
    if(filterName){
      document.forms.createFilter.submit();
    }else {
      $("input[name='filter-name']").next().after('<br /><span style="color: red;">Please enter a filter name.</span>');
    }
    
    return false
    
  });
  
  $.tablesorter.addParser({
    id: 'hourSort',
    is:function(s){return false;},
    format: function(s) {return s.replace(":", "");},
    type: 'numeric'
  });
  
  $.tablesorter.addParser({
    id: 'colorSort',
    is:function(s){return false;},
    format: function(s) {return s.toLowerCase().replace("green" , 1).replace("amber" , 2).replace("red" , 3);},
    type: 'numeric'
  });
  
  $(".sort-table").tablesorter({
    headers: { 
      3:{ sorter:'hourSort'},
      4:{ sorter: 'colorSort'}
    }

  });
  
})();