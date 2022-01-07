<?php 
  define("CHAT", "chat.txt");

  date_default_timezone_set('Asia/Tokyo');

  $bads = json_decode(file_get_contents(BAD));


  $errors = '';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = $_POST['name']."<br>".$_POST['text'].",".date('Y年 m月d日 H時i分s秒')."\n";


    if (mb_strlen($_POST['name']) > 10 || mb_strlen($_POST['text']) > 40) {
      $errors = '名前を10文字以内、<br>メッセージを40文字以内でお願い致します。';
    } else {
      file_put_contents(CHAT, $text, FILE_APPEND);
    } 
    
    
  }



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>ワン・メッセージ</title>
</head>
<body>

  <header>
    <h1>ワン・メッセージ</h1>
  </header>

  <form action="index.php" method="post">
    <p class="error" ><?php echo $errors; ?></p>
    <label>NAME</label><br>
    <input type="text" name="name" class="name" style="width: 300px; height: 25px;"><br>
    <label>MESSAGE</label><br>
    <textarea rows="3" name="text" id="content" style="width: 350px;" ></textarea><br>
    <button class="btn" type="submit">SENT</button>
  </form>

  <div class="wrap">
    <ul>
    </ul>
  </div>

  <footer>
    <p class="para">simple message</p>
  </footer>

  <script src="jquery.js"></script>
  <script>
    $(function () {
      $.ajax({
        url: 'chat.txt',
      })
      .done(function (data) {
        data.split('\n').forEach(function(chat) {
          const post_text = chat.split(',')[0];
          const post_time = chat.split(',')[1];
          if (post_text) {          
            const li = `<li>By ${post_text}<span>${post_time}</span></li>`;
            $('ul').append(li);
          }
        });
      });
    });

  $('.btn').click(function () {
    if (confirm("投稿しますか?")) {
      return ture;
    } else {
      return false;
    }
  });
  </script>

</body>
</html>