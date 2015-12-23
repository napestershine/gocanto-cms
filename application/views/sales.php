</div></div>
<script src="<?=base_url()?>js/vendor/jquery.min.js"></script>
<script src="<?=base_url()?>js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>
<?php 
$get = '';
foreach ($_GET as $key => $value) {
    if ($key != 'product') {
        $get .= '&'.$key.'='.$value;
    }
}
$product = '';
if (isset($_GET['product'])) {
    $product = $_GET['product'];
}
 ?>
    <iframe src="http://www.secureserver.net/<?=$product?>?prog_id=wsimple<?=$get?>" 
            frameborder="0" 
            style="overflow:hidden;
                   overflow-x:hidden;
                   overflow-y:hidden;
                   height:90%;
                   width:100%;
                   position:absolute;
                   top:45px;
                   left:0px;
                   right:0px;
                   bottom:0px" 
            height="100%" 
            width="100%"></iframe>

</body>
</html>            
