<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการใบแจ้งหนี้</title>
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


        .status-paid { color: green; font-weight: bold; }
        .status-pending { color: #e67e22; font-weight: bold; }
        .status-overdue { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <?php include('../billings/components/navbar.php'); ?>

    <h1>จัดการใบแจ้งหนี้</h1>
    <h2>รายการใบแจ้งหนี้ทั้งหมด</h2>

    <a href="add.php" class="btn-add">+ สร้างใบแจ้งหนี้ใหม่</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>สัญญา (ผู้เช่า / ห้อง)</th>
                <th>วันที่ออกบิล</th>
                <th>ยอดรวม</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT b.*, t.full_name, r.room_number
                FROM billings b
                LEFT JOIN leases l ON b.lease_id = l.lease_id
                LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
                LEFT JOIN rooms r ON l.room_id = r.room_id
                ORDER BY b.billing_date DESC";
        
        if(isset($conn)) {
            $result = $conn->query($sql);
            
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    $status = strtolower($row['status']);
                    $statusClass = '';
                    if ($status == 'paid' || $status == 'ชำระแล้ว') $statusClass = 'status-paid';
                    elseif ($status == 'pending' || $status == 'รอชำระ') $statusClass = 'status-pending';
                    elseif ($status == 'overdue' || $status == 'เกินกำหนด') $statusClass = 'status-overdue';

                    echo "<tr>
                        <td>".htmlspecialchars($row['billing_id'])."</td>
                        <td>
                            ".htmlspecialchars($row['full_name'] ?? 'ไม่ระบุ')." <br> 
                            <small style='color:#888;'>ห้อง: ".htmlspecialchars($row['room_number'] ?? '-')."</small>
                        </td>
                        <td>".date('d/m/Y', strtotime($row['billing_date']))."</td>
                        <td><b>".number_format($row['total_amount'], 2)."</b></td>
                        <td class='{$statusClass}'>".htmlspecialchars($row['status'])."</td>
                        <td>
                            <a href='receipt.php?id={$row['billing_id']}' target='_blank' style='color: #007bff; text-decoration: none;'>🖨️ ใบเสร็จ</a> | 
                            <a href='edit.php?id={$row['billing_id']}'>แก้ไข</a> | 
                            <a href='delete.php?id={$row['billing_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบใบแจ้งหนี้นี้?')\">ลบ</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>ไม่พบข้อมูลใบแจ้งหนี้</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
    
    <br>
    <a href="../" class="btn-home">🏠︎ กลับหน้าหลัก</a>

</body>
</html>