<!-- By: ©2020 Arsa Satria, https://arsasatria.my.id/ -->
<?php
session_start();
include 'koneksi.php';
include 'csrf.php';
$output='';

$query = "SELECT * FROM chat7m WHERE parent_komentar_id = '0' ORDER BY komentar_id DESC";
$dewan1 = $db1->prepare($query);
$dewan1->execute();
$res1 = $dewan1->get_result();
while ($row = $res1->fetch_assoc()) {
  $output .= '
    <div class="media border p-3 mb-2">
      <img src="https://res.cloudinary.com/arsasatria/image/upload/v1597722460/user_kzfmuk.png" alt="foto-user" class="mr-3 mt-3 rounded-circle" style="width:60px;">
      <div class="media-body">
      <div class="row">
        <div class="col-sm-10">
          <h4><b>'.$row["nama_pengirim"] .'</b> <small> Posted on <i>'.$row["date"].'</i></small></h4>
          <p>'.$row["komentar"].'</p>
        </div>
        <div class="col-sm-2" align="right">
          <button type="button" class="btn btn-primary reply" id="'.$row["komentar_id"].'">Reply</button>
        </div>
      </div>
      </div>
    </div>
  ';
  $output .= ambil_reply($db1, $row["komentar_id"]);
}

echo json_encode([$output]);


function ambil_reply($db1, $parent_id = 0, $marginleft = 0){
  $output='';
  $query = "SELECT * FROM chat7m WHERE parent_komentar_id=?";
  $dewan1 = $db1->prepare($query);
  $dewan1->bind_param("s", $parent_id);
  $dewan1->execute();
  $res1 = $dewan1->get_result();

  $count = $res1->num_rows;
  if($parent_id == 0) {
    $marginleft = 0;
  } else {
    $marginleft = $marginleft + 48;
  }

  $tingkat = $marginleft/48+1;
  
  if($count > 0){
    while ($row = $res1->fetch_assoc()) {
      $output .= '
        <div class="media border p-3 mb-2" style="margin-left:'.$marginleft.'px">
          <img src="https://res.cloudinary.com/arsasatria/image/upload/v1597722460/user_kzfmuk.png" alt="foto-user" class="mr-3 mt-3 rounded-circle" style="width:60px;">
          <div class="media-body">
          <div class="row">
            <div class="col-sm-10">
              <h4><b>'.$row["nama_pengirim"] .'</b> <small> Posted on <i>'.$row["date"].'</i></small></h4>
              <p>'.$row["komentar"].'</p>
            </div>';

        if($tingkat < 4){
          $output .= '
              <div class="col-sm-2" align="right">
                <button type="button" class="btn btn-primary reply" id="'.$row["komentar_id"].'">Reply</button>
              </div>';
        }

        $output .= '    
          </div>
          </div>
        </div>
      ';
      $output .= ambil_reply($db1, $row["komentar_id"], $marginleft);
    }
  }

  return $output;
}
?>