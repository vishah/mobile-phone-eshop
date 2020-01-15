<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?=base_url()?>images/favicon.ico" >
        <link rel="icon" type="image/gif" href="<?=base_url()?>images/animated_favicon1.gif" >
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>styles/styles.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>styles/header.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>styles/footer.css">
        <script src="<?=base_url()?>plugins/jquery-2.1.0.min.js"></script>
        <!-- Begin Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- End Bootstrap -->
        <!-- Bootstrap Type Ahead -->
        <script src="<?=base_url()?>plugins/bootstrap3-typeahead.min.js"></script>
        <?php $this->load->view('view_typeahead'); ?>                      
        <!-- /Bootstrap Type Ahead -->
	      <!-- DataTables -->
	      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
	      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	      <!-- /DataTables -->
        <script>
	       $(document).ready(function() {
	           $('#members').DataTable();
	           $('.resolve-btn').click(function(event) {
		             event.preventDefault();
		             var curElement = $(this);
		             var internal_reference = $(this).attr('data-internal_reference');
		             var in_stock = $(this).attr('data-in_stock');
                 console.log(in_stock);
                 if(in_stock==0){
                     in_stock=1;
                 }
                 else {
                     in_stock=0;
                 }
                 console.log(in_stock);
		             // Send the data using post
		             var posting = $.post( "<?=base_url()?>junaidmobile", {
		                 internal_reference:internal_reference,
		                 in_stock:in_stock
		             } );

		             // Change the icon if successfully resolved
		             posting.done(function( data ) {
		                 if( data=="success"){
                         if(in_stock==0){
			                       $(curElement).attr({'data-in_stock':'0'});
			                       $(curElement).html('<span class="glyphicon glyphicon-minus"></span>');
                         }
                         else {
                             $(curElement).attr({'data-in_stock':'1'});
                             $(curElement).html('<span class="glyphicon glyphicon-ok"></span>');                                 
                         }
		                 }
		             });		 
		             
	           });
	           
	       });
        </script>
        <?php $this->load->view('view_google_analytics'); ?>
    </head>
    <body>
        <div class="container-fluid" style="padding:0px;">
            <?php $this->load->view('page_top.php');?>
            <div clas="row">
                <div class="col-md-12">
		                <table id="members" class="display" cellspacing="0" width="100%">
			                  <thead>
			                      <tr>
				                        <th>Phone</th>
				                        <th>In Stock</th>
			                      </tr>
			                  </thead>
			                  <tfoot>
			                      <tr>
				                        <th>Phone</th>
				                        <th>In Stock</th>
			                      </tr>
			                  </tfoot>
			                  <tbody>
			                      <?php foreach($results as $result): ?>			    
				                        <tr>
				                            <td><?=$result['internal_reference']?></td>
				                            <?php if($result['in_stock'] == "1"): ?>
					                              <td>
					                                  <a class="btn btn-default resolve-btn" data-in_stock="1" data-internal_reference="<?=$result['internal_reference']?>" href="#"><span class="glyphicon glyphicon-ok"></span></a>
					                              </td>
				                            <?php else: ?>
					                              <td>
					                                  <a class="btn btn-default resolve-btn" data-in_stock="0" data-internal_reference="<?=$result['internal_reference']?>" href="#"><span class="glyphicon glyphicon-minus"></span></a>
					                              </td>
				                            <?php endif; ?>
				                        </tr>
			                      <?php endforeach; ?>
			                  </tbody>
		                </table>		    
		            </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('footer.php');?>                    
                </div>
            </div>            
        </div><!--container-flud -->
    </body>
</html>

