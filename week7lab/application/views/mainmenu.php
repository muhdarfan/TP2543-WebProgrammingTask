<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title; ?></title>
</head>
<body>
  <?php date_default_timezone_set("Asia/Kuala_Lumpur"); ?>
  <div align="center">
    <table width="379" height="286" border="3" bordercolor="#666666">
      <tr>
        <td height="190" bgcolor="#999999">
          <p align="center"><strong>My Guestbook</strong></p>
          <p align="center">Date : <?php echo date("d-m-Y",time()); ?></p>
          <p align="center">Time : <?php echo date("h:i",time()); ?></p>
          <p align="center"><a href="<?php echo base_url('myguestbook/create/'); ?>">Add</a> | <a href="<?php echo base_url('myguestbook/view/'); ?>">List</a></p>
        </td>
      </tr>
    </table>
  </div>
  
</body>
</html>