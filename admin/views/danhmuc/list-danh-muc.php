<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Oct 2024 07:29:52 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Quản lý danh mục | TechZ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- CSS -->
    <?php
    require_once "views/layouts/libs_css.php";
    ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- HEADER -->
        <?php
        require_once "views/layouts/header.php";

        require_once "views/layouts/siderbar.php";
        ?>

        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Quản lý danh mục</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="?act=/">Dashboards</a></li>
                                        <li class="breadcrumb-item active">Quản lý danh mục</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Danh sách danh mục sản phẩm</h4>
                                    <div class="col-auto">
                                        <a href="?act=form-them-danh-muc" class="btn btn-soft-success material-shadow-none"><i class="ri-add-circle-line align-middle me-1"></i> Thêm danh mục</a>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">

                                    <div class="live-preview">

                                        <div class="table-responsive">

                                            <table class="table table-borderless align-middle table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">STT</th>
                                                        <th scope="col">Tên danh mục</th>
                                                        <th scope="col">Icon danh mục</th>
                                                        <th scope="col">Trạng thái</th>
                                                        <th scope="col">Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($danhMucs as $index => $danhMuc): ?>
                                                        <tr>
                                                            <td class="fw-medium"><?= $index + 1 ?></td>
                                                            <td><?= $danhMuc['ten'] ?></td>
                                                            <td> <img src="<?= $danhMuc['hinh_anh'] ?>" alt="" width="50px"> </td>
                                                            <td>
                                                                <?php if ($danhMuc['trang_thai'] == 2) {

                                                                ?>
                                                                    <span class="badge bg-success-subtle text-success">Hiển thị</span>
                                                                <?php } else {
                                                                ?>
                                                                    <span class="badge bg-danger-subtle text-danger">Ẩn</span>

                                                                <?php
                                                                } ?>

                                                            </td>
                                                            <td>
                                                                <div class="hstack gap-3 fs-15">
                                                                    <a href="?act=form-sua-danh-muc&id=<?= $danhMuc['id'] ?>" class="link-primary"><i class="ri-settings-4-line"></i></a>
                                                                    <a href="?act=xem-chi-tiet-danh-muc&id=<?= $danhMuc['id'] ?>" class="link-primary"><i class="ri-file-list-line"></i></a>
                                                                    <form action="?act=xoa-danh-muc" method="POST" onsubmit='return confirm("Bạn có chắc muốn xóa dữ liệu này ?")'>
                                                                        <input type="hidden" name="danh_muc_id" value="<?= $danhMuc['id'] ?>">
                                                                        <button type="submit" class="link-danger" style="border: none; background:none"><i class="ri-delete-bin-5-line"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © Velzon.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->



        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

        <!--preloader-->
        <div id="preloader">
            <div id="status">
                <div class="spinner-border text-primary avatar-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <div class="customizer-setting d-none d-md-block">
            <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <?php
        require_once "views/layouts/libs_js.php";
        ?>

</body>

</html>