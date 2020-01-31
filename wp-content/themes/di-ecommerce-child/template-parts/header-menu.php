    <!--<header class="masthead text-center">
      <p>15% OFF STUDENT PACKAGES THIS WEEK ONLY - EXPIRES 3/31</p>
    </header>-->
    <!-- Start Navigation -->
<nav class="navbar navbar-expand-md fixed-top light-grey">
  <a class="navbar-brand" href="#">Questions ?&nbsp;
  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14.006" viewBox="0 0 14 14.006">
    <path id="Fill_1" data-name="Fill 1" d="M13.762,10.646,11.949,8.833a.812.812,0,0,0-1.148,0l-.111.111.006.006-.812.812a25.994,25.994,0,0,1-5.64-5.64l.812-.812L5.167,3.2a.812.812,0,0,0,0-1.148L3.354.238a.812.812,0,0,0-1.148,0L2.168.276h0L1.953.491.176,2.268C-1.554,4,10.009,15.56,11.739,13.831l1.777-1.777.186-.186a.759.759,0,0,0,.079-.092.812.812,0,0,0-.018-1.129" fill="#313131"/>
  </svg>&nbsp;
  323 - 277 - 1111</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <?php global $wp;
    $url =  add_query_arg( $wp->query_vars, home_url() );?>
  <div class="navbar-collapse collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav ml-auto">
      <?php echo (stripos($url,'services')!==FALSE) ? '<li class="nav-item active">' : '<li class="nav-item">';?>
      
        <a class="nav-link" href="/rebow/services">Services</a>
      </li>
      <?php echo (stripos($url,'pricing')!==FALSE) ? '<li class="nav-item active">' : '<li class="nav-item">';?>
        <a class="nav-link" href="/rebow/pricing">Pricing</a>
      </li>
      <?php echo (stripos($url,'contact')!==FALSE) ? '<li class="nav-item active">' : '<li class="nav-item">';?>
        <a class="nav-link " href="/rebow/contact">Contact</a>
      </li>
      <?php if(!is_user_logged_in() ){
        echo (stripos($url,'Login')!==FALSE) ? '<li class="nav-item active">' : '<li class="nav-item">';
        echo '<a class="nav-link" href="/rebow/login">Customer Log In</a>
      </li>';
      }
      else{
        echo (stripos($url,'logout')!==FALSE) ? '<li class="nav-item active">' : '<li class="nav-item">';
        echo '<a class="nav-link" href="/rebow/wp-login.php?action=logout">Customer Log Off</a>
      </li>';
      }
      ?>
    </ul>
  </div>
</nav>
<!-- End Navigation -->