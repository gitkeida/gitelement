<?php
	session_start();
	header("Content-Type:application/json");
	require_once("./init.php");
	//if(!$_SESSION['uid']){die('{"code":300, "msg":"login required"}'); }
	// if(!$_SESSION['uid']){$_SESSION['uid']=1;}
	$mp=false;
	if(!empty($_FILES)&&@$_FILES['file']!=""){	//如果有文件上传就执行
		$mp=true;
		$mypic=$_FILES['file'];		
		$picname=$mypic['name'];		//临时文件名
		$picsize=$mypic['size'];
		$type=strstr($picname,".");		//取后缀
		if($type != '.jpg' && $type != '.png' && $type != '.svg' && $type != '.gif'){
			echo json_encode('{"code":-1, "msg":"文件类型只能是图片类型"}');
			return;
		}
		$filesName=time().rand(1,999).$type;	//现文件名
		$ysrc=$mypic['tmp_name'];		//原路径
		$xsrc="../../images/banner/".$filesName;	//现路径

		$path = "http://119.29.67.165/mineData/images/banner/".$filesName;
		move_uploaded_file($ysrc,$xsrc);
		echo json_encode('{"code":200, "msg":"'.$path.'","type":"'.$type.'"}');
	} else {
		echo json_encode('{"code":-1, "msg":"上传失败"}');
	}
