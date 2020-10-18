<!-- By: ©2020 Arsa Satria, https://arsasatria.my.id/ -->

<?php
//Mengirimkan Token Keamanan Ajax Request (Csrf Token)
session_start();
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<html>
    <head>
<style>
#more {
    display: none;
}
</style>
       <!-- Csrf Token -->
<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-dark bg-danger fixed-top">
  <a class="navbar-brand" href="index.php" style="color: #fff;">
    7 Madinah
  </a>
</nav>

<div class="container mb-3">
	<h2 align="center" style="margin: 60px 10px 10px 10px;">Forum & Komentar</h2><hr>
	<form method="POST" id="form_komen">
		<div class="form-group">
			<input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" placeholder="Masukkan Nama" required />
		</div>
		<div class="form-group">
			<textarea name="komen" id="komen" class="form-control" placeholder="Tulis Komentar" rows="5"></textarea>
		</div>
		<div class="form-group">
			<input type="hidden" name="komentar_id" id="komentar_id" value="0" />
			<input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
		</div>
	</form>
	<div class="media border p-3 mb-2">
      <img src="https://res.cloudinary.com/arsasatria/image/upload/v1597308431/loader.gif.gif" alt="foto-user" class="mr-3 mt-3 rounded-circle" style="width:60px;">
      <div class="media-body">
      <div class="row">
        <div class="col-sm-10">
          <h4><b>admin@chat.arsasatria.my.id</b> <small> PENTING <i>PERATURAN CHAT</i></small></h4>
          <p>PERATURAN  MENGGUNAKAN  CHAT:</p>
          <p></p>
          
          <p id="more">1. Segala Script/Kode dan Asset termasuk gambar adalah Hak Cipta chat.arsasatria.my.id</p>
          <p id="more">2. Segala Link / Konten Tidak pantas akan dilaporkan dan diblokir total aksesnya ke server 7 Madinah.</p>
          <p id="more">3. Nama harus menggunakan NAMA ASLI dan tidak mengatasnamakan orang lain.</p>
          <p id="more">4. Segala Tindakan Peretasan/Perusakan yang dilakukan akan dilaporkan Ke Pihak Berwenang.</p>
          <p id="more">5. Konten yang tidak sesuai dengan S&K kami atau Tidak Menggunakan Nama Pengirim akan dihapus secara berkala.</p>
          <p id="more">6. Pelaku tindakan SPAM akan dihapus aksesnya ke akun ini.</p>
          <p id="more">7. Syarat dan Ketentuan di atas dapat berubah sewaktu-waktu</p>
          <p id="more">PELAKU PELANGGARAN PERATURAN DI ATAS AKAN DIHAPUS TOTAL AKSESNYA KE SERVER KAMI DAN AKAN DILAPORKAN KE PIHAK BERWAJIB & KEAMANAN JARINGAN NASIONAL SETEMPAT</p>
          <p id="more"></p>
          <p id="more">Selamat Mengobrol!</p>
          <p id="more">- Admin chat.arsasatria.my.id - </p>
          
          <button onclick="Read();" id="Readbtn">Read more</button>


        </div>
        <div class="col-sm-2" align="right">
          <button type="button" class="btn btn-primary reply">OK</button>
        </div>
      </div>
      </div>
    </div>
	<hr>
	<h4 class="mb-3">Komentar :</h4>
	<span id="message"></span>
   
   	<div id="display_comment"></div>
</div>

<div class="navbar bg-dark">
	<div style="color: #fff;">© <?php echo date('Y'); ?> Copyright:
	    <a href="https://arsasatria.my.id/">chat.arsasatria.my.id</a>
	    <a href="#report" onclick="report();" style="color:white"> - Laporkan Pesan!</a>
	</div>
</div>
<script>
	$(document).ready(function(){
		//Mengirimkan Token Keamanan
		$.ajaxSetup({
                  headers : {
                    'Csrf-Token': $('meta[name="csrf-token"]').attr('content')
                  }
                });
    
		$('#form_komen').on('submit', function(event){
			event.preventDefault();
			var form_data = $(this).serialize();
			$.ajax({
				url:"tambah_komentar.php",
				method:"POST",
				data:form_data,
				success:function(data){
					$('#form_komen')[0].reset();
					$('#komentar_id').val('0');
					load_comment();
				}, error: function(data) {
	            	console.log(data.responseText)
	            }
			})
		});
 
		load_comment();
 
		function load_comment(){
			$.ajax({
				url:"ambil_komentar.php",
				method:"POST",
				success:function(data){
					$('#display_comment').html(data);
				}, error: function(data) {
	            	console.log(data.responseText)
	            }
			})
		}
 
		$(document).on('click', '.reply', function(){
			var komentar_id = $(this).attr("id");
			$('#komentar_id').val(komentar_id);
			$('#nama_pengirim').focus();
		});
	});
</script>
<script>
function Read() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("Readbtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>
    </body>
</html>