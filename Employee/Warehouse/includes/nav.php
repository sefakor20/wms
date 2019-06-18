<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><span style="text-transform: capitalize;"><?php echo $_SESSION['gen_user_name']; ?></span></a>
                </div>
                <div class="collapse navbar-collapse"><!--
                    <ul class="nav navbar-nav navbar-left">
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-sm hidden-xs"></b>
                                    <span class="notification hidden-sm hidden-xs"><?php echo $danger_total; ?></span>
                                    <p class="hidden-lg hidden-md">
                                         Notifications
                                        <b class="caret"></b>
                                    </p>
                              </a>
                              <ul class="dropdown-menu">
                                <?php foreach($danger_items as $item): ?>
                                  <li><a href="request_stock.php?id=<?php echo $item->id; ?>"><?php echo $item->item_name.' '.$item->category_name.' has '.$item->quantity.' left';  ?></a></li>
                                <?php endforeach; ?>
                              </ul>
                        </li>
                    </ul>-->

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="my_account.php">
                               <p>Account</p>
                            </a>
                        </li>
                        <li>
                            <a href="../../Warehouse/logout.php">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>