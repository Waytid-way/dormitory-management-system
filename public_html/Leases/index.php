<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการสัญญาเช่า</title>
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

        .status-active { color: green; font-weight: bold; }
        .status-inactive { color: red; }
    </style>
</head>
<body>

    <?php include('../billings/components/navbar.php'); ?>

    <h1>จัดการสัญญาเช่า</h1>
    <h2>รายการสัญญาเช่าทั้งหมด</h2>

    <a href="add.php" class="btn-add">+ เพิ่มสัญญาใหม่</a>
    
    <table>
        <thead>
            <tr>
                <th>ID สัญญา</th>
                <th>ผู้เช่า</th>
                <th>ห้อง</th>
                <th>วันเริ่มสัญญา</th>
                <th>วันสิ้นสุด</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php

        $sql = "SELECT l.*, t.full_name, r.room_number 
                FROM leases l
                LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
                LEFT JOIN rooms r ON l.room_id = r.room_id
                ORDER BY l.start_date DESC";
        
        if(isset($conn)) {
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $statusClass = $row['active'] ? 'status-active' : 'status-inactive';
                    $statusText = $row['active'] ? 'ใช้งาน (Active)' : 'ยกเลิก (Inactive)';

                    echo "<tr>
                        <td>".htmlspecialchars($row['lease_id'])."</td>
                        <td>".htmlspecialchars($row['full_name'] ?? 'ไม่ระบุ')."</td>
                        <td>".htmlspecialchars($row['room_number'] ?? 'ไม่ระบุ')."</td>
                        <td>".date('d/m/Y', strtotime($row['start_date']))."</td>
                        <td>".date('d/m/Y', strtotime($row['end_date']))."</td>
                        <td><span class='{$statusClass}'>{$statusText}</span></td>
                        <td>
                            <a href='edit.php?id={$row['lease_id']}'>แก้ไข</a> | 
                            <a href='delete.php?id={$row['lease_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบสัญญานี้?')\">ลบ</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>ไม่พบข้อมูลสัญญาเช่า</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
    
    <br>
    <a href="../" class="btn-home">🏠︎ กลับหน้าหลัก</a>

</body>
</html>