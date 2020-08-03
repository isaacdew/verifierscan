<?php
include('navbar.php');
include('functions.php');

$results = "<h3 class='text-center'><small>Search trusted fact-checking sites to make sure you're not being bamboozled</small></h3>";

if($_GET) {
    $results = factCheck($_GET['search'], "", $_GET['page']);
    $results = $results['display'];
    $prev = $_GET['page'] - 1;
    $next = $_GET['page'] + 1;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <h1>FactCheck Search<br><small>Powered by Google</small></h1>
                    <form action="factcheck-search.php" method="get" class="form-inline">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Search...">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <input type="hidden" name="page" value="1">
                    </form>
                    <?php echo $results; ?>
                    <nav aria-label="Page navigation">
                      <ul class="pagination center">
                        <li id="prev">
                          <a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=<?php echo $prev; ?>" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                          </a>
                        </li>
                        <li id="1"><a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=1">1</a></li>
                        <li id="2"><a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=2">2</a></li>
                        <li id="3"><a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=3">3</a></li>
                        <li id="4"><a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=4">4</a></li>
                        <li id="5"><a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=5">5</a></li>
                        <li id="next">
                          <a href="factcheck-search.php?search=<?php echo $_GET['search']; ?>&page=<?php echo $next; ?>" aria-label="Next">
                            <span aria-hidden="true">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function (){
    //Show active page
    $('#<?php echo $_GET['page']; ?>').addClass("active");
    
    //Hide prev or next buttons based on page
    var page = <?php echo $_GET['page']; ?>;
    if(page == 1) {
        $('#prev').hide();
    }
    if(page == 5) {
       $('#next').hide();
    }
});
</script>
<?php
include('footer.php');
?>