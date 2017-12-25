<?php require_once 'layout/header.php'; ?>

<div id="content">
	<!-- START SLIDE HEADER -->
	<div id="carousel-id" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" id="headerSlide">
			<?php require_once 'backend-index.php'; get_3_newest(); ?>


		</div>
		<a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 all-product">
				<a><h2 onclick="ajax_buy()" title="Những sản phẩm bán chạy nhất tuần qua" class="content-menu">Sản phẩm nổi bật <span class="glyphicon glyphicon-menu-right" style="font-size: 18px"></span></h2></a>
				<?php  get_buy_the_most() ?>


				<a><h2 onclick="ajax_new()" title="Những sản phẩm nhập về gần đây" class="content-menu">Hàng mới về <span class="glyphicon glyphicon-menu-right" style="font-size: 18px"></span></h2></a>
				<?php  get_the_most_recent() ?>
			</div>
	</div>
</div>
</div>


<!-- <a class="btn btn-primary" data-toggle="modal" href='sanpham.php?masp=1' data-target="#modal-id">Trigger modal</a> -->
<div class="modal fade" id="modal-id" data-remote="">
	<div class="modal-dialog">
		<div class="modal-content" id="modal-sanpham">
			
		</div>
	</div>
</div>
<div class="like-error">
	<p>Bạn thích sản phẩm này? Hãy <a onclick="ajax_dangnhap();like_action();">đăng nhập</a> để lưu nó vào danh sách của riêng bạn hoặc <a onclick="ajax_dangky();like_action();">đăng ký</a> nếu chưa có tải khoản!<br><span class="btn btn-primary pull-right" onclick="like_action()">Đã hiểu</span></p>
</div>
<?php require_once 'layout/footer.php'; ?>