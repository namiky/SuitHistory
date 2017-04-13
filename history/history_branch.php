<?php
##addへの分岐
if(isset($_POST['add'])==true){
  header('Location:history_add.php');
  exit();
}
elseif(isset($_POST['img_add'])==true){
  header('Location:img_add.php');
  exit();
}

##dispへの分岐

##
##NG画面遷移とstaffcodeの取得
if(isset($_POST['history_id'])==false){
  header('Location:history_ng.php');
  exit();
}
else{
  $history_id=$_POST['history_id'];
}

##分岐
if(isset($_POST['edit'])==true){
  header('Location:history_edit.php?history_id='.$history_id);
  exit();
}
elseif(isset($_POST['delete'])==true){
  header('Location:history_delete.php?history_id='.$history_id);
  exit();
}
elseif(isset($_POST['disp'])==true){
  header('Location:history_disp.php?history_id='.$history_id);
  exit();
}


?>
