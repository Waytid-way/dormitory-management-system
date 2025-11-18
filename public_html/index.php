<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ระบบจัดการหอพัก</title>
<style>
    body { font-family: 'Sarabun', sans-serif; display: grid; place-items: center; min-height: 80vh; background: #f4f4f4; }
    .container { background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 40px; }
    h1 { text-align: center; margin-top: 0; color: #333; }
    nav ul { list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    nav a { display: block; background: #007bff; color: white; padding: 15px 20px; border-radius: 5px; text-decoration: none; text-align: center; font-size: 1.1em; transition: background 0.3s; }
    nav a:hover { background: #0056b3; }
</style>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>ระบบจัดการหอพัก (Mockup)</h1>
    <nav>
        <ul>
            <li><a href="dashboard/">แดชบอร์ด</a></li>
            <li><a href="tenants/">จัดการผู้เช่า</a></li>
            <li><a href="rooms/">จัดการห้องพัก</a></li>
            <li><a href="leases/">จัดการสัญญา</a></li>
            <li><a href="billings/">จัดการบิล</a></li>
            <li><a href="payments/">จัดการชำระเงิน</a></li>
        </ul>
    </nav>
</div>
</body>
</html>