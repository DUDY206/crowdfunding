<html>
<head>
    <title>Khách hàng đăng ký crowdfunding - crowdfunding.com</title>
</head>
<body>
<p>
    <p>Tên: {{ $fullname }}</p>
    <p>Email: {{ $email }}</p>
    <p>Số điện thoại: {{ $phone }}</p>
    <p>Ngày sinh: {{ date('d/m/Y', strtotime($dateOfBirth)) }}</p>
    <p>Vị trí mong muốn: {{ ($position === 0) ? 'Doanh nghiệp gọi vốn' : 'Nhà đầu tư'  }}</p>
</p>
</body>
</html>
