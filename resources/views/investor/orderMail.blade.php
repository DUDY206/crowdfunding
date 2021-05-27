<html>
<head>
    <title>Cảm ơn bạn đã quan tâm tới dự án {{$invest_name}}</title>
</head>
<body>
    {{-- <p>BestB gửi bạn bản hợp đồng tương đầu tư tương đương với gói đầu tư {{$invest_type}} trị giá {{$amount}}</p>
    <div>
        Nếu bạn đồng ý với các điều khoản và không thay đổi về số tiền đầu tư vui lòng thực hiện ký hợp đồng và thanh toán tại đây
        <a href="{{$order_contract_url}}">{{$order_contract_url}}</a>
        <br>
        Hoặc truy cập tại mục <a href="{{asset('vi/transaction')}}">giao dịch</a> tại website
    </div> --}}
    <p>Thân chào Quý Nhà Đầu Tư <b>{{ $full_name }}</b>,</p>
    <p>Số biên lai: <b>{{ $order_id }}</b></p>
    <p>BestB Crowdfunding nhận được yêu cầu đầu tư dự án <b>{{$invest_name}}</b> từ bạn. Đính kèm email này chúng tôi gửi tới bạn hợp đồng mẫu.</p>
    <p>Bạn vui lòng kiểm tra lại nội dung hợp đồng, nếu đồng ý với nội dung hợp đồng này bạn có thể thực hiện chuyển khoản gói đầu tư <b>{{$amount}} VNĐ</b> của mình về:</p>
    <p><b>Số tài khoản: 0691000428760 tại Ngân hàng Ngoại Thương Việt Nam – Vietcombank chi nhánh Tây Hà Nội</b></p>
    <p><b>Chủ tài khoản: CÔNG TY CỔ PHẦN ĐẦU TƯ BESTB GROUP</b></p>
    <p><b>Nội dung chuyển khoản:</b> Họ và tên - dau tu - ten du an</p>
    <p>Lệnh chuyển khoản thành công số tiền đầu tư từ bạn về tài khoản Quỹ BestB vào ngày nào, hợp đồng sẽ được tính có hiệu lực từ ngày đó. Quỹ sẽ gửi bạn hợp đồng bản cứng trong vòng 3-7 ngày làm việc qua đường bưu điện.</p>
    <p><i>(Quý Nhà Đầu Tư vui lòng chụp ảnh màn hình chuyển khoản thành công hoặc biên lai chuyển tiền tại ngân hàng khi giao dịch - lưu ý các giao dịch ngoài giờ hành chính có khả năng ngân hàng đẩy thông tin giao dịch thành công sang ngày tiếp theo)</i></p>
    <p>Email này thay cho thông báo chính thức gửi tới Nhà Đầu Tư, hợp đồng kèm theo email này có hiệu lực kể từ ngày chúng tôi nhận được tiền từ tài khoản của bạn.</p>
    <p>Hợp đồng đính kèm email này có giá trị pháp lý tương đương hợp đồng bản cứng kể từ khi Nhà Đầu Tư hoàn thành nghĩa vụ đầu tư về Quỹ.</p>
    <p>Bạn có thể lựa chọn giao dịch trực tiếp tại văn phòng Quỹ bằng cách nhấn vào đây (<a href="{{ $payment_contact }}" target="_blank">tại đây</a> giao dịch viên của chúng tôi sẽ liên lạc hỗ trợ bạn hoàn thành giao dịch)</p>
    <p>Mọi thắc mắc xin liên hệ:</p>
    <p> &nbsp; &nbsp; &nbsp; Địa chỉ Hà Nội: <b>Tầng 6, 271 Quan Hoa, Cầu Giấy, Hà Nội</b></p>
    <p> &nbsp; &nbsp; &nbsp; Địa chỉ Hồ Chí Minh: <b>6 Võ Văn Kiệt - Phường Nguyễn Thái Bình - Q.1 - Tp.HCM</b></p>
    <p> &nbsp; &nbsp; &nbsp; Hotline: <b>0968 988 608</b></p>
    <p> &nbsp; &nbsp; &nbsp; Email: <b>bestb.capital@gmail.com</b></p>
    <br>
    <b>Trân trọng,​</b>
</body>
</html>
