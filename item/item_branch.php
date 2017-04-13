<?php
##addへの分岐
if(isset($_POST['add'])==true){
  header('Location:item_add.php');
  exit();
}
elseif(isset($_POST['img_add'])==true){
  header('Location:img_add.php');
  exit();
}

##dispへの分岐

##
##NG画面遷移とstaffcodeの取得
if(isset($_POST['item_id'])==false){
  header('Location:item_ng.php');
  exit();
}
else{
  $item_id=$_POST['item_id'];
}

##分岐
if(isset($_POST['edit'])==true){
  header('Location:item_edit.php?item_id='.$item_id);
  exit();
}
elseif(isset($_POST['delete'])==true){
  header('Location:item_delete.php?item_id='.$item_id);
  exit();
}
elseif(isset($_POST['disp'])==true){
  header('Location:item_disp.php?item_id='.$item_id);
  exit();
}


?>
