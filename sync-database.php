<?php
require_once(dirname(__FILE__) . "/lib.inc/functions.php");
require_once(dirname(__FILE__) . "/lib.inc/sync.php");
//require_once(dirname(__FILE__) . "/lib.inc/sign-in.php");

$pageTitle = "Sinkronisasi Database";
require_once(dirname(__FILE__) . "/lib.inc/header.php");
?>
<script src="lib.assets/dashboard/pagination.js"></script>
<script>
  let ajaxURL = 'lib.ajax/database.php';
  $(document).ready(function(){
      let parsed = parseQuery(document.location.search);
      let page = 1;
      if(typeof parsed.page != 'undefined')
      {
        page = parseInt(parsed.page);
      }
      if(isNaN(page) || page < 1)
      {
        page = 1;
      }
    	loadAjax(ajaxURL, page);
      $(document).on('click', 'nav a.page-link', function(e){
        e.preventDefault();
        let lnk = $(this);
        let page = lnk.parent().attr('data-page');
        let href = lnk.attr('href');
        loadAjax(ajaxURL, page);
        history.pushState({ foo: 'bar' }, '', href);
      });
  });

  

  
</script>

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
  </ul>
</nav>

<div class="table-container table-container-overflow">
<table class="table table-data">
  <thead>
  </thead>
  <tbody>
  </tbody>
</table>
</div>


<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
  </ul>
</nav>

<?php
require_once(dirname(__FILE__) . "/lib.inc/footer.php");
?>