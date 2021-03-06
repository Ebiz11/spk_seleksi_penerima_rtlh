<?php
include ("cek_level.php");
require ("library.php");
$profile_matching= new profile_matching();
unset($_SESSION['berhasil']);

if(isset($_POST['button'])){

  $i=0;
  $del= $profile_matching->del_standar_profile();
  $kriteria = $profile_matching->show_kriteria();

  while ($datakriteria= $kriteria->fetch(PDO::FETCH_ASSOC)) {
    $i++;
    $cek_nilai=$profile_matching->detail_sub_kriteria(@$_POST[$datakriteria['id_kriteria']]);
    $data_nilai=$cek_nilai->fetch(PDO::FETCH_ASSOC);
    $update= $profile_matching->add_standar_profile($i, $datakriteria['id_kriteria'], @$_POST[$datakriteria['id_kriteria']]);
  }
  $_SESSION['berhasil']='<b>BERHASIL MENYIMPAN:</b> Data Standar Profile Berhasil Disimpan.';
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2>Standar Profile</h2>
      <ol class="breadcrumb">
          <li>
              <a href="index?page=home">Home</a>
          </li>
          <li class="active">
              <strong>Standar Profile</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <!-- <h5>Standar Profile</h5> -->
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                  <!-- notifikasi -->
                <?php include ("notifikasi.php") ?>
                  <!--  -->
                <form method="post" class="form-horizontal" action="">
                <?php
                $kriteria = $profile_matching->show_kriteria();
                while ($datakriteria = $kriteria->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="form-group"><label class="col-sm-2 control-label"><?php echo $datakriteria['nama_kriteria'] ?><br/></label>
                <div class="col-sm-10">
                <?php
                $sub_kriteria = $profile_matching->relasi_sub_kriteria($datakriteria['id_kriteria']);
                while ($datasubkriteria= $sub_kriteria->fetch(PDO::FETCH_ASSOC)) {
                $checked = "";
                $standar_profile = $profile_matching->standar_profile($datakriteria['id_kriteria'], $datasubkriteria['id_sub_kriteria']);
                if ($datastandarprofile=$standar_profile->fetch(PDO::FETCH_ASSOC)) {
                $checked = " checked";
                }
                ?>
                <div class="radio i-checks"><label> <input type="radio" disabled="" value="<?php echo $datasubkriteria['id_sub_kriteria'] ?>" name="<?php echo $datakriteria['id_kriteria'] ?>" <?php echo $checked; ?> required> <i></i><?php echo $datasubkriteria['nama_sub_kriteria'] ?></label></div>
                <?php } ?>
                </div>
                </div>
                <div class="hr-line-dashed"></div>
                <?php } ?>
                <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                <a type="button" class="btn btn-primary" type="submit" name="button" data-toggle="modal" data-target="#myModal5">Edit Standar Profile</a>
                </div>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal edit -->
<div class="modal inmodal fade" data-backdrop="static" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Standar Profile</h4>
      <small class="font-bold">Standar Profile adalah kumpulan kriteria yang harus dipenuhi oleh calon penerima.</small>
      </div>
        <div class="modal-body">
          <form method="post" class="form-horizontal" action="">
          <?php
          $kriteria = $profile_matching->show_kriteria();
          while ($datakriteria = $kriteria->fetch(PDO::FETCH_ASSOC)) { ?>
          <div class="form-group"><label class="col-sm-2 control-label"><?php echo $datakriteria['nama_kriteria'] ?><br/></label>
          <div class="col-sm-10">
          <?php
          $sub_kriteria = $profile_matching->relasi_sub_kriteria($datakriteria['id_kriteria']);
          while ($datasubkriteria= $sub_kriteria->fetch(PDO::FETCH_ASSOC)) {
          $checked = "";
          $standar_profile = $profile_matching->standar_profile($datakriteria['id_kriteria'], $datasubkriteria['id_sub_kriteria']);
          if ($datastandarprofile=$standar_profile->fetch(PDO::FETCH_ASSOC)) {
          $checked = " checked";
          }
          ?>
          <div class="radio i-checks"><label> <input type="radio" value="<?php echo $datasubkriteria['id_sub_kriteria'] ?>" name="<?php echo $datakriteria['id_kriteria'] ?>" <?php echo $checked; ?>> <i></i><?php echo $datasubkriteria['nama_sub_kriteria'] ?></label></div>
          <?php } ?>
          </div>
          </div>
          <div class="hr-line-dashed"></div>
          <?php } ?>
          <div class="modal-footer">
          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
          <button class="btn btn-primary" type="submit" name="button">Simpan</button>
          </div>
          </form>
      </div>
    </div>
  </div>
</div>
