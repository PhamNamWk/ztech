<?php
class TinTuc
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM tin_tucs";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi : " . $e->getMessage();
        }
    }
    public function postData($tieuDe, $moTaNgan, $hinhAnh, $ngayTao, $noiDung, $trangThai, $luotXem = 0)
    {
        try {
            $sql = "INSERT INTO tin_tucs (tieu_de,mo_ta_ngan,hinh_anh,ngay_tao,luot_xem,noi_dung,trang_thai) VALUES (:tieu_de,:mo_ta_ngan,:hinh_anh,:ngay_tao,:luot_xem,:noi_dung,:trang_thai)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tieu_de', $tieuDe);
            $stmt->bindParam(':mo_ta_ngan', $moTaNgan);
            $stmt->bindParam(':ngay_tao', $hinhAnh);
            $stmt->bindParam(':hinh_anh', $ngayTao);
            $stmt->bindParam(':noi_dung', $noiDung);
            $stmt->bindParam(':trang_thai', $trangThai);
            $stmt->bindParam(':luot_xem', $luotXem);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Lỗi : " . $e->getMessage();
        }
    }
    public function getDetailData($id)
    {
        try {
            $sql = "SELECT * FROM tin_tucs WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi : " . $e->getMessage();
        }
    }
    public function updateData($id, $tenDanhMuc, $trangThai, $hinhAnh)
    {
        // try {
        //     $sql = "UPDATE danh_mucs SET ten=:ten_danh_muc ,hinh_anh=:hinh_anh,trang_thai=:trang_thai WHERE id = :id";
        //     $stmt = $this->conn->prepare($sql);
        //     $stmt->bindParam(':ten_danh_muc', $tenDanhMuc);
        //     $stmt->bindParam(':hinh_anh', $hinhAnh);
        //     $stmt->bindParam(':trang_thai', $trangThai);
        //     $stmt->bindParam(':id', $id);

        //     $stmt->execute();
        //     return true;
        // } catch (PDOException $e) {
        //     echo "Lỗi : " . $e->getMessage();
        // }
    }
    public function deleteData($id)
    {
        try {
            $sql = "DELETE FROM tin_tucs WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Lỗi : " . $e->getMessage();
        }
    }
    public function __destruct()
    {
        $this->conn = null;
    }
}
