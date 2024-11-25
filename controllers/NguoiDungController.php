<?php
class NguoiDungController
{
  public $modelNguoiDung;
  public function __construct()
  {
    $this->modelNguoiDung = new NguoiDung();
  }

  public function formLogin()
  {
    if (isset($_SESSION['user'])) {
      header("Location: index.php");
    }

    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $noiDungs = $this->modelNguoiDung->getAdressShop();

    require_once './views/nguoidung/dang-nhap.php';
  }

  public function login()
  {
    if (isset($_SESSION['user'])) {
      header("Location: index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $email = $_POST['email'];
      $matKhau = $_POST['mat_khau'];
    }

    $errors = [];


    if (empty($email)) {
      $errors['email'] = "Vui lòng nhập email";
    }

    if (empty($matKhau)) {
      $errors['matKhau'] = "Vui lòng nhập mật khẩu";
    }

    if (!empty($email) && !empty($matKhau)) {
      $nguoiDung = $this->modelNguoiDung->checkLogin($email, $matKhau);
      if (count($nguoiDung) == 0) {
        $errors['matKhau'] = "Sai email hoặc mật khẩu";
      } else {
        if ($nguoiDung[0]['trang_thai'] == 1) {
          $errors['matKhau'] = "Tài khoản đã bị chặn";
        }
      }
    }

    if (empty($errors)) {
      $nguoiDung = $this->modelNguoiDung->checkLogin($email, $matKhau);
      $_SESSION['user'] = $nguoiDung[0];

      if ($nguoiDung[0]['admin'] == 0) {
        header("Location: ?act=/");
      } else {
        $_SESSION['admin'] = true;
        header("Location: admin/");
      }

      unset($_SESSION['errors']);
      exit();
    } else {
      $_SESSION['errors'] = $errors;
      header("Location: ?act=form-dang-nhap");
      exit();
    }
  }

  public function formSignUp()
  {
    if (isset($_SESSION['user'])) {
      header("Location: index.php");
    }

    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $noiDungs = $this->modelNguoiDung->getAdressShop();

    require_once './views/nguoidung/dang-ky.php';
  }

  public function signUp()
  {
    if (isset($_SESSION['user'])) {
      header("Location: index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $hoTen = $_POST['ho_ten'];
      $email = $_POST['email'];
      $matKhau = $_POST['mat_khau'];
      $reMatKhau = $_POST['re_mat_khau'];
      $dienThoai = $_POST['dien_thoai'];
      $gioiTinh = $_POST['gioi_tinh'] ?? null;
      $namSinh = $_POST['nam_sinh'];
      $diaChi = $_POST['dia_chi'];

      $errors = [];
      if (empty($hoTen)) {
        $errors['ho_ten'] = 'Vui lòng nhập họ tên';
      }

      if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập địa chỉ email';
      } else {
        if (count($this->modelNguoiDung->checkUniqueEmail($email)) > 0) {
          $errors['email'] = 'Địa chỉ email đã tồn tại';
        }
      }

      if (empty($matKhau) || empty($reMatKhau)) {
        if (empty($matKhau)) {
          $errors['mat_khau'] = "Vui lòng nhập mật khẩu";
        }

        if (empty($reMatKhau)) {
          $errors['re_mat_khau'] = "Vui lòng xác nhận lại mật khẩu";
        }
      } else {
        if ($matKhau !== $reMatKhau) {
          $errors['re_mat_khau'] = "Mật khẩu không trùng nhau";
        }
      }


      if (empty($dienThoai)) {
        $errors['dien_thoai'] = 'Vui lòng nhập số điện thoại';
      }

      if (empty($gioiTinh)) {
        $errors['gioi_tinh'] = 'Vui lòng chọn giới tính';
      }

      if (empty($namSinh)) {
        $errors['nam_sinh'] = 'Vui lòng chọn sinh nhật';
      }

      if (empty($diaChi)) {
        $errors['dia_chi'] = 'Vui lòng nhập địa chỉ';
      }

      if (empty($errors)) {
        // $matKhau = md5($matKhau);
        $this->modelNguoiDung->create($hoTen, $email, $matKhau, $dienThoai, $gioiTinh, $namSinh, $diaChi);
        $errors['check'] = 0;
        echo json_encode($errors);
      } else {
        $errors['check'] = 1;
        echo json_encode($errors);
        // var_dump($errors);
      }
    }
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    header("Location: ?act=/");
    exit();
  }

  public function listLike()
  {
    // if (isset($_SESSION['user'])) {
    //   header("Location: index.php");
    // }
    $noiDungs = $this->modelNguoiDung->getAdressShop();
    require_once './views/nguoidung/yeu-thich.php';
  }

  public function sendContact()
  {
    if ($_SERVER["REQUEST_METHOD"] ==  'POST') {
      $hoTen = $_POST['ten'];
      $email = $_POST['email'];
      $dienThoai = $_POST['dienThoai'];
      $noiDung = $_POST['noiDung'];

      $errors = [];
      if (empty($hoTen)) {
        $errors['ho_ten'] = "Vui lòng điền họ tên";
      }
      if (empty($email)) {
        $errors['email'] = "Vui lòng điền email";
      }
      if (empty($dienThoai)) {
        $errors['dien_thoai'] = "Vui lòng điền điện thoại";
      }
      if (empty($noiDung)) {
        $errors['noi_dung'] = "Vui lòng điền nội dung";
      }

      if (empty($errors)) {
        // $matKhau = md5($matKhau);
        $this->modelNguoiDung->sendContact($hoTen, $email, $dienThoai, $noiDung);
        $errors['check'] = 0;
        echo json_encode($errors);
      } else {
        $errors['check'] = 1;
        echo json_encode($errors);
        // var_dump($errors);
      }

      // var_dump($errors);
      // if (empty($errors)) {
      //   unset($_SESSION['errors']);
      //   $this->modelLienHe->create($hoTen, $email, $dienThoai, $noiDung);
      //   echo '<script>';
      //   echo 'alert("Gửi thành công");';
      //   echo '</script>';
      // } else {
      //   $_SESSION['errors'] = $errors;
      // }
    }
  }

  public function sendComment()
  {
    if ($_SERVER["REQUEST_METHOD"] ==  'POST') {
      $binhLuan = $_POST['binh_luan'];
      $idNguoiDung = $_POST['id_nguoi_dung'];
      $idSanPham = $_POST['id_san_pham'];

      $errors = [];
      if (empty($binhLuan)) {
        $errors['binh_luan'] = "Vui lòng điền bình luận";
      }

      if (empty($errors)) {

        $this->modelNguoiDung->sendComment($binhLuan, $idNguoiDung, $idSanPham);
      }
      // echo "<script>
      // alert('Thông báo trước khi chuyển trang');
      // window.location.href = '?act=chi-tiet-san-pham&id=$idSanPham';  // Chuyển trang sau khi alert
      //  </script>";

      $_SESSION["message"] = "Bình luận thành công!";
      header("Location: ?act=chi-tiet-san-pham&id=$idSanPham");
      exit();
    }
  }
  public function viewAccount()
  {
    $id = $_SESSION['user']['id'];
    $nguoiDung = $this->modelNguoiDung->getProfile($id);
    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $noiDungs = $this->modelNguoiDung->getAdressShop();

    require_once './views/nguoidung/tai-khoan.php';
  }
  public function editAccount()
  {
    $id = $_POST['id'] ?? $_SESSION['id'];
    $nguoiDung = $this->modelNguoiDung->getProfile($id);
    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $noiDungs = $this->modelNguoiDung->getAdressShop();
    require_once './views/nguoidung/edit-tai-khoan.php';
  }
  public function updateAccount()
  {
    $id = $_POST['id'];
    $hoTen = $_POST['ho_ten'];
    $email = $_POST['email'];
    $diaChi = $_POST['dia_chi'];
    $dienThoai = $_POST['so_dien_thoai'];
    $gioiTinh = $_POST['gioi_tinh'];
    $ngaySinh = $_POST['ngay_sinh'] == ""  ? $_POST['ngay_sinh_not_update'] : $_POST['ngay_sinh'];
    $nguoiDungs = $this->modelNguoiDung->getAllUsers();
    $profile = $this->modelNguoiDung->getProfile($id);

    $error = [];
    if (empty($hoTen)) {
      $error['ho_ten'] = "Họ tên không được để trống";
    }
    if (empty($email)) {
      $error['email'] = "Email không được để trống";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error['email'] = "Email không đúng định dạng";
    } else {
      foreach ($nguoiDungs as $nguoiDung) {
        if ($nguoiDung['email'] == $email && $nguoiDung['email'] != $profile['email']) {
          $error['email'] = "Email đã tồn tại";
        }
      }
    }
    if (empty($diaChi)) {
      $error['dia_chi'] = "Địa chỉ không được để trống";
    }
    if (empty($dienThoai)) {
      $error['dien_thoai'] = "Số điện thoại không được để trống";
    } else if (strlen($dienThoai) > 10) {
      $error['dien_thoai'] = "Số điện thoại chỉ gồm 10 số";
    } else {
      foreach ($nguoiDungs as $nguoiDung) {
        if ($nguoiDung['dien_thoai'] == $dienThoai && $nguoiDung['dien_thoai'] != $profile['dien_thoai']) {
          $error['dien_thoai'] = "Số điện thoại đã tồn tại";
        }
      }
    }

    if (empty($error)) {
      $this->modelNguoiDung->updateProfile($id, $hoTen, $email, $diaChi, $dienThoai, $gioiTinh, $ngaySinh);
      $_SESSION['id'] = $id;

      unset($_SESSION['error']);
      header("Location: ?act=tai-khoan");
      exit();
    } else {
      $_SESSION['error'] = $error;
      $_SESSION['id'] = $id;
      header("Location: ?act=cap-nhat-tai-khoan");
      exit();
    }
  }
  public function getFormChangePassword()
  {
    $id = $_SESSION['id']  ?? $_POST['id'];
    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $noiDungs = $this->modelNguoiDung->getAdressShop();
    require_once('./views/nguoidung/doi-mat-khau.php');
  }
  public function updatePassword()
  {
    $id = $_POST['id'];
    $nguoiDungs = $this->modelNguoiDung->getAllUsers();
    $profile = $this->modelNguoiDung->getProfile($id);

    $matKhauHienTai = $_POST['mat_khau_hien_tai'];
    $matKhauMoi = $_POST['mat_khau_moi'];
    $matKhauXacNhan = $_POST['mat_khau_xac_nhan'];

    $error = [];
    if (empty($matKhauHienTai)) {
      $error['mat_khau_hien_tai'] = "Chưa nhập mật khẩu hiện tại";
    } else if ($matKhauHienTai != $profile['mat_khau']) {
      $error['mat_khau_hien_tai'] = "Nhập sai mật khẩu";
    }
    if (empty($matKhauXacNhan)) {
      $error['mat_khau_xac_nhan'] = "Chưa nhập mật khẩu xác nhận";
    } else if ($matKhauHienTai != $matKhauXacNhan) {
      $error['mat_khau_xac_nhan'] = "Mật khẩu xác nhận không trùng khớp";
    }
    if (empty($matKhauMoi)) {
      $error['mat_khau_moi'] = "Chưa nhập mật khẩu mới";
    } else {
      foreach ($nguoiDungs as $nguoiDung) {
        if ($matKhauMoi == $nguoiDung['mat_khau']) {
          $error['mat_khau_moi'] = "Mật khẩu mới đã tồn tại";
        }
      }
    }
    if (empty($error)) {
      $this->modelNguoiDung->updatePassword($id, $matKhauMoi);
      $_SESSION['id'] = $id;

      unset($_SESSION['error']);
      header("Location: ?act=dang-xuat");
      exit();
    } else {
      $_SESSION['error'] = $error;
      $_SESSION['id'] = $id;
      header("Location: ?act=doi-mat-khau");
      exit();
    }
  }

  public function addToCart()
  {



    if ($_SERVER["REQUEST_METHOD"] ==  'POST') {
      $json = [];


      if (isset($_SESSION['user'])) {
        $json['check_login'] = true;
        $user = $_SESSION['user'];
        $idProduct = $_POST['id'];
        $so_luong = $_POST['quantity'] ?? 1;
        $sanPham = $this->modelNguoiDung->getProductById($idProduct);
        $sanPhamTrongGioHang =  $this->modelNguoiDung->checkProductInCart($user['id'], $idProduct);

        $so_luong_trong_gio = $sanPhamTrongGioHang ? $sanPhamTrongGioHang['so_luong'] : 0;

        if ($so_luong + $so_luong_trong_gio - $sanPham['hang_ton_kho'] <= 0) {
          if ($sanPhamTrongGioHang) {
            $this->modelNguoiDung->updateQuantityInCart($user['id'], $idProduct, $so_luong + $so_luong_trong_gio);
          } else {
            $this->modelNguoiDung->insertQuantityInCart($user['id'], $idProduct, $so_luong);
          }
          $json['message'] = "Thêm vào giỏ hàng thành công!";
        } else {
          if (!$sanPhamTrongGioHang && $sanPham['hang_ton_kho'] == 0) {
            $json['message'] = "Sản phẩm đã hết hàng!";
          } else if ($sanPhamTrongGioHang) {
            $json['message'] = "Sản phẩm đã có trong giỏ hàng.\nSố lượng đặt vượt quá hàng trong kho.";
          } else {
            $json['message'] = "Số lượng đặt vượt quá hàng trong kho.";
          }
        }

        echo json_encode($json);
      } else {
        $json['check_login'] = false;
        echo json_encode($json);
      }
    }
  }
  public function viewMyOrder()
  {
    $id = $_POST['id'];

    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $donHangs = $this->modelNguoiDung->getMyOrder($id);
    $noiDungs = $this->modelNguoiDung->getAdressShop();
    require_once('./views/nguoidung/don-hang.php');
  }
  public function viewManageOrder()
  {
    $danhMucs = $this->modelNguoiDung->getAllDanhMuc();
    $noiDungs = $this->modelNguoiDung->getAdressShop();
    require_once('./views/nguoidung/manage-don-hang.php');
  }
}
