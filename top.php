<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- you can add php code here (similar to nav.php) to print a different title on each page -->
        <title>China Impression</title>

        <meta charset="utf-8">
        <meta name="author" content="Dongzhe Jiang, Hongru Mao, Zecheng jin">
        <meta name="description" content="China Impression">

        <!-- see: http://webdesign.tutsplus.com/tutorials/htmlcss-tutorials/quick-tip-dont-forget-the-viewport-meta-tag/ -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../ChinaImpression/ncss.css" type="text/css" media="screen">

        <?php
        $debug = false;
        
        if(isset($_GET["debug"])){
            $debug = true;
        }
        $domain ="//";
        
        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
        
        $domain .=$server;
        
        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
        
        $path_parts = pathinfo($phpSelf);
        if ($debug) {
            print"<p>Domain: " . $domain;
            print'<p>php Self:' . $phpSelf;
            print '<p>Path Parts<pre>';
            print_r($path_parts);
            print'</pre></p>';
        }
            
        
        
        
        
        
        
        

        
        
        
        
        
        print "\n". '<!--include libraries -->' . "\n";
            
            require_once('lib/security.php');
            
            
            
            
        if($path_parts['filename'] =="form") {
            print"\n<!--include form libraries -->\n";
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }    
            
            print "\n" . '<!--finished including libraries-->' . "\n";
            
            
            
   
        if ($path_parts['filename'] == 'homepage') {
            ?>
        <script type="text/javascript" src="../ChinaImpression/jquery.min.js"></script>
            <script src="../ChinaImpression/jquery.flexslider.js"></script>
         <script type="text/javascript">
                var flexsliderStylesLocation = "../ChinaImpression/flexslider.css";
                $('<link rel="stylesheet" type="text/css" href="' + flexsliderStylesLocation + '" >').appendTo("head");
                $(window).load(function () {

                    $('.flexslider').flexslider({
                        animation: "fade",
                        slideshowSpeed: 3000,
                        animationSpeed: 1000
                    }); 
                    });
            </script>
            <?php
        }
        ?>    
    </head>

    <!-- ######################     Start of Body   ############################ -->
    <?php
// giving each body tag an id really helps with css later on
    print '<body id="' . $path_parts['filename'] . '">';
    
    include 'header.php';
    include 'nav.php';
    
    if($debug){
        print'<p>DEBUG MADE IS ON</P>';
    }
    ?>