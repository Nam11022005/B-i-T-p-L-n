<?php

namespace App\Http\Controllers;

class PolicyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHÍNH SÁCH GIAO HÀNG
    |--------------------------------------------------------------------------
    */

    public function shipping()
    {
        return view('policies.show', [
            'icon' => '🚚',

            'title' => 'Chính sách giao hàng',

            'subtitle' =>
                'Thông tin về phương thức vận chuyển, phí giao hàng và thời gian nhận hàng tại Tinh Hoa Tây Bắc.',

            'sections' => [
                [
                    'title' => '1. Phạm vi giao hàng',

                    'content' =>
                        'Tinh Hoa Tây Bắc hỗ trợ giao hàng trên toàn quốc. Khách hàng cần cung cấp đầy đủ họ tên, số điện thoại và địa chỉ nhận hàng chính xác để quá trình giao hàng được thuận lợi.',
                ],

                [
                    'title' => '2. Phương thức vận chuyển',

                    'content' =>
                        'Khách hàng có thể lựa chọn giao hàng tiêu chuẩn, giao hàng nhanh hoặc giao hàng hỏa tốc tùy theo khu vực và nhu cầu.',
                ],

                [
                    'title' => '3. Phí vận chuyển',

                    'content' =>
                        'Phí giao hàng được hiển thị trực tiếp tại trang thanh toán trước khi khách hàng xác nhận đặt hàng. Phí vận chuyển hiện gồm giao hàng tiêu chuẩn 25.000đ, giao hàng nhanh 35.000đ và giao hàng hỏa tốc 50.000đ.',
                ],

                [
                    'title' => '4. Thời gian giao hàng',

                    'content' =>
                        'Thời gian giao hàng phụ thuộc vào địa chỉ nhận hàng, phương thức vận chuyển và tình trạng xử lý đơn hàng.',
                ],

                [
                    'title' => '5. Theo dõi đơn hàng',

                    'content' =>
                        'Khách hàng đã đăng nhập có thể theo dõi trạng thái đơn hàng trong mục Đơn hàng của tôi. Các trạng thái bao gồm chờ xử lý, đã xác nhận, đang giao, đã giao hoặc đã hủy.',
                ],
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHÍNH SÁCH ĐỔI TRẢ
    |--------------------------------------------------------------------------
    */

    public function returns()
    {
        return view('policies.show', [
            'icon' => '🔄',

            'title' => 'Chính sách đổi trả',

            'subtitle' =>
                'Quy định hỗ trợ đổi trả sản phẩm nhằm bảo vệ quyền lợi của khách hàng khi mua sắm tại Tinh Hoa Tây Bắc.',

            'sections' => [
                [
                    'title' => '1. Trường hợp được hỗ trợ',

                    'content' =>
                        'Khách hàng có thể yêu cầu hỗ trợ nếu nhận sai sản phẩm, sản phẩm bị hư hỏng trong quá trình vận chuyển hoặc sản phẩm có vấn đề rõ ràng về chất lượng khi nhận hàng.',
                ],

                [
                    'title' => '2. Điều kiện đổi trả',

                    'content' =>
                        'Sản phẩm cần còn nguyên trạng, chưa qua sử dụng và khách hàng cần cung cấp thông tin đơn hàng cùng hình ảnh sản phẩm để cửa hàng kiểm tra.',
                ],

                [
                    'title' => '3. Thời gian yêu cầu',

                    'content' =>
                        'Khách hàng nên liên hệ với Tinh Hoa Tây Bắc ngay sau khi phát hiện vấn đề để được hỗ trợ nhanh nhất.',
                ],

                [
                    'title' => '4. Sản phẩm thực phẩm',

                    'content' =>
                        'Do đặc thù của các sản phẩm thực phẩm và đặc sản vùng miền, sản phẩm đã mở bao bì hoặc đã sử dụng có thể không được áp dụng đổi trả, trừ trường hợp xác định có lỗi từ phía cửa hàng.',
                ],

                [
                    'title' => '5. Liên hệ hỗ trợ',

                    'content' =>
                        'Khách hàng có thể liên hệ hotline 0385 742 505 hoặc Zalo của Tinh Hoa Tây Bắc để được hướng dẫn xử lý.',
                ],
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHÍNH SÁCH BẢO MẬT
    |--------------------------------------------------------------------------
    */

    public function privacy()
    {
        return view('policies.show', [
            'icon' => '🔒',

            'title' => 'Chính sách bảo mật',

            'subtitle' =>
                'Tinh Hoa Tây Bắc tôn trọng quyền riêng tư và bảo vệ thông tin cá nhân của khách hàng trong quá trình sử dụng website.',

            'sections' => [
                [
                    'title' => '1. Thông tin được thu thập',

                    'content' =>
                        'Hệ thống có thể lưu trữ họ tên, email, số điện thoại, địa chỉ giao hàng và các thông tin cần thiết để quản lý tài khoản cũng như xử lý đơn hàng.',
                ],

                [
                    'title' => '2. Mục đích sử dụng thông tin',

                    'content' =>
                        'Thông tin khách hàng được sử dụng để quản lý tài khoản, xác nhận đơn hàng, giao hàng, hỗ trợ khách hàng, xác thực tài khoản và cải thiện trải nghiệm sử dụng website.',
                ],

                [
                    'title' => '3. Bảo vệ tài khoản',

                    'content' =>
                        'Thông tin mật khẩu được hệ thống xử lý theo cơ chế bảo mật của Laravel. Khách hàng có trách nhiệm giữ bí mật thông tin đăng nhập và không cung cấp mật khẩu cho người khác.',
                ],

                [
                    'title' => '4. Thông tin thanh toán',

                    'content' =>
                        'Website chỉ sử dụng các thông tin cần thiết để xác nhận trạng thái thanh toán. Tinh Hoa Tây Bắc không yêu cầu khách hàng cung cấp mật khẩu tài khoản ngân hàng.',
                ],

                [
                    'title' => '5. Quyền của khách hàng',

                    'content' =>
                        'Khách hàng có thể cập nhật thông tin cá nhân, mật khẩu, ảnh đại diện và địa chỉ giao hàng thông qua khu vực tài khoản của mình.',
                ],
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ĐIỀU KHOẢN DỊCH VỤ
    |--------------------------------------------------------------------------
    */

    public function terms()
    {
        return view('policies.show', [
            'icon' => '📜',

            'title' => 'Điều khoản dịch vụ',

            'subtitle' =>
                'Các điều khoản áp dụng khi khách hàng truy cập website, sử dụng tài khoản và mua sản phẩm tại Tinh Hoa Tây Bắc.',

            'sections' => [
                [
                    'title' => '1. Tài khoản người dùng',

                    'content' =>
                        'Khách hàng cần cung cấp thông tin chính xác khi đăng ký tài khoản và chịu trách nhiệm bảo mật thông tin đăng nhập của mình.',
                ],

                [
                    'title' => '2. Đặt hàng',

                    'content' =>
                        'Đơn hàng được ghi nhận khi khách hàng hoàn tất quá trình đặt hàng. Thông tin đơn hàng và trạng thái xử lý sẽ được lưu trên hệ thống.',
                ],

                [
                    'title' => '3. Giá sản phẩm',

                    'content' =>
                        'Giá bán và giá khuyến mãi được hiển thị trên website tại thời điểm khách hàng đặt hàng. Giá khuyến mãi chỉ được áp dụng khi chương trình đang còn hiệu lực.',
                ],

                [
                    'title' => '4. Thanh toán',

                    'content' =>
                        'Khách hàng có thể thanh toán bằng hình thức COD hoặc chuyển khoản ngân hàng theo các lựa chọn được hệ thống cung cấp tại bước thanh toán.',
                ],

                [
                    'title' => '5. Trách nhiệm sử dụng',

                    'content' =>
                        'Người dùng không được sử dụng website vào mục đích gây ảnh hưởng đến hoạt động của hệ thống, gian lận đơn hàng hoặc xâm phạm quyền lợi của người dùng khác.',
                ],

                [
                    'title' => '6. Thay đổi điều khoản',

                    'content' =>
                        'Tinh Hoa Tây Bắc có thể điều chỉnh nội dung điều khoản khi cần thiết nhằm phù hợp với hoạt động của website. Phiên bản mới sẽ được công bố trực tiếp trên trang này.',
                ],
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHÍNH SÁCH THANH TOÁN
    |--------------------------------------------------------------------------
    */

    public function payment()
    {
        return view('policies.show', [
            'icon' => '💳',

            'title' => 'Chính sách thanh toán',

            'subtitle' =>
                'Thông tin về các phương thức thanh toán được hỗ trợ khi mua hàng tại Tinh Hoa Tây Bắc.',

            'sections' => [
                [
                    'title' => '1. Thanh toán khi nhận hàng (COD)',

                    'content' =>
                        'Khách hàng có thể lựa chọn COD và thanh toán cho đơn vị vận chuyển khi nhận được sản phẩm.',
                ],

                [
                    'title' => '2. Chuyển khoản ngân hàng',

                    'content' =>
                        'Khách hàng có thể lựa chọn phương thức chuyển khoản ngân hàng tại bước thanh toán và thực hiện chuyển khoản theo thông tin của đơn hàng.',
                ],

                [
                    'title' => '3. Thông tin chuyển khoản',

                    'content' =>
                        'Ngân hàng MB BANK - Chủ tài khoản: ĐỖ PHƯƠNG NAM - Số tài khoản: 0385742505.',
                ],

                [
                    'title' => '4. Nội dung chuyển khoản',

                    'content' =>
                        'Khách hàng cần nhập đúng nội dung hoặc mã thanh toán được hiển thị trên đơn hàng để hệ thống có thể xác định giao dịch chính xác.',
                ],

                [
                    'title' => '5. Xác nhận thanh toán',

                    'content' =>
                        'Đối với đơn hàng chuyển khoản, hệ thống có thể tự động tiếp nhận thông tin giao dịch thông qua hệ thống xác nhận thanh toán và cập nhật trạng thái đơn hàng khi giao dịch hợp lệ.',
                ],
            ],
        ]);
    }
}