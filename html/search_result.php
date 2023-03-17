<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <style>
        table {
            border-top: 1px solid #444444;
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px solid #444444;
            padding: 10px;
        }

        td {
            border-bottom: 1px solid #efefef;
            padding: 10px;
        }

        table .even {
            background: #efefef;
        }

        .text {
            text-align: center;
            padding-top: 20px;
            color: #000000
        }

        .text:hover {
            text-decoration: underline;
        }

        a:link {
            color: #57A0EE;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    require("../mysql_settings.php");
    $conn = mysqli_connect(MYSQL_IP, DB_USER, DB_PASSWORD, USE_DB);
    session_start();

    $catagory = $_GET['catgo'];
    $search_con = $_GET['search'];
    $query = "select * from board where $catagory like '%$search_con%' order by number desc";
    $result = mysqli_query($conn, $query);
    // $result = $connect->query($query);
    $total = mysqli_num_rows($result);
    $data_num = $total;

    if($catagory=='title'){
        $catname = '제목';
    } else if($catagory=='id'){
        $catname = '작성자';
    } else if($catagory=='content'){
        $catname = '내용';
    }
    ?>

    <div style="width:1000px; margin:auto">
    <?php
    if (isset($_SESSION['userid'])) {
    ?><b><?php echo $_SESSION['userid']; ?></b>님 반갑습니다.
        <button onclick="location.href='./logout_action.php'" style="float:right; font-size:15.5px;">로그아웃</button>
        <br />
    <?php
    } else {
    ?>
        <button onclick="location.href='./login.php'" style="float:right; font-size:15.5px;">로그인</button>
        <br />
    <?php
    }
    ?>
    </div>

    <p style="font-size:25px; text-align:center"><b>게시판</b></p>
    <div style="width:1000px; margin:auto">전체 글 수 : <?php echo $total; ?></div>
    <div style="width:1000px; margin:auto">
    <div id="search_box">
    <form action="/search_result.php" method="get">
      <select name="catgo">
        <option value="title">제목</option>
        <option value="id">작성자</option>
        <option value="content">내용</option>
      </select>
      <input type="text" name="search" size="40" required="required" /> <button>검색</button>
    </form>
    </div>
    <div>
    <?php echo $catname; ?> : <?php echo $search_con; ?> 검색결과 | <a href="/index.php">홈으로</a>
    </div>
    </div>

    <table align=center>
        <thead align="center">
            <tr>
                <td width="50" align="center">번호</td>
                <td width="500" align="center">제목</td>
                <td width="100" align="center">작성자</td>
                <td width="200" align="center">날짜</td>
                <td width="50" align="center">조회수</td>
            </tr>
        </thead>

        <tbody>
	    <?php
		if(array_key_exists('page', $_POST)){
			printpage($_POST['page']);
		}
    		else{
			printpage(1);
		}
    		function printpage(int $page){
    		    $conn = mysqli_connect(MYSQL_IP, DB_USER, DB_PASSWORD, USE_DB);
		    $start_data = ($page - 1) * 10;
		    global $total;
		    global $catagory;
		    global $search_con;
		    $query = "select * from board where $catagory like '%$search_con%' order by number desc limit $start_data, 10;";

		    $result = mysqli_query($conn, $query);
		    $idx = $total - $start_data;
            	    while ($rows = mysqli_fetch_assoc($result)) {   //result set에서 레코드(행)를 1개씩 리턴
                	if ($idx % 2 == 0) {
            		?>
                    	    <tr class="even">
                            <!--배경색 진하게-->
                    	<?php } else {
                    	?>
                    	    <tr>
                            <!--배경색 그냥-->
                    	<?php } ?>
                    	<td width="50" align="center"><?php echo $idx ?></td>
                    	<td width="500" align="center">
                       	    <a href="read.php?number=<?php echo $rows['number'] ?>">
                            <?php echo $rows['title'] ?>
                    	</td>
                    	<td width="100" align="center"><?php echo $rows['id'] ?></td>
                    	<td width="200" align="center"><?php echo $rows['date'] ?></td>
                    	<td width="50" align="center"><?php echo $rows['hit'] ?></td>
                    	</tr>
                	<?php
                	$idx--;
		    }
		}
                	?>
        </tbody>
    </table>
    <div class = "pagination" align="center">
	<?php
      	    $page_num = ceil($data_num / 10);
	?>
	    <form method = "post">
	        <?php
  		    for($i = 1; $i <= $page_num; $i = $i+1){
			echo "<input type = 'submit' name = 'page' value = '$i'/>";
		    }
		?>
	    </form>
    </div>
    <div class=text>
        <font style="cursor: hand" onClick="location.href='./write.php'">글쓰기</font>
    </div>
</body>

</html>
