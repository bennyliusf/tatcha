<html>
<title>Tatcha Interview Project</title>
<head>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">                
<link rel="stylesheet" href="bootstrap/css/web.css?v=123">                

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-1.2.6.pack.js"></script>
</head>
<body>
    <div class="page">
        <h1>Tatcha Product List</h1>
        <div style="width: 100%; height: 45px;float: left; text-align: right">
                <ul>
                        <li>Sort by
                                <select name="sort" id="sort" onchange="render();">
                                        <option value="name">Name</option>
                                        <option value="sku">SKU</option>
                                </select>
                        </li>
                </ul>
                
                <input type="hidden" name="limit" id="limit" value="10">
        </div>
        <div id="products-grid">
        
        <?php include('response.php'); ?>
        
        </div>

        <span id="loader-icon" style="display: none;"><img src="LoaderIcon.gif" /></span>
        <span id="loader-icon2" style="display: none;"></span>


    </div><!-- page -->
        
<script>

    var gridWidth = $('#products-grid').width();
    var cellWidth = $('div.cell').outerWidth(true);
    
    var itemsPerRow = Math.floor(gridWidth / cellWidth);

    $('#limit').val(itemsPerRow);
    var passlimit = $('#limit').val();

    function render(){
        var sort = $('#sort').val();
        $.ajax({
                url: "response.php?sort="+sort,
                success: function(result){
                        $("#products-grid").html(result);
                        if ($(document).height() == $(window).height()) {
                            $("#loader-icon2").html('<a href="javascript: void(0)" onclick="getresult(\'response.php?page=2&limit='+passlimit+'\');">Loading More</a>');
                            $("#loader-icon2").show();
                        }else{
                            $("#loader-icon2").hide();
                        }
        }});
    }

    function getresult(url) {
            $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function(){
                        if(!$('#endofrecord').val()){
                            $('#loader-icon').show();
                        }
                    },
                    complete: function(){
                        $('#loader-icon').hide();
                    },
                    success: function(data){
                            $("#products-grid").append(data);
                            
                            if ($(document).height() > $(window).height()) {
                                $("#loader-icon2").hide();
                            }
                    },
                    error: function(){} 	        
       });
    }

$(document).ready(function(){
    if ($(document).height() == $(window).height()) {
        $("#loader-icon2").html('<a href="javascript: void(0)" onclick="getresult(\'response.php?page=2&limit='+passlimit+'\');">Loading More</a>');
        $("#loader-icon2").show();
    }else{
        $("#loader-icon2").hide();
    }
    $(window).scroll(function(){
                $("#loader-icon2").hide();

            if ($(window).scrollTop() == $(document).height() - $(window).height()){
                if(!$('#endofrecord').val()){// not end of record
                    var pagenum = parseInt($(".pagenum:last").val()) + 1;
                    getresult('response.php?page='+pagenum+'&limit='+passlimit);
                }
            }
    }); 
});
</script>

</body>
</htm>
