<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>

    <style>
        .read_table {
            border: 1px solid #444444;
            margin-top: 30px;
        }

        .read_title {
            height: 45px;
            font-size: 23.5px;
            text-align: center;
            background-color: #3C3C3C;
            color: white;
            width: 1000px;
        }

        .read_id {
            text-align: center;
            background-color: #EEEEEE;
            width: 30px;
            height: 33px;
        }

        .read_id2 {
            background-color: white;
            width: 60px;
            height: 33px;
            padding-left: 10px;
        }

        .read_hit {
            background-color: #EEEEEE;
            width: 30px;
            text-align: center;
            height: 33px;
        }

        .read_hit2 {
            background-color: white;
            width: 60px;
            height: 33px;
            padding-left: 10px;
        }

        .read_content {
            padding: 20px;
            border-top: 1px solid #444444;
            height: 500px;
        }

        .read_btn {
            width: 700px;
            height: 100px;
            text-align: center;
            margin: auto;
            margin-top: 40px;
        }

        .read_btn1 {
            height: 45px;
            width: 90px;
            font-size: 20px;
            text-align: center;
            background-color: #3C3C3C;
            border: 2px solid black;
            color: white;
            border-radius: 10px;
        }

        .read_comment_input {
            width: 700px;
            height: 500px;
            text-align: center;
            margin: auto;
        }

        .read_text3 {
            font-weight: bold;
            float: left;
            margin-left: 20px;
        }

        .read_com_id {
            width: 100px;
        }

        .read_comment {
            width: 500px;
	}
	/* 댓글 */
	.reply_view {
		width:900px;
		margin-top:100px; 
		word-break:break-all;
	}
	.dap_lo {
		font-size: 14px;
		padding:10px 0 15px 0;
		border-bottom: solid 1px gray;
	}
	.dap_to {
		margin-top:5px;
	}
	.rep_me {
		font-size:12px;
	}
	.rep_me ul li {
		float:left;
		width: 30px;
	}
	.dat_delete {
		display: none;
	}	
	.dat_edit {
		display:none;
	}
	.dap_sm {
		position: absolute;
		top: 10px;
	}
	.dap_edit_t{
		width:520px;
		height:70px;
		position: absolute;
		top: 40px;
	}
	.re_mo_bt {
		position: absolute;
		top:40px;
		right: 5px;
		width: 90px;
		height: 72px;
	}
	#re_content {
		width:700px;
		height: 56px; 
	}
	.dap_ins {
		margin-top:50px;
	}
	.re_bt {
		position: absolute;
		width:100px;
		height:56px;
		font-size:16px;
		margin-left: 10px; 
	}
	#foot_box {
		height: 50px; 
	}


    </style>
</head>

<body>
    <?php
    require("../mysql_settings.php");
    $conn = mysqli_connect(MYSQL_IP, DB_USER, DB_PASSWORD, USE_DB);
    $number = $_GET['number'];  // GET 방식 사용
    session_start();
    $query = "select title, content, date, hit, id from board where number = $number";
    $result = $conn->query($query);
    $rows = mysqli_fetch_assoc($result);

    $hit = "update board set hit = hit + 1 where number = $number";
    $conn->query($hit);
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
    <table class="read_table" align=center>
        <tr>
            <td colspan="4" class="read_title"><?php echo $rows['title'] ?></td>
        </tr>
        <tr>
            <td class="read_id">작성자</td>
            <td class="read_id2"><?php echo $rows['id'] ?></td>
            <td class="read_hit">조회수</td>
            <td class="read_hit2"><?php echo $rows['hit'] + 1 ?></td>
        </tr>


        <tr>
            <td colspan="4" class="read_content" valign="top">
                <?php echo $rows['content'] ?></td>
        </tr>
    </table>
    <div class="read_btn">
        <button class="read_btn1" onclick="location.href='./index.php'">목록</button>&nbsp;&nbsp;
        <?php
        if (isset($_SESSION['userid']) and $_SESSION['userid'] == $rows['id']) { ?>
            <button class="read_btn1" onclick="location.href='./modify.php?number=<?= $number ?>'">수정</button>&nbsp;&nbsp;
            <button class="read_btn1" a onclick="ask();">삭제</button>

            <script>
                function ask() {
                    if (confirm("게시글을 삭제하시겠습니까?")) {
                        window.location = "./delete.php?number=<?= $number ?>"
                    }
                }
            </script>
        <?php } ?>

    </div>
<div class="reply_view" style="width:1000px; margin:auto">
	<h3>댓글목록</h3>
		<?php
			$query = "select * from comment where board_number='".$number."' order by number desc";
			$result = $conn->query($query);
			while($reply = $result->fetch_array()){ 
		?>
		<div class="dap_lo">
			<div><b><?php echo $reply['id'];?></b></div>
			<div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
			<div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
			<?php
		     	if (isset($_SESSION['userid']) and $_SESSION['userid'] == $rows['id']) { ?>
			<div class="rep_me rep_menu">
				<a class="dat_edit_bt" href="#">수정</a>
				<a class="dat_delete_bt" href="#">삭제</a>
			</div>
			<?php } ?>
		</div>

		<?php } ?>






		<!--- 댓글 입력 폼 -->
		<div class="dap_ins">
		<form action="reply_ok.php?number=<?php echo $number; ?>" method="post">
			<div><b><?php echo $_SESSION['userid']; ?></b></div>
			<div style="margin-top:10px; ">
				<textarea name="content" class="reply_content" id="re_content" ></textarea>
				<button id="rep_bt" class="re_bt">댓글</button>
			</div>
		</form>
		</div>

</div><!--- 댓글 불러오기 끝 -->

<div id="foot_box"></div>
</div>
</body>

</html>
