<?php
	session_start();
	session_regenerate_id(true);
	if (isset($_SESSION['login'])==false) {
		print 'ログインされていません。<br/>';
		print '<a href="../bbs_login/bbs_login.php">ログイン画面へ</a><br/>';
		exit();
	} else {
		print 'ユーザー名:';
		print $_SESSION['name'];
		print '<br/>';
		print '<a href="../bbs_login/bbs_logout.php">ログアウト</a><br/>';
		print '<br/>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>BBS開発勉強用</title>
		<link rel="stylesheet" href="bbs.css">
	</head>
	<body>
		<h3>投稿内容確認</h3>
		<?php
			if (empty($_POST) == true) {
				print '入力が不正です。<br/>';
				print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
			} else {
				$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
				$email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
				$comment = htmlspecialchars($_POST['comment'],ENT_QUOTES,'UTF-8');
				$gazou = $_FILES['gazou'];

				if ($comment == ''){
					print 'コメントを入力してください。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} elseif ($gazou['size'] > 1000000) {
					print '画像が大きすぎます。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} else {
					if ($name == '') {
						$name = '名無しさん';
					}
					print '名前：'.$name.'</br>';
					if ($email == '') {
						print 'email:未入力<br/>';
					} else {
						print 'email：'.$email.'</br>';
					}
					print 'コメント<br/>';
					print nl2br($comment).'</br>';
					print '<br/>';

					if ($gazou['size'] > 0) {
						print '添付ファイル<br/>';
						// ランダム文字列を作成して画像ファイルの一時的なファイル名にする
						$gazou_ramdom_name = substr(bin2hex(random_bytes(8)), 0, 8);
						// 画像ファイルの拡張子を取得して一時的なファイル名の末尾に加える
						$gazou_ramdom_name .= substr($gazou['name'], strrpos($gazou['name'], '.'));
						move_uploaded_file($gazou['tmp_name'],'./gazou/'.$gazou_ramdom_name);
						print '<img src="./gazou/'.$gazou_ramdom_name.'"><br/>';
					}

					print '<form method="post" action="comment_post_done.php">';
						print '<input type="hidden" name="name" value="'.$name.'">';
						print '<input type="hidden" name="email" value="'.$email.'">';
						print '<input type="hidden" name="comment" value="'.$comment.'">';
						print '<input type="hidden" name="gazou_name" value="'.$gazou_ramdom_name.'">';
						print '<p><input class="button" type="submit" value="投稿"></p>';
						print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
					print '</form>';
				}
			}
		?>

	</body>
</html>
