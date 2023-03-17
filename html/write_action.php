<?php
require("../mysql_settings.php");
$conn = mysqli_connect(MYSQL_IP, DB_USER, DB_PASSWORD, USE_DB);

$id = $_POST['name'];                   //Writer
$title = $_POST['title'];               //Title
$content = $_POST['content'];           //Content
$date = date('Y-m-d H:i:s');            //Date

$URL = './index.php';                   //return URL


$query = "INSERT INTO board (number, title, content, date, hit, id) 
        values(null,'$title', '$content', '$date', 0, '$id')";


$result = $conn->query($query);
if ($result) {
?> <script>
        alert("<?php echo "게시글이 등록되었습니다." ?>");
        location.replace("<?php echo $URL ?>");
    </script>
<?php
} else {
    echo "게시글 등록에 실패하였습니다.";
}

mysqli_close($conn);
?>
