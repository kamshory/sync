<?php
require_once(dirname(__FILE__) . "/lib.inc/functions.php");
require_once(dirname(__FILE__) . "/lib.inc/sync.php");
//require_once(dirname(__FILE__) . "/lib.inc/sign-in.php");

$pageTitle = "Sinkronisasi File";
require_once(dirname(__FILE__) . "/lib.inc/header.php");
?>
<script src="lib.assets/dashboard/pagination.js"></script>
<script>
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
    	$.ajax({
        type:'GET',
        url:'lib.ajax/file.php',
        data:{page:page},
        success:function(result){
          buildPage(result);
        }
      });
  });

  function buildPage(result)
  {
    let paginationStr = createPagination(result);
    $('nav ul.pagination').each(function(){
      $(this).empty().append(paginationStr);
    });
    createData('table.table-data', result);
  }

  
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