<?php
// セッション開始
session_start();
?>

<!-- タスク新規作成用フォーム -->
<form action="" method="POST">
  <input type="text" name="title" id="">
  <input type="submit" name="type" value="create">
</form>

<?php
// POSTでtypeが渡ってきていれば、何かアクションがあったということなので、
// create update delete いずれか判別してそれぞれの処理を行う
if (isset($_POST['type'])) {
  // CREATEだった場合
  if ($_POST['type'] === 'create') {
    // セッションのtodosにタイトルを格納
    $_SESSION['todos'][] = $_POST['title'];
    echo "新しいタスク「{$_POST['title']}」が入力されました";
    // UPDATEだった場合
  } else if ($_POST['type'] === 'update') {
    // セッションtodosの指定idタスクのtitleを変更
    $_SESSION['todos'][$_POST['id']] = $_POST['title'];
    echo "タスク「{$_POST['title']}」の名前が変更されました";
  } else if ($_POST['type'] === 'delete') {
    // array_splice で セッションtodosの指定idタスクを削除
    array_splice($_SESSION['todos'], $_POST['id'], 1);
    echo "タスク「{$_POST['title']}」が削除されました";
  } else {
    echo 'error';
  }
}

// セッションのtodosに何も入っていなければ、入力待ち状態
if (empty($_SESSION['todos'])) {
  $_SESSION['todos'] = [];
  echo 'タスクを入力しましょう';
  // これより下の処理は必要なくなるのでexitで止めてしまう。
  exit();
}
?>

<!-- 
タスク一覧
-->
<ul>
  <?php for ($i = 0; $i < count($_SESSION['todos']); $i++) : ?>
    <li>
      <form action="" method="POST">
        <!-- hiddenでタスクのidを渡す -->
        <input type="hidden" name="id" value="<?= $i ?>">
        <!-- タスク名を入力ボックスにセットして表示 -->
        <input type="text" name="title" value="<?= $_SESSION['todos'][$i]; ?>">
        <br>
        <!-- updateとdeleteのsubmitを用意 nameでtypeを持たせている -->
        <input type="submit" name="type" value="update">
        <input type="submit" name="type" value="delete">
      </form>
    </li>
  <?php endfor; ?>
</ul>