<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการผู้เช่า</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f9f9f9; }
        h1, h2 { color: #333; }
        nav { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        nav a { text-decoration: none; color: #007bff; font-weight: bold; margin-right: 15px; }
        nav a:hover { text-decoration: underline; }
        
        .btn-add {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background-color 0.3s;
        }
        .btn-add:hover {
            background-color: #218838;
            color: white;
        }
        .btn-home {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4F4F4F;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background-color 0.3s;
        }
        .btn-home:hover {
            background-color: #242424;
            color: white;
        }
        
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f2f2f2; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>

    <?php include('../billings/components/navbar.php'); ?>

    <h1>จัดการผู้เช่า</h1>
    <h2>ข้อมูลผู้เช่า</h2>

    <a href="add.php" class="btn-add">+ เพิ่มผู้เช่าใหม่</a>
        
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ชื่อ-สกุล</th>
                <th>โทรศัพท์</th>
                <th>อีเมล</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(isset($conn)) {
            $result = $conn->query("SELECT * FROM tenants ORDER BY tenant_id DESC");
            
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    // ใช้ htmlspecialchars เพื่อความปลอดภัยและป้องกัน HTML เพี้ยน
                    echo "<tr>
                        <td>".htmlspecialchars($row['tenant_id'])."</td>
                        <td>".htmlspecialchars($row['full_name'])."</td>
                        <td>".htmlspecialchars($row['phone'])."</td>
                        <td>".htmlspecialchars($row['email'])."</td>
                        <td>
                            <a href='edit.php?id={$row['tenant_id']}'>แก้ไข</a> | 
                            <a href='delete.php?id={$row['tenant_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบ?')\">ลบ</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>ไม่พบข้อมูล</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <br>
    <a href="../" class="btn-home">🏠︎ กลับหน้าหลัก</a>

</body>
</html>