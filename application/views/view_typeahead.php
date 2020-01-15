<script language="javascript">
 $( document ).ready(function() {
     
     var sourcedata = [
         <?php foreach($searchRecommendations as $recommendation):?>
         {id:"<?=$recommendation['internalReference']?>",name:"<?=$recommendation['displayName']?>"},
         <?php endforeach; ?>                
     ]
     var $input = $('#search');
     $input.typeahead({source:sourcedata, 
                       autoSelect: true,
                       afterSelect:typeaheadSelected,
                       items: 10,
                       autoSelect: false
         
     });
     function typeaheadSelected(data){
         window.location.replace("<?=base_url()?>details/" + data['id']);
     };

     $('#searchgo').on('click',function(e){
         var urlString="<?=base_url()?>catalogue/";                 
         var searchval = $('#search').val();
         urlString = urlString + "search/" + encodeURIComponent(searchval);
         window.location.href=urlString;                 

     });
     $('#search').keyup(function(e){
         if(e.keyCode == 13)
         {
             var urlString="<?=base_url()?>catalogue/";                 
             var searchval = $('#search').val();
             urlString = urlString + "search/" + encodeURIComponent(searchval);
             window.location.href=urlString;                              
         }
     });

     $('#searchform').on('keyup keypress', function(e) {
         var keyCode = e.keyCode || e.which;
         if (keyCode === 13) { 
             e.preventDefault();
             return false;
         }
     });

     //for search2

     var $input = $('#search2');
     $input.typeahead({source:sourcedata, 
                       autoSelect: true,
                       afterSelect:typeaheadSelected,
                       items: 10,
                       autoSelect: false
         
     });
     function typeaheadSelected(data){
         window.location.replace("<?=base_url()?>details/" + data['id']);
     };

     $('#searchgo2').on('click',function(e){
         var urlString="<?=base_url()?>catalogue/";                 
         var searchval = $('#search2').val();
         urlString = urlString + "search/" + encodeURIComponent(searchval);
         window.location.href=urlString;                 

     });
     $('#search2').keyup(function(e){
         if(e.keyCode == 13)
         {
             var urlString="<?=base_url()?>catalogue/";                 
             var searchval = $('#search2').val();
             urlString = urlString + "search/" + encodeURIComponent(searchval);
             window.location.href=urlString;                              
         }
     });

     $('#searchform2').on('keyup keypress', function(e) {
         var keyCode = e.keyCode || e.which;
         if (keyCode === 13) { 
             e.preventDefault();
             return false;
         }
     });          
 });
</script>
