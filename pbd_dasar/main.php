<!DOCTYPE html>
<html>

    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>CRUD</title>
        <nav class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <b  class="navbar-brand nav-link active text-center " href="#">CREAT READ UPDATE DELETE</b>       
            </div>
         </nav>
    </head>

    
<body>
    <?php
    require("../sistem/koneksi.php");

    $hub = open_connection();
    $a = @$_GET["a"];
    $id = @$_GET["id"];
    $sql = @$_POST["sql"];
    switch ($sql) {
        case "create":
            create_prodi();
            break;
        case "update":
            update_prodi();
            break;
        case "delete":
            delete_prodi();
            break;
    }
    switch ($a) {
        case "list":
            read_data();
            break;
        case "input":
            input_data();
            break;
        case "edit":
            edit_data($id);
            break;
        case "hapus";
            hapus_data($id);
            break;
        default;
            read_data();
            break;
    }
    mysqli_close($hub);
    ?>

    <?php
    function read_data() {
        global $hub;
        $query = "select * from dt_prodi";
        $result = mysqli_query($hub, $query); ?>

    <div class="container p-5">
        <a href="main.php?a=input"class="btn btn-secondary mb-1">INPUT</a>
        <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Read Data Program Studi</h4>            
                
                </div>
            <div class="card-body"> 
                <div class="table-responsive auto">
                    <table class="table table-bordered table-striped ">
                    <table class="table table-dark table-striped">
                    <div style="overflow-x:auto;">
                    <table id="table_id" class="table table-striped table-dark mydatatable" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">KODE PRODI</th>
                            <th scope="col">NAMA PRODI</th>
                            <th scope="col">AKREDITASI</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>        
        
                    <tbody>
                        <?php $no=1; ?>
                        <?php while($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?=$no++; ?></td>
                            <td><?php echo $row['kdprodi']; ?></td>
                            <td><?php echo $row['nmprodi']; ?></td>
                            <td><?php echo $row['akreditasi']; ?></td>
                            <td class="btn-class">
                                <a href="main.php?a=edit&id=<?php echo $row['idprodi']; ?>" 
                                    onclick="javascript:return confirm('Apakah ingin mengedit data ini ?')"
                                    class="btn btn-primary">
                                    Edit
                                </a>
                            
                                <a value="Hapus" href="main.php?a=hapus&id=<?php echo $row['idprodi'];?>" 
                                    onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')"
                                    class="btn btn-danger">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </table>
                
                </br>
                    <footer class="bg-dark text-center text-white">               
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Fadil Ainuddin || 20753047</a>
                        </div>
                    </footer>
            </div>
                
    <?php } ?>

    <?php
    function input_data() {
        $row = array(
            "kdprodi" => "",
            "nmprodi" => "",
            "akreditasi" => "-"

        );  
        
    ?>

        <div class="container p-5">
            <a href="main.php?a=list"class="btn btn-secondary mb-1">Kembali</a>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Input Data Program Studi</h4>
                </div>

                <div class="card-body">
                    <form  name="latihan"  method="POST" action="main.php?a=list" onsubmit="return validate()">
                        <input type="hidden" name="sql" value="create">
                        <div class="form-group justify-center">
                            <label for=""><b>Kode Prodi</b></label>
                            <input type="text" name="kdprodi" class="form-control" maxlength="6" size="6" placeholder="Masukkan Kode Prodi" value="<?php echo trim($row['kdprodi']) ?>">
                        </div>
                                                
                        <div class="form-group justify-center">
                            <label for=""><b>Nama Prodi</b></label>
                            <input type="text" name="nmprodi" class="form-control" maxlength="70" size="70" placeholder="Masukkan Nama Prodi" value="<?php echo trim($row['nmprodi']) ?>" />
                        </div>

                        <div class="form-group justify-center">
                            <label for=""><b>Akreditasi</b></label>
                            <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"]=='-' || $row["akreditasi"]=='') { echo 
                            "checked=\"checked\"";} else {echo ""; } ?>> -
                            <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"]=='A') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> A
                            <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"]=='B') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> B
                            <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"]=='C') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> C
                        </div>
                        </div>
                        
                        <button class="btn btn-success" type="submit" name="action" value="Simpan">Tambah Data</button>
                    </form>
                    </br>
                    
                    <footer class="bg-dark text-center text-white">
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Fadil Ainuddin || 20753047</a>
                        </div>
                    </footer>
                    
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    function edit_data($id) {
        global $hub;
        $query = "select * from dt_prodi where idprodi = $id";
        $result = mysqli_query($hub, $query);
        $row = mysqli_fetch_array($result); ?>

    <div class="container p-5">
            <a href="main.php?a=list"class="btn btn-secondary mb-1">Batal</a>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Edit Data Program Studi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="main.php?a=list">
                        <input type="hidden" name="sql" value="update">
                        <input type="hidden" name="idprodi" value="<?php echo trim ($id)?>">
                        <div class="form-group justify-center">
                            <label for=""><b>Kode Prodi</b></label>
                            <input type="text" name="kdprodi" class="form-control"  value="<?php echo trim($row['kdprodi']) ?>">
                        </div>
                                                
                        <div class="form-group justify-center">
                            <label for=""><b>Nama Prodi</b></label>
                            <input type="text" name="nmprodi" class="form-control" value="<?php echo trim($row['nmprodi']) ?>" />
                        </div>

                        <div class="form-group justify-center">
                            <label for=""><b>Akreditasi</b></label>
                            <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"]=='-' || $row["akreditasi"]=='') { echo 
                            "checked=\"checked\"";} else {echo ""; } ?>> -
                            <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"]=='A') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> A
                            <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"]=='B') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> B
                            <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"]=='C') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> C
                        </div>
                        </div>
                    
                        <button class="btn btn-success" type="submit" name="action" value="Simpan">Simpan Perubahan</button>
                    </form>
                    </br>
                    <footer class="bg-dark text-center text-white">
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Fadil Ainuddin || 20753047</a>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    function hapus_data($id) {
        global $hub;
        $query = " select * from dt_prodi where idprodi = $id";
        $result = mysqli_query($hub, $query);
        $row = mysqli_fetch_array($result); ?>

    <div class="container p-5">
            <a href="main.php?a=list"class="btn btn-secondary mb-1">Batal</a>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Hapus Data Program Studi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="main.php?a=list">
                        <input type="hidden" name="sql" value="delete">
                        <input type="hidden" name="idprodi" value="<?php echo trim ($id)?>">
                        <div class="table-responsive auto">
                        <table class="table table-bordered table-striped ">
                        <div style="overflow-x:auto;">
                            <table id="table_id" class="table table-striped table-dark mydatatable" width="100%">
                                <tr>
                                    <td>KODE PRODI</td>
                                    <td><?php echo trim($row["kdprodi"]) ?></td>
                                </tr>
                                <tr>
                                    <td>NAMA PRODI</td>
                                    <td><fm-1><?php echo trim($row["nmprodi"]) ?></fm-1></td>
                                </tr>
                                <tr>
                                    <td>AKREDITASI</td>
                                    <td><?php echo trim($row["akreditasi"]) ?></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    
                        <button class="btn btn-danger" type="submit" name="action" value="Hapus"  
                                onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">Hapus Data</button>
                    </form>
                    </br>
                    <footer class="bg-dark text-center text-white">
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Fadil Ainuddin || 20753047</a>
                        </div>
                    </footer>

    </main>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
        function create_prodi() {
            global $hub;
            global $_POST;
            $kdprodi = $_POST['kdprodi'];
            $nmprodi = $_POST['nmprodi'];

            $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) 
            VALUES";
             $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) VALUES ";
             $query .= " ('". $_POST["kdprodi"]."', '".$_POST["nmprodi"]."', '".$_POST["akreditasi"]."')";
             $row = mysqli_query($hub, "SELECT * FROM dt_prodi WHERE nmprodi = '$nmprodi' OR kdprodi = '$kdprodi'");
             if (mysqli_num_rows($row) > 0) {
                 echo "<script>alert('kode prodi atau nama prodi sudah ada di database');</script>";
             } else {
                 mysqli_query($hub, $query) or die(mysqli_error($hub));
             }

        }

        function update_prodi() {
            global $hub;
            global $_POST;
            $query = "UPDATE dt_prodi";
            $query .= " SET kdprodi='" .$_POST["kdprodi"]."', nmprodi= '".$_POST["nmprodi"]."', akreditasi= '".$_POST["akreditasi"]."'";
            $query .= " WHERE idprodi = ".$_POST["idprodi"];

            $kdprodi = $_POST['kdprodi'];
            $nmprodi = $_POST['nmprodi'];
            $akreditasi = $_POST['akreditasi'];
            $id = $_POST['idprodi'];

            $cekNamaProdi = mysqli_query($hub, "SELECT * FROM dt_prodi WHERE nmprodi = '$nmprodi' AND idprodi = '$id'");
            $cekNamaProdiLain = mysqli_query($hub, "SELECT * FROM dt_prodi WHERE nmprodi = '$nmprodi'");
            $cekKodeProdi = mysqli_query($hub, "SELECT * FROM dt_prodi WHERE kdprodi = '$kdprodi' AND idprodi = '$id'");
            $cekKodeProdiLain = mysqli_query($hub, "SELECT * FROM dt_prodi WHERE kdprodi = '$kdprodi'");

            if (mysqli_num_rows($cekNamaProdi) == 1 && mysqli_num_rows($cekKodeProdi) == 1) {
                mysqli_query($hub, "UPDATE dt_prodi SET akreditasi='$akreditasi' WHERE idprodi='$id'");
            } else if (mysqli_num_rows($cekKodeProdi) == 1 && mysqli_num_rows($cekNamaProdiLain) == 0) {
                echo "<script>alert('nama prodi diperbarui');</script>";
                mysqli_query($hub, "UPDATE dt_prodi SET nmprodi='$nmprodi', akreditasi='$akreditasi' WHERE idprodi='$id'");
            } else if (mysqli_num_rows($cekNamaProdi) == 1 && mysqli_num_rows($cekKodeProdiLain) == 0) {
                echo "<script>alert('kode prodi diperbarui');</script>";
                mysqli_query($hub, "UPDATE dt_prodi SET kdprodi='$kdprodi', akreditasi='$akreditasi' WHERE idprodi='$id'");
            } else if (mysqli_num_rows($cekKodeProdiLain) > 0 && mysqli_num_rows($cekNamaProdi) == 1) {
                echo "<script>alert('kode prodi sudah ada');</script>";
            } else if (mysqli_num_rows($cekNamaProdiLain) > 0 && mysqli_num_rows($cekKodeProdi) == 1) {
                echo "<script>alert('nama prodi sudah ada');</script>";
            } else {
                echo "<script>alert('semua data berhasil diperbarui');</script>";
                mysqli_query($hub, $query) or die (mysqli_error($hub));
            }
            
        }
        
        function delete_prodi() {
            global $hub;
            global $_POST;
            $query = " DELETE FROM dt_prodi";
            $query .= " WHERE idprodi = ".$_POST["idprodi"];
            mysqli_query($hub, $query) or die (mysqli_error($hub));
        }

    ?>



</body>
<script type="text/javascript">
    function validate() {
        if (document.forms["latihan"]["kdprodi"].value == "") {
            alert("Kode Prodi Tidak Boleh Kosong");
            document.forms["latihan"]["kdprodi"].focus();
            return false;
        }
        if (document.forms["latihan"]["nmprodi"].value == "") {
            alert("Nama Prodi Tidak Boleh Kosong");
            document.forms["latihan"]["nmprodi"].focus();
            return false;
        }
        if (document.forms["latihan"]["akreditasi"].selectedIndex < 1) {
            alert("Pilih akreditasi");
            document.forms["latihan"]["akreditasi"].focus();
            return false;
        }
    }
</script>




<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



</html>