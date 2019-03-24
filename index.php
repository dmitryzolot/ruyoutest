<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>Тестовое задание</title>
		<link href="css/normalize.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="main_content">
			<form class="testform" action="index.php" method="post" enctype="multipart/form-data">
				<p>
					<input type="text" name="user_name" placeholder="ФИО">
				</p>
				<p>
					<input type="text" name="message" placeholder="Cообщение">
				</p>
				<p>
					<input type="file" name="picture" placeholder="Загрузите файл: изображение">
				</p>
				<select name="options"> 
					<option value="По сайту">По сайту</option>     
					<option value="По вакансии">По вакансии</option>    
					<option value="Отчеты">Отчеты</option>      
					<option value="Прочее">Прочее</option>
				</select> 
				<br>
				<button type="submit" class="button" name="send">Отправить</button>
			</form>
			
			<?php
				date_default_timezone_set("Europe/Helsinki");
				
				function getConnection()
					{
						return mysqli_connect ("localhost", "root", "", "ruyoutest");
					}
				
				if (isset($_POST['send']))
				{
					
					$con = getConnection();
					
					$user_name = $_POST['user_name'];
					$message = $_POST['message'];
					$picture = $_POST['picture'];
					$options = $_POST['options'];
					$filename = uniqid() . '.png';
					$picture['path'] = $filename;
					$safe_username = mysqli_real_escape_string($con, $_POST['user_name']);
					$safe_message = mysqli_real_escape_string($con, $_POST['message']);
					
					$query = "INSERT INTO note (name, message, description, picture) 
								VALUES ('$safe_username','$safe_message','$options', '$filename')";
								
					
					move_uploaded_file($_FILES['picture']['tmp_name'], 'uploads/' . $filename);			
					
					mysqli_query ($con, $query);
					
				}
				
				function get_notes() {
					$con = getConnection();
					$sql = "SELECT * FROM note";
					$result = mysqli_query ($con, $sql);
					$notes = mysqli_fetch_all($result, MYSQLI_ASSOC);
					return $notes;
				}
			
				$notes = get_notes();
				
				
			?>
			
			<table bordercolor="black" border=1px class="table__info">
				  <tr class="table__note">
					<td class="table__username">ФИО</td>
					<td class="table__message">Сообщение</td>
					<td class="table__time">Время заявки</td>
					<td class="table__option">Опция</td>
					<td class="table__picture">Изображение</td>
					<td class="table__empty" width=20px></td>
				  </tr>
				  <?php foreach ($notes as $note): ?>
				  <tr class="table__note">
					<td class="table__username"><?=htmlspecialchars($note['name']); ?></td>
					<td class="table__message"><?=htmlspecialchars($note['message']); ?></td>
					<td class="table__time"><?=$note['created_at']; ?></td>
					<td class="table__option"><?=$note['description']; ?></td>
					<td class="table__picture"><img src="uploads/<?=$note['picture']; ?>" height="50" width="50"></td>
					<td class="table__empty"></td>
				  </tr>
				  <?php endforeach; ?>
			</table>
		</div>
	</body>
</html>