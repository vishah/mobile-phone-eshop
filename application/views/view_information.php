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
        <script>
         $( document ).ready(function() {


         });
        </script>
        <?php $this->load->view('view_google_analytics'); ?>
    </head>
    <body>
        <div class="container-fluid" style="padding:0px;">
            <?php $this->load->view('page_top.php');?>
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6"><!-- main body col -->
                    <h2>Information</h2>
                    <div class="well well-lg">
                        <?php if(isset($message)): ?>
                            <?=$message;?>
                        <?php endif; ?>
                    </div>
                </div><!-- /main body col -->
                <div class="col-md-3">
                </div>                
            </div><!-- /main body row -->
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('footer.php');?>                    
                </div>
            </div>            
        </div><!--container-flud -->
    </body>
</html>

