
<?php

require_once 'backend-index.php';


$fname = "";
if(isset($_GET['fname'])){
	$fname = $_GET['fname'];
}
switch ($fname) {
	case 'php_saling':
	php_saling();
	break;
	case 'php_new':
	php_new();
	break;
	case 'php_buy':
	php_buy();
	break;
	case 'php_dmsp':
	php_danhmucsp();
	break;
	case 'php_dangky':
	php_dangky();
	break;
	case 'php_dangnhap':
	php_dangnhap();
	break;
	case 'php_giohang':
	php_giohang();
	break;
	case 'php_like':
	php_like();
	break;
	case 'php_search':
	php_search();
	break;
	case 'load_more':
	load_more();
	break;

	default:
	echo "Yêu cầu không tìm thấy!";		
}
function load_more(){
	session_start();
	$cr = '';
	if(isset($_GET['current'])){$cr = $_GET['current'];}
	$st = ($cr+1)*$_SESSION['limit'];
	if($st >= $_SESSION['total']){
		echo "hetcmnrdungbamnua";
	}
	$sql = $_SESSION['sql'] . " LIMIT ".$st.",".$_SESSION['limit']."";
	$conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
	/*$conn = mysqli_connect("localhost","k2739nvdu_qlbh","cuchuoi258","k2739nvdu_qlbh") or die('Không thể kết nối!');*/
	mysqli_set_charset($conn, 'utf8');
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
}
function php_saling(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.khuyenmai DESC LIMIT ".$_SESSION['limit']."";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.khuyenmai DESC";
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php

}
function php_new(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.ngay_nhap DESC LIMIT ".$_SESSION['limit']."";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.ngay_nhap DESC ";
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php
}
function php_buy(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.luotmua DESC LIMIT ".$_SESSION['limit']."";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.luotmua DESC";
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php
}

//Danh muc san pham
function php_danhmucsp(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$detail = "";
	if(isset($_GET['detail'])){
		$detail = strtolower($_GET['detail']);
	}
	$sql = "";

	switch ($detail) {
		case 'all':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.gia ASC";
		break;
		case 'rolex':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm = 'rolex' ORDER BY sp.gia ASC";
		break;
		case 'cartier':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm = 'cartier' ORDER BY sp.gia ASC";
		break;
		case 'omega':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm = 'omega' ORDER BY sp.gia ASC";
		break;
		case 'patek':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm = 'patek philippe' ORDER BY sp.gia ASC";
		break;
		case 'piaget':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm = 'piaget' ORDER BY sp.gia ASC";
		break;
		case 'montblanc':
		$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm = 'montblanc' ORDER BY sp.gia ASC";
		break;
	}
	$sqlx = $sql;
	$sql .= " LIMIT ".$_SESSION['limit']."";
	echo "<h3>Danh mục sản phẩm / ".ucwords($detail)."</h3>";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))   {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = $sqlx;
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php
}
function php_dangky(){
	require_once 'signUp.php';
}
function php_dangnhap(){
	require_once 'signIn.php';
}
function php_giohang(){
	?>

	<div class="container-fluid form" style="padding: 20px">
		<div class="row">
			<div class="col-sm-3">
			</div>
			<div class="col-sm-6">
				<legend><h2>Giỏ hàng của bạn</h2></legend>

				<?php
				session_start();
				if(isset($_SESSION['user'])){
					$conn = connect();
					mysqli_set_charset($conn, 'utf8');
					$tmpArr = $_SESSION['user_cart'];

					array_shift($tmpArr);
					$tmpArr = array_unique($tmpArr);
					$x = '('.implode(',',$tmpArr).')';
					$sql = "SELECT * FROM sanpham  WHERE masp IN ".$x."";
					$result = mysqli_query($conn, $sql);
					if($x == '()'){
						echo "<h4>Giỏ hàng trống</h4>";
						echo "<i>Ây da, bạn phải bỏ hàng vào giỏ đã chứ :)</i>";
						return 0;
					} 
					while ($row = mysqli_fetch_assoc($result)) {?>
					<a data-toggle='modal' href="sanpham.php?masp=<?php echo $row['masp'] ?>" data-target='#modal-id'>
						<div class='prd-in-cart' onclick="hien_sanpham('<?php echo $row['masp'] ?>')">
							<img src="<?php echo $row['anhchinh'] ?>">
							<div class='prd-dt'>
								<h3><b><?php echo $row['tensp'] ?></b></h3>
								<span class='prd-price'><?php echo $row['gia'] ?></span>
							</div>
						</div></a>
						<?php
					}
					?>

					<a href="order.php?q=multi" class="btn btn-success btn-block" style="color: white;font-size: 27px; margin-bottom: 10px;">Đặt Hàng</a>
				</div>
			</div>
		</div>
		<?php

	} else {
		if(isset($_SESSION['client_cart'])){
			if(count($_SESSION['client_cart']) > 1){
				$conn = connect();
				mysqli_set_charset($conn, 'utf8');
				$arr = $_SESSION['client_cart'];

				array_shift($arr);
				$in = implode(',',$arr);
				$in = '('.$in.')';
				$sql = "SELECT * FROM sanpham WHERE masp IN ".$in."";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {?>
				<a data-toggle='modal' href="sanpham.php?masp=<?php echo $row['masp'] ?>" data-target='#modal-id'>
					<div class='prd-in-cart' onclick="hien_sanpham('<?php echo $row['masp'] ?>')">
						<img src="<?php echo $row['anhchinh'] ?>">
						<div class='prd-dt'>
							<h3><b><?php echo $row['tensp'] ?></b></h3>
							<span class='prd-price'><?php echo $row['gia'] ?></span>
						</div>
					</div></a>
					<?php
				}
				?>
				<a href="order.php?q=multi" class="btn btn-success btn-block" style="color: white;font-size: 27px; margin-bottom: 10px;">Đặt Hàng</a>
			</div>
		</div>
	</div>
	<?php
} else {
	echo "<h4>Giỏ hàng trống</h4>";
	echo "<i>Ây da, bạn phải bỏ hàng vào giỏ đã chứ :)</i>";
}
}

}

}


function php_like(){
	?>

	<div class="container-fluid form" style="margin-top: -23px; padding: 20px">
		<div class="row">
			<div class="col-sm-3">
			</div>
			<div class="col-sm-6">
				<legend><h2>SẢN PHẨM YÊU THÍCH</h2></legend>

				<?php
				session_start();
				if(isset($_SESSION['user'])){
					$conn = connect();
					mysqli_set_charset($conn, 'utf8');
					$tmpArr = $_SESSION['like'];

					array_shift($tmpArr);
					$tmpArr = array_unique($tmpArr);
					$x = '('.implode(',',$tmpArr).')';
					$sql = "SELECT * FROM sanpham  WHERE masp IN ".$x."";
					$result = mysqli_query($conn, $sql);
					if($x == '()'){
						echo "<h4>BẠN CHƯA THÍCH SẢN PHẨM NÀO!</h4>";
						echo "<i>Quay lại trang chủ và thả tym :)</i>";
						return 0;
					} 
					while ($row = mysqli_fetch_assoc($result)) {?>
					<a data-toggle='modal' href="sanpham.php?masp=<?php echo $row['masp'] ?>" data-target='#modal-id'>
						<div class='prd-in-cart' onclick="hien_sanpham('<?php echo $row['masp'] ?>')">
							<img src="<?php echo $row['anhchinh'] ?>">
							<div class='prd-dt'>
								<h3><b><?php echo $row['tensp'] ?></b></h3>
								<span class='prd-price'><?php echo $row['gia'] ?></span>
								<a href="order.php?masp=<?php echo $row['masp'] ?>" class="btn btn-success">Mua ngay</a>
							</div>
						</div></a>
						<?php
					}
					?>

					<a href="order.php?q=buylikepr" class="btn btn-success btn-block" style="color: white;font-size: 27px; margin-bottom: 10px;">Mua tất cả</a>
				</div>
			</div>
		</div>
		<?php

	} else {
		?>
		<i>Xin lỗi, bạn phải <a onclick="ajax_dangnhap()">đăng nhập</a> để xem những sản phẩm yêu thích của mình! Nếu chưa có tài khoản, hãy <a  onclick="ajax_dangky()">đăng ký ngay</a></i>
		<?php
	}
	?>
</div>
</div>
</div>
<?php
}
function php_search(){
	$s = $_GET['s'];
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND tensp like '%".$s."%'";
	$result = mysqli_query($conn, $sql);
	?>
	<h4>Kết quả tìm kiếm cho: <?php echo $s ?></h4>
	<?php
	if(mysqli_num_rows($result) == 0){
		echo "<i>Không có kết quả! Hãy thử bằng tên một loại đồng hồ hoặc mẫu mã của nó!</i>";
	}
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
}


?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".cart-container").click(function(){
			$(this).toggleClass('cart-ordered');
		});
	});
</script>