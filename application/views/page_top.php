<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding:7.5px 7.5px;margin-right:10px;" href="<?=base_url()?>"> <img class="logo" src="<?=base_url()?>images/logo.png"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php foreach($navBarLinks as $link): ?>
                    <li class="visible-xs"> <a href="<?=base_url()?>catalogue/category/<?=$link['name']?>"><?=$link['caption_navbar']?></a></li>
                <?php endforeach; ?>
                <li class="dropdown hidden-xs">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick View <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li> <a href="<?=base_url()?>catalogue/">All Phones & Tablets</a></li>
                        <li role="separator" class="divider"></li>          
                        <?php foreach($navBarLinks as $link): ?>
                            <li> <a href="<?=base_url()?>catalogue/category/<?=$link['name']?>"><?=$link['caption_navbar']?></a></li>
                        <?php endforeach; ?>          
                    </ul>
                </li>
            </ul>

	    
            <form id="searchform" class="navbar-form navbar-left hidden-xs" role="search" >
                <div class="input-group">
                    <input name="search" id="search" type="search" data-provide="typeahead" autocomplete="off" class="form-control" placeholder="Search">
		    <span class="input-group-btn">
			<button id="searchgo" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></span>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="" style="padding:7.5px 7.5px;"><img class="facebook" src="<?=base_url()?>images/promotion.png"/></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if($this->loggedIn==1): ?>
                            <li><a href="<?=base_url()?>account">Manage my Account</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=base_url()?>logout">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?=base_url()?>login">Log In</a></li>
                            <li role="separator" class="divider"></li>                        
                            <li><a href="<?=base_url()?>register">Create Account</a></li>
                        <?php endif; ?>                        
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="row visible-xs">
    <div class="col-md-12">
        <form id="searchform2"  role="search" >
            <div class="input-group">
                <input name="search2" id="search2" type="search" data-provide="typeahead" autocomplete="off" class="form-control" placeholder="Search">
		<span class="input-group-btn">
		    <button id="searchgo2" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
		</span>
            </div>
        </form>
	<p></p>
    </div>
</div>
