<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการห้องพัก</title>
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
        
    <h1>จัดการห้องพัก</h1>
    <h2>ข้อมูลห้องพัก</h2>        
        
    <a href="add.php" class="btn-add">+ เพิ่มห้องพักใหม่</a>
    
    <table>
        <thead>
            <tr>
                <th>เลขห้อง</th>
                <th>ชั้น</th>
                <th>ประเภท</th>
                <th>ราคา/เดือน</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(isset($conn)) {
            $result = $conn->query("SELECT * FROM rooms ORDER BY room_number");
            if($result) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>".htmlspecialchars($row['room_number'])."</td>
                        <td>".htmlspecialchars($row['floor'])."</td>
                        <td>".htmlspecialchars($row['room_type'])."</td>
                        <td>".number_format($row['price_per_month'], 2)."</td>
                        <td>".htmlspecialchars($row['status'])."</td>
                        <td>
                            <a href='edit.php?id={$row['room_id']}'>แก้ไข</a> | 
                            <a href='delete.php?id={$row['room_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบ?')\">ลบ</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>ไม่พบข้อมูล หรือ คำสั่ง SQL ผิดพลาด</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
    
    <br>
    <a href="../" class="btn-home">🏠︎ กลับหน้าหลัก</a>

</body>
</html>