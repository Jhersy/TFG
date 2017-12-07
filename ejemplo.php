<!doctype html>
<head>
  <title>Bootstrap list pager</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script>
  $(document).ready(function () {

    $('#spinner').bind("ajaxSend", function() {
        $(this).show();
    }).bind("ajaxComplete", function() {
        $(this).hide();
    });

});
  </script>
</head>
<body>
<div id="spinner">
  <img src="resources/images/loading2.gif" alt="Loading" />
</div>
  <div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-3">
      <h2>Unpaged list</h2>
      <div class="panel panel-default">
        <div class="panel-heading">Panel heading</div>
        <ul class="list-group">
          <li class="list-group-item">Uno</li>
          <li class="list-group-item">Dos</li>
          <li class="list-group-item">Three</li>
          <li class="list-group-item">Four</li>
          <li class="list-group-item">Five</li>
        </ul>
      </div>
    </div>
    <div class="col-lg-3">
      <h2>Paged list</h2>
      <div class="panel panel-default">
        <div class="panel-heading">Panel heading</div>
        <ul id="myList" class="list-group"></ul>
        <ul class="pager">
          <li class="previous"><a href="" onclick="prevPage(); return false;">«</a></li>
          <li class="next"><a href="" onclick="nextPage(); return false;">»</a></li>
        </ul>
      </div>
    </div>
    <div class="col-lg-5"></div>
  </div>
  <script>
    var items = '[{"Id":1,"Title":"One"},{"Id":2,"Title":"Two"},{"Id":3,"Title":"Three"},{"Id":4,"Title":"Four"},{"Id":5,"Title":"Five"}]';
    var pager = {};
    pager.items = JSON.parse(items);
    pager.itemsPerPage = 3;
    pagerInit(pager);
        
    function bindList() {
      var pgItems = pager.pagedItems[pager.currentPage];
      $("#myList").empty();
      for(var i = 0; i < pgItems.length; i++){
        var option = $('<li class="list-group-item">');
        for( var key in pgItems[i] ){
          option.html(pgItems[i][key]);
        }
        $("#myList").append(option);
      }
    }
    function prevPage(){
      pager.prevPage();
      bindList();
    }
    function nextPage(){
      pager.nextPage();
      bindList();
    }
    function pagerInit(p) {
      p.pagedItems = [];
      p.currentPage = 0;
      if (p.itemsPerPage === undefined) {
        p.itemsPerPage = 5;
      }
      p.prevPage = function () {
	if (p.currentPage > 0) {
          p.currentPage--;
        }
      };
      p.nextPage = function () {
        if (p.currentPage < p.pagedItems.length - 1) {
          p.currentPage++;
        }
      };
      init = function () {
        for (var i = 0; i < p.items.length; i++) {
          if (i % p.itemsPerPage === 0) {
            p.pagedItems[Math.floor(i / p.itemsPerPage)] = [p.items[i]];
          } else {
            p.pagedItems[Math.floor(i / p.itemsPerPage)].push(p.items[i]);
          }
        }
      };
      init();
    }		
    $(function() {
      bindList();
    });
  </script>
</body>
</html>