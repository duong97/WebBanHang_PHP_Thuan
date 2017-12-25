<script type="text/javascript">

	window.onkeyup = function(e){
		if(e.keyCode == 13){
			call_to_dangnhap();
		}
	}
</script>
<div class="container-fluid form" style="padding: 20px">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form action="" method="POST" role="form">
				<legend>Đăng Nhập</legend>

				<div class="form-group">
					<label for="">Tên tài khoản: </label>
					<input type="text" class="form-control" id="username">
				</div>
				<div class="form-group">
					<label for="">Mật khẩu: </label>
					<input type="password" class="form-control" id="password">
				</div>
				<input type="checkbox" id="rmbme" value="rmbme"><label> Nhớ tài khoản</label><br>

				<div onclick="call_to_dangnhap()" class="btn btn-primary">Submit</div><br><br>
				<a href="" style="float: right;">Quên mật khẩu?</a><br>
				<a onclick="ajax_dangky()" style="float: right;">Tạo tài khoản mới</a><br><br>
			</form>
		</div>
		<div class="col-lg-12"></div>
	</div>
</div>
