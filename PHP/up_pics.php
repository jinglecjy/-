<?php
	$typeArr = array("jpg", "png", "gif"); // 允许文件上传格式
	$path = "files/"; // 上传路径
	if(!is_dir($path)) mkdir($path);
	if(isset($_POST)) {
		if($_GET["get"] == "upimg") {
			$name = $_FILES['file']['name'];
			$size = $_FILES['file']['size'];
			$name_tmp = $_FILES['file']['tmp_name'];
			if (empty($name)) {
				echo json_encode(array("error"=>"您还未选择图片"), JSON_UNESCAPED_UNICODE );
				exit;
			}
			$type = strtolower(substr(strrchr($name, '.'), 1)); // 获取文件类型
			if(!in_array($type, $typeArr)) {
				echo json_encode(array("error"=>"请上传jpg, png或gif类型的图片！"), JSON_UNESCAPED_UNICODE );
			}
			if($size>(1024*1024*10)) {
				echo json_encode(array("error"=>"图片大小已超过10MB！"), JSON_UNESCAPED_UNICODE );
				exit;
			}

			$pic_name = time().rand(10000, 99999).".".$type; // 重命名图片
			$pic_url = $path.$pic_name; // 上传后的图片路径+名称
			if(move_uploaded_file($name_tmp, $pic_url)) { // 临时文件转移到目标文件夹
				echo json_encode(array("error"=>"0", "url"=>$pic_url, "name"=>$pic_name), JSON_UNESCAPED_UNICODE );
			} else {
				echo json_encode(array("error"=>"上传有误，请检查服务器配置！"), JSON_UNESCAPED_UNICODE );
			}
		}
	}
	if($_GET['get'] == 'delimg') {
		$imgsrc = $_GET['imgurl'];
		unlink($imgsrc);
		echo 1;
	}
?>