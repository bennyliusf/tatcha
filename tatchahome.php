<!DOCTYPE html>
<title>Tatcha Interview Project</title>
<head>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">                
<link rel="stylesheet" href="bootstrap/css/web.css?v=409">                

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="bootstrap/js/bootstrap-tooltip.js"></script>
<script src="bootstrap/js/bootstrap-popover.js"></script>
</head>
<body>
    <div class="page">
        <div class="container">
            <h1><img src="bootstrap/img/logo.png"/ style="margin-right: 10px;">Product List</h1>
            <div class="sortbar">
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
            <script>
                $(function (){
                   $('[data-toggle="popover"]').popover();
                });
            </script>
            <div class="footer"></div>
            
            <span id="loader-icon" style="display: none;"><img src="bootstrap/img/LoaderIcon.gif" /></span>
            <span id="loader-icon2" style="display: none;"></span>
        </div><!-- containter -->

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
                            $(function (){
                                $('[data-toggle="popover"]').popover();
                            });

                        if ($(document).height() == $(window).height()) {
                            $("#loader-icon2").html('<a href="javascript: void(0)" onclick="getresult(\'response.php?page=2&limit='+passlimit+'\');"><button type="button" class="btn btn-info">Loading More</button></a>');
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
                            $(function (){
                                $('[data-toggle="popover"]').popover();
                            });
                            
                            if ($(document).height() > $(window).height()) {
                                $("#loader-icon2").hide();
                            }
                    },
                    error: function(){} 	        
       });
    }

    $(document).ready(function(){
        if ($(document).height() == $(window).height()) {
            $("#loader-icon2").html('<a href="javascript: void(0)" onclick="getresult(\'response.php?page=2&limit='+passlimit+'\');"><button type="button" class="btn btn-info">Loading More</button></a>');
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
