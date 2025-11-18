<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการการชำระเงิน</title>
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

    <h1>จัดการการชำระเงิน</h1>
    <h2>ประวัติการรับชำระ</h2>

    <a href="add.php" class="btn-add">+ บันทึกการชำระเงิน</a>

    <table>
        <thead>
            <tr>
                <th>บิล ID</th>
                <th>ผู้จ่าย</th>
                <th>จำนวน (บาท)</th>
                <th>วันที่ชำระ</th>
                <th>วิธีชำระ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT p.*, t.full_name 
                FROM payments p
                LEFT JOIN billings b ON p.billing_id = b.billing_id
                LEFT JOIN leases l ON b.lease_id = l.lease_id
                LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
                ORDER BY p.payment_date DESC";
        
        if(isset($conn)) {
            $result = $conn->query($sql);
            
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>".htmlspecialchars($row['billing_id'])."</td>
                        <td>".htmlspecialchars($row['full_name'] ?? 'ไม่ระบุ (N/A)')."</td>
                        <td>".number_format($row['amount'], 2)."</td>
                        <td>".date('d/m/Y H:i', strtotime($row['payment_date']))."</td>
                        <td>".htmlspecialchars($row['method'])."</td>
                        <td>
                            <a href='delete.php?id={$row['payment_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบรายการชำระเงินนี้?')\">ลบ</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>ยังไม่มีข้อมูลการชำระเงิน</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <br>
    <a href="../" class="btn-home">🏠︎ กลับหน้าหลัก</a>

</body>
</html>