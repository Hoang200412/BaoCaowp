<?php 

function qlcb_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'canbo';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        MaCB VARCHAR(10) PRIMARY KEY,
        HoTen VARCHAR(100),
        NgaySinh DATE,
        GioiTinh VARCHAR(10),
        PhongBan VARCHAR(100),
        HeSoLuong FLOAT,
        LuongCoBan FLOAT,
        TongLuong FLOAT
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function qlcb_delete_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'canbo';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}