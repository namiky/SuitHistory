<?php
##addへの分岐
if(isset($_POST['add'])==true){
  header('Location:img_add.php');
  exit();
}

##NG画面遷移
if(isset($_POST['img_id'])==false){
  header('Location:img_ng.php');
  exit();
}
else{
  $img_id=$_POST['img_id'];
}

##分岐
if(isset($_POST['edit'])==true){
  header('Location:img_edit.php?img_id='.$img_id);
  exit();
}
elseif(isset($_POST['delete'])==true){
  header('Location:img_delete.php?img_id='.$img_id);
  exit();
}
elseif(isset($_POST['disp'])==true){
  header('Location:img_disp.php?img_id='.$img_id);
  exit();
}


?>
