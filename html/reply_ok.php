<?php
    require("../mysql_settings.php");
    $conn = mysqli_connect(MYSQL_IP, DB_USER, DB_PASSWORD, USE_DB);
    session_start(); 
    $id = $_SESSION['userid'];           
    $content = $_POST['content'];       
    $date = date('Y-m-d H:i:s');       
    $number = $_GET['number'];
    $query = "insert into comment(number, board_number, id, content, date, parent_number) values(null,'".$number."','".$id."','".$content."','".$date."',1)";
    $result = $conn->query($query);
    if($result){
        echo "<script>alert('댓글이 작성되었습니다.'); 
        location.href='/read.php?number=$number';</script>";
    }else{
        echo "<script>alert('댓글 작성에 실패했습니다.'); 
        history.back();</script>";
    }
	
?>
