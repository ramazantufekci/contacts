<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once("../vendor/autoload.php");
use DRContacts\db\db;
use DRContacts\form\form;
if($_POST)
{
	$db = new db();
	$user = form::valid($_POST["kullanici"]);
	$pass = form::valid($_POST["sifre"]);
	$result = $db->lKontrol($user,$pass);
	if(isset($result->id))
	{
		$_SESSION["kull"] = $result->adSoyad;
		$_SESSION["id"] = md5($result->id);
	}else
	{
		header("Refresh: 5; url=".$_SERVER["HTTP_HOST"]."/");
		die("<center>Kullanici adi veya sifre yanlis !!!<br />Anasayfa'ya yönlendiriliyorsunuz.</center>");
	}
	
	
	
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Telefon Listesi</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
	<script>
	function getirla(deneme){
		$("#g_gizli").val(deneme);
		$.ajax({
			type:"GET",
			url:"/kayit.php?id="+deneme,
			success:function(x){
				var json = JSON.parse(x);
				$("#g_adi").val(json.ad);
				$("#g_sAdi").val(json.soyad);
				$("#g_telNo").val(json.tel_no);
				$("#g_cKisa").val(json.tel_kisa);
				$("#g_dKisa").val(json.da_kisa);
			}
		});
	}
	</script>
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">DR Yazılım</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="#"></a>
        <a class="p-2 text-dark" href="#"></a>
        <a class="p-2 text-dark" href="#"></a>
        <a class="p-2 text-dark" href="#"></a>
      </nav>
	  <?php
	  if(isset($_SESSION["kull"]))
	  {
		printf(' <span class="navbar-text">%s</span>&nbsp;&nbsp;<a class="btn btn-outline-primary" href="/logout.php">Çıkış Yap</a>',$_SESSION["kull"]);  
		echo '&nbsp;&nbsp;<a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#exampleModal2">Ekle</a>';
	  }else
	  {
		echo '<a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#exampleModal">Giriş Yap</a>';  
	  }
	  ?>
      &nbsp;&nbsp;<a class="btn btn-outline-primary" href="/indir.php" >İndir</a>
    </div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kullanıcı Girişi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Kullanıcı Adı:</label>
            <input type="text" class="form-control" id="recipient-name" name="kullanici">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Şifre:</label>
            <input type="password" class="form-control" id="message-text" name="sifre">
          </div>
      </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-outline-primary text-center">Giriş Yap</button>
      </div>
	</form>
    </div>
  </div>
</div>
<!-- ekle modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kişi Girişi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="adi" class="col-form-label">Adı:</label>
            <input type="text" class="form-control" id="adi" name="ad">
          </div>
          <div class="form-group">
            <label for="sAdi" class="col-form-label">Soyadı:</label>
            <input type="text" class="form-control" id="sAdi" name="soyadi">
          </div>
		  <div class="form-group">
            <label for="telNo" class="col-form-label">Tel No:</label>
            <input type="text" class="form-control" id="telNo" name="telNo">
          </div>
		  <div class="form-group">
            <label for="cKisa" class="col-form-label">Cep den Kısa Kod:</label>
            <input type="text" class="form-control" id="cKisa" name="cKisa">
          </div>
		  <div class="form-group">
            <label for="dKisa" class="col-form-label">Dahili Kısa Kod:</label>
            <input type="text" class="form-control" id="dKisa" name="dKisa">
          </div>
      </div>
      <div class="modal-footer">
	   <label id="durum4" class="col-form-label text-danger"></label>
		<button type="submit" class="btn btn-outline-primary text-center" id="kKaydet">Kaydet</button>
      </div>
    </div>
  </div>
</div>
<!-- ekle modal bitis -->
<!-- Guncelle modal baslangic -->
<div class="modal fade" id="modalGuncel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kişi Güncelleme</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="adi" class="col-form-label">Adı:</label>
            <input type="text" class="form-control" id="g_adi" name="g_ad" required>
			<input type="hidden" class="form-control" id="g_gizli" name="g_gizli">
          </div>
          <div class="form-group">
            <label for="sAdi" class="col-form-label">Soyadı:</label>
            <input type="text" class="form-control" id="g_sAdi" name="g_soyadi" required>
          </div>
		  <div class="form-group">
            <label for="telNo" class="col-form-label">Tel No:</label>
            <input type="text" class="form-control" id="g_telNo" name="g_telNo" required>
          </div>
		  <div class="form-group">
            <label for="cKisa" class="col-form-label">Cep den Kısa Kod:</label>
            <input type="text" class="form-control" id="g_cKisa" name="g_cKisa" required>
          </div>
		  <div class="form-group">
            <label for="dKisa" class="col-form-label">Dahili Kısa Kod:</label>
            <input type="text" class="form-control" id="g_dKisa" name="g_dKisa" required>
          </div>
      </div>
      <div class="modal-footer">
	  <label id="durum5" class="col-form-label text-danger"></label>
		<button type="submit" class="btn btn-outline-primary text-center" id="g_guncelle">Güncelle</button>
      </div>
    </div>
  </div>
</div>
<!-- guncelle modal bitis -->
<div class="container">
	<table class="table">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">AD</th>
		  <th scope="col">SOYADI</th>
		  <th scope="col">GSM TEL</th>
		  <th scope="col">CEP DEN KISA KOD</th>
		  <th scope="col">DAHILI KISA KOD</th>
		  <?php echo isset($_SESSION["id"])==true ?'<th scope="col"></th>':"";?>
		</tr>
	  </thead>
	  <tbody>
	  <?php
	  $dv = new db();
	  $noBilgi = $dv->noGetir();
	  while($obj = $noBilgi->fetch_object())
	  {
		 printf('<tr>
		  <th scope="row"></th>
		  <td>%s</td>
		  <td>%s</td>
		  <td><a href="tel:%s">%s</a></td>
		  <td><a href="tel:%s">%s</a></td>
		  <td><a href="tel:%s">%s</a></td>
		',$obj->ad,$obj->soyad,$obj->tel_no,$obj->tel_no,$obj->tel_kisa,$obj->tel_kisa,$obj->da_kisa,$obj->da_kisa); 
			if(isset($_SESSION["id"]))
			{
				echo '<td><a id="c_guncelle" class="btn btn-outline-primary" onclick="getirla('.$obj->id.')" data-toggle="modal" data-target="#modalGuncel">Güncelle</a></td></tr>';
			}else
			{
				echo "</tr>";
			}		
	  }
	  
		 
	  
	  ?>
	  </tbody>
	</table>
</div>
<footer class="page-footer font-small blue pt-4 mt-4">
  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2018 Copyright:
    <a href="https://www.ramazantufekci.com/"> Ramazan TÜFEKÇİ</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
	<script>
	$(function(){
		$("#kKaydet").click(function(){
			var adi,sAdi,telNo,cKisa,dKisa;
			adi = $("#adi").val();
			sAdi = $("#sAdi").val();
			telNo = $("#telNo").val();
			cKisa = $("#cKisa").val();
			dKisa = $("#dKisa").val();
			$.ajax({
				type:"POST",
				url :"/kayit.php",
				data :"session=<?php echo (isset($_SESSION["id"])?$_SESSION["id"]:md5("kastamonu"));?>&adi="+adi+"&sAdi="+sAdi+"&telNo="+telNo+"&cKisa="+cKisa+"&dKisa="+dKisa,
				success : function(x)
				{
					if(x=="true")
					{
						adi = $("#adi").val("");
						sAdi = $("#sAdi").val("");
						telNo = $("#telNo").val("");
						cKisa = $("#cKisa").val("");
						dKisa = $("#dKisa").val("");
						
					}else
					{
						$("#durum4").text("Kayıt başarısız oldu !!!");
					}
					
				}
			});
		});
		$("#g_guncelle").click(function(){
			var g_adi,g_sAdi,g_telNo,g_cKisa,g_dKisa,g_gizli;
			g_adi = $("#g_adi").val();
			g_sAdi = $("#g_sAdi").val();
			g_telNo = $("#g_telNo").val();
			g_cKisa = $("#g_cKisa").val();
			g_dKisa = $("#g_dKisa").val();
			g_gizli = $("#g_gizli").val();
			if((g_adi.length > 1) && (g_sAdi.length > 1) && (g_telNo.length > 1) && (g_cKisa.length > 1) && (g_dKisa.length > 1))
			{
				$.ajax({
					type:"POST",
					url :"/kayit.php",
					data :"session=<?php echo (isset($_SESSION["id"])?$_SESSION["id"]:md5("kastamonu"));?>&g_adi="+g_adi+"&g_sAdi="+g_sAdi+"&g_telNo="+g_telNo+"&g_cKisa="+g_cKisa+"&g_dKisa="+g_dKisa+"&g_gizli="+g_gizli,
					success : function(x)
					{
						if(x=="true")
						{
							location.reload();
						}else
						{
							$("#durum").val("Güncellenmedi!!!");
						}
					}
				});
			}else
			{
				$("#durum5").text("Güncellenmedi!!!");
			}
			
		});
		
	});
	</script>
  </body>
</html>
