$( document ).ready(function() {
var $input = $('#search');
$input.typeahead({source:[{id: "someId1", name: "Display name 1"}, 
            {id: "someId2", name: "Display name 2"}], 
            autoSelect: true}); 
});
