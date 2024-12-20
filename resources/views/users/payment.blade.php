@extends('layoutUser.layout')

@section('title', 'Thanh Toán')

@section('content')
<main>
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <h1>Thanh Toán</h1>
            <p>Hãy xác nhận thông tin và thanh toán đơn hàng của bạn.</p>
        </div>
    </div>

    <div class="container">
        <ul class="page-banner-list">
            <li><a href="#">Trang chủ</a></li>
            <i class="fas fa-chevron-right"></i>
            <li><a href="#">Thanh Toán</a></li>
        </ul>
    </div>

    <div id="payment">
        <div class="payment-summary">
            <div class="container">
                <h2 class="text-center mb-4">Thông tin đơn hàng</h2>

                <!-- Hiển thị các món đã chọn -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên Món</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0) }} VND</td>
                            <td>{{ number_format($item->quantity * $item->price, 0) }} VND</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Hiển thị tổng tiền -->
                <div class="text-end mb-4">
                    <h4>Tổng Tiền: {{ number_format($totalAmount, 0) }} VND</h4>
                </div>

                <!-- Form thanh toán -->
                <h3>Thông tin thanh toán</h3>
                <form action="{{ route('payment.confirm', $booking->id) }}" method="POST">
                    @csrf

                    <!-- Lựa chọn phương thức thanh toán -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Chọn phương thức thanh toán</label>
                        <select name="paymentMethod" id="paymentMethod" class="form-select" required>
                            <option value="" disabled selected>Chọn phương thức thanh toán</option>
                            <option value="credit_card">Thẻ tín dụng</option>
                            <option value="e_wallet">Ví điện tử (Momo, ZaloPay, v.v.)</option>
                            <option value="cash_on_delivery">Thanh toán khi nhận hàng</option>
                        </select>
                    </div>

                    <!-- Các trường thông tin thanh toán (dành cho phương thức thẻ tín dụng) -->
                    <div id="creditCardFields" style="display: none;">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Số thẻ</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber">
                        </div>
                        <div class="mb-3">
                            <label for="expiryDate" class="form-label">Ngày hết hạn</label>
                            <input type="text" class="form-control" id="expiryDate" name="expiryDate">
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv">
                        </div>
                    </div>

                    <!-- Các trường thông tin thanh toán (dành cho ví điện tử) -->
                    <div id="eWalletFields" style="display: none;">
                        <div class="mb-3">
                            <label for="walletNumber" class="form-label">Số ví điện tử</label>
                            <input type="text" class="form-control" id="walletNumber" name="walletNumber">
                        </div>
                    </div>

                    <!-- Nút thanh toán -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Xác Nhận Thanh Toán</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    // JavaScript để hiển thị trường thông tin thanh toán tương ứng với phương thức đã chọn
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const paymentMethod = this.value;
        const creditCardFields = document.getElementById('creditCardFields');
        const eWalletFields = document.getElementById('eWalletFields');
        
        if (paymentMethod === 'credit_card') {
            creditCardFields.style.display = 'block';
            eWalletFields.style.display = 'none';
        } else if (paymentMethod === 'e_wallet') {
            creditCardFields.style.display = 'none';
            eWalletFields.style.display = 'block';
        } else {
            creditCardFields.style.display = 'none';
            eWalletFields.style.display = 'none';
        }
    });
</script>
@endsection
