<?php
add_shortcode('qlcb_search', 'qlcb_user_view');

function qlcb_user_view() {
    global $wpdb;
    $table = $wpdb->prefix . 'canbo';
    $ten = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

    $query = "SELECT * FROM $table";
    if ($ten) {
        $query .= $wpdb->prepare(" WHERE HoTen LIKE %s", "%$ten%");
    }

    $rows = $wpdb->get_results($query);

    ob_start(); ?>
    <form method="get" class="qlcb-form">
        <p><input name="search" value="<?= esc_attr($ten) ?>" placeholder="Tìm theo tên"></p>
        <p><button>Tìm kiếm</button></p>
    </form>
    <table class="qlcb-table">
        <tr><th>Mã</th><th>Họ tên</th><th>Phòng</th><th>Lương</th></tr>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= esc_html($row->MaCB) ?></td>
            <td><?= esc_html($row->HoTen) ?></td>
            <td><?= esc_html($row->PhongBan) ?></td>
            <td><?= esc_html($row->TongLuong) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php return ob_get_clean();
}