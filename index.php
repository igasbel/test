<?php
    session_start();
	require_once "inclusions/config.php";
    require_once "inclusions/functions.php";
    $link_text = $_GET['link_text'];
    if($link_text == ""){
        $link_text = "home";fgfg
    }
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "SELECT `id`, `id_parent`, `link_text`, `address_page`, `type`, `name`, `first_text`, `last_text`, `canonical`, `title`, `description`, `keywords`, `include` FROM `pages` WHERE `link_text` = :link_text";
    $result_sql = $conn->prepare($sql);
    $result_sql->bindValue(":link_text", $link_text, PDO::PARAM_STR);
    $result_sql->execute();
    $result = $result_sql->fetch(PDO::FETCH_ASSOC);
    $conn = null;
	$id_page =  $result['id'];
	$id_parent =  $result['id_parent'];
	$link_text =  $result['link_text'];
	$address_page =  $result['address_page'];
	$type =  $result['type'];
	$name =  $result['name'];
	$first_text =  $result['first_text'];
	$last_text =  $result['last_text'];
	if($link_text != 'home'){
		$canonical =  FULL_ADDRESS_SITE.$link_text."/";
	}else{
		$canonical =  FULL_ADDRESS_SITE;
	}
	$title =  $result['title'];
	$description =  $result['description'];
	$keywords =  $result['keywords'];
	$include =  $result['include'];
	
	if(!$include){
		goto err;
	}
	if($result['address_page']){
        require_once $result['address_page'].$result['link_text'].".php";
    }else{
		err:
		header("HTTP/1.0 404 Not Found");
		echo'<script type="text/javascript"> 
		location.replace("/error-404/"); 
		</script>';
    }
?>	