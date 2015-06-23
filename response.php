<?php
    ob_start();
    include_once "Product.php";
    $prod = new Product();
    $rowcount = $prod->getTotalRows();

    $page = 1;
    if(!empty($_GET["page"])) {
        $page = $_GET["page"];
    }

    $perPage = 20;

    if(!empty($_GET["limit"])) {
        $perPage = $_GET["limit"] * 2;
    }

    $sort = 'name';
    if(!empty($_GET["sort"])) {
        $sort = $_GET["sort"];
    }

    $totalPages = ceil($rowcount / $perPage);    
    
    if ($page == $totalPages + 1){

        echo '<input type="hidden" name="endofrecord" id="endofrecord" value="true">'; // end of record
    }else{
    
        $url = "http://api.tatcha.com/shop/api/rest/products?page=".$page."&limit=".$perPage."&order=".$sort."&dir=asc -H 'Accept: text/xml'";
        $prodPrefixUrl = "http://api.tatcha.com/shop/api/rest/products/";

        $prod = new Product();
        $result = $prod->curlProductJSONDecode($url);
    
        $output = '';
        if(!empty($result)) {
            $output .= '<input type="hidden" class="pagenum" value="' . $page . '" />';
            foreach ($result as $value){
                $productId = $value->entity_id;
                $prodUrl = $prodPrefixUrl . $productId;
                $productInfo = $prod->curlProductJSONDecode($prodUrl);
        
                $output .= '<a style="float:left;" href="'. $productInfo->url. '" title="" data-toggle="popover" data-placement="bottom" data-content="'.htmlentities($value->short_description).'"><div class="cell">';
                $output .= '<div class="title">' . $value->name .'</div>';
                $output .= '<div class="image"><img src="' . $value->image_url . '" width="150px"></div>';
                $output .= '</div></a>';
            }
        }
        
        echo $output;
        
    }
    ob_get_contents();
    ob_end_flush();
?>
