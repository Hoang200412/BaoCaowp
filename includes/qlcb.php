<?php

add_shortcode('qlcb_admin', 'qlcb_admin_form');

function qlcb_admin_form() {
    if (!is_user_logged_in()) {
        return "<p>Vui lòng <a href='" . wp_login_url() . "'>đăng nhập</a>.</p>";
    }

    $user = wp_get_current_user();
    if (!in_array('administrator', $user->roles)) {
        return "<p>Bạn không có quyền truy cập chức năng này.</p>";
    }

    global $wpdb;
    $table = $wpdb->prefix . 'canbo';

    // Thêm hoặc cập nhật
    if (isset($_POST['qlcb_submit'])) {
        $data = [
            'MaCB' => sanitize_text_field($_POST['MaCB']),
            'HoTen' => sanitize_text_field($_POST['HoTen']),
            'NgaySinh' => $_POST['NgaySinh'],
            'GioiTinh' => $_POST['GioiTinh'],
            'PhongBan' => sanitize_text_field($_POST['PhongBan']),
            'HeSoLuong' => floatval($_POST['HeSoLuong']),
            'LuongCoBan' => floatval($_POST['LuongCoBan']),
        ];
        $data['TongLuong'] = $data['HeSoLuong'] * $data['LuongCoBan'];
        $wpdb->replace($table, $data);
        echo "<p>Đã lưu cán bộ.</p>";
    }

    // Xóa
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['MaCB' => $_GET['delete']]);
        echo "<p>Đã xóa cán bộ.</p>";
    }

    // Hiển thị form
    ob_start(); ?>
    <form method="post" class="qlcb-form">
        <p><input name="MaCB" placeholder="Mã CB" required></p>
        <p><input name="HoTen" placeholder="Họ tên" required></p>
        <p><input type="date" name="NgaySinh" required></p>
        <p>
            <select name="GioiTinh">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </p>
        <p><input name="PhongBan" placeholder="Phòng ban" required></p>
        <p><input name="HeSoLuong" type="number" step="0.01" required></p>
        <p><input name="LuongCoBan" type="number" step="0.01" required></p>
        <p><button name="qlcb_submit">Lưu</button></p>
    </form>

    <h3>Danh sách cán bộ</h3>
    <table class="qlcb-table">
        <tr><th>Mã</th><th>Họ tên</th><th>Tổng lương</th><th>Xóa</th></tr>
        <?php
        $rows = $wpdb->get_results("SELECT MaCB, HoTen, TongLuong FROM $table");
        foreach ($rows as $row) {
            echo "<tr>
                <td>$row->MaCB</td>
                <td>$row->HoTen</td>
                <td>$row->TongLuong</td>
                <td><a href='?delete=$row->MaCB' onclick='return confirm(\"Xóa?\")'>Xóa</a></td>
            </tr>";
        }
        ?>
    </table>
    <?php return ob_get_clean();
}