<?php
require("../mysql_settings.php");
$conn = mysqli_connect(MYSQL_IP, DB_USER, DB_PASSWORD, USE_DB);
$number = $_GET['number'];

$query = "select id from board where number = $number";
$result = $conn->query($query);
$rows = mysqli_fetch_assoc($result);

$userid = $rows['id'];

session_start();

$URL = "./index.php";
?>

<?php
if (!isset($_SESSION['userid'])) {
?> <script>
        alert("권한이 없습니다.");
        location.replace("<?php echo $URL ?>");
    </script>

<?php } else if ($_SESSION['userid'] == $userid) {
    $query1 = "delete from board where number = $number";
    $result1 = $conn->query($query1); ?>
    <script>
        alert("게시글이 삭제되었습니다.");
        location.replace("<?php echo $URL ?>");
    </script>

<?php } else { ?>
    <script>
        alert("권한이 없습니다.");
        location.replace("<?php echo $URL ?>");
    </script>
<?php }
?>
