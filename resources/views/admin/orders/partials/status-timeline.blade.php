<style>

    .order-timeline {
        position: relative;
        padding-left: 8px;
    }


    .timeline-item {
        position: relative;
        display: flex;
        gap: 18px;
        padding-bottom: 28px;
    }


    .timeline-item:last-child {
        padding-bottom: 0;
    }


    .timeline-marker-wrap {
        position: relative;
        width: 46px;
        min-width: 46px;
        display: flex;
        justify-content: center;
    }


    .timeline-marker {
        width: 42px;
        height: 42px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 19px;

        z-index: 2;

        border: 3px solid white;

        box-shadow:
            0 3px 12px
            rgba(0,0,0,.12);
    }


    .timeline-line {
        position: absolute;

        top: 42px;
        bottom: -28px;

        width: 3px;

        background:
            #ead8bf;
    }


    .timeline-item:last-child
    .timeline-line {
        display: none;
    }


    .timeline-content {
        flex: 1;

        border:
            1px solid #ead8bf;

        background:
            #fffaf0;

        border-radius: 14px;

        padding:
            14px 16px;
    }


    .timeline-title {
        font-weight: 800;

        color:
            #2c1810;
    }


    .timeline-date {
        font-size: 13px;

        color:
            #88786c;
    }


    .timeline-note {
        margin-top: 5px;

        color:
            #66584f;
    }


    .timeline-user {
        margin-top: 7px;

        font-size: 13px;

        color:
            #8a7568;
    }


    .timeline-pending {
        background:
            #fff3cd;

        color:
            #856404;
    }


    .timeline-confirmed {
        background:
            #dbeafe;

        color:
            #1d4ed8;
    }


    .timeline-shipped {
        background:
            #e0e7ff;

        color:
            #4338ca;
    }


    .timeline-delivered {
        background:
            #dcfce7;

        color:
            #166534;
    }


    .timeline-cancelled {
        background:
            #fee2e2;

        color:
            #991b1b;
    }

</style>


<div
    class="
        card
        border-0
        shadow-sm
        rounded-4
        mb-4
    "
>

    <div
        class="
            card-header
            bg-white
            py-3
        "
    >

        <h5
            class="
                fw-bold
                mb-0
            "
            style="
                color:#2c1810;
            "
        >
            • Lịch sử trạng thái đơn hàng
        </h5>

    </div>


    <div
        class="
            card-body
            p-4
        "
    >


        @if(
            $order
                ->statusHistories
                ->count()
            > 0
        )


            <div
                class="
                    order-timeline
                "
            >


                @foreach(
                    $order->statusHistories
                    as
                    $history
                )


                    @php

                        $icon =
                            match(
                                $history->status
                            ) {

                                'pending'
                                =>
                                '⏳',

                                'confirmed'
                                =>
                                '✓',

                                'shipped'
                                =>
                                '🚚',

                                'delivered'
                                =>
                                '✅',

                                'cancelled'
                                =>
                                '❌',

                                default
                                =>
                                '📦',

                            };


                        $statusClass =
                            match(
                                $history->status
                            ) {

                                'pending'
                                =>
                                'timeline-pending',

                                'confirmed'
                                =>
                                'timeline-confirmed',

                                'shipped'
                                =>
                                'timeline-shipped',

                                'delivered'
                                =>
                                'timeline-delivered',

                                'cancelled'
                                =>
                                'timeline-cancelled',

                                default
                                =>
                                'timeline-pending',

                            };

                    @endphp


                    <div
                        class="
                            timeline-item
                        "
                    >


                        <div
                            class="
                                timeline-marker-wrap
                            "
                        >

                            <div
                                class="
                                    timeline-marker
                                    {{ $statusClass }}
                                "
                            >

                                {{ $icon }}

                            </div>


                            <div
                                class="
                                    timeline-line
                                "
                            >
                            </div>

                        </div>



                        <div
                            class="
                                timeline-content
                            "
                        >


                            <div
                                class="
                                    d-flex
                                    justify-content-between
                                    align-items-start
                                    flex-wrap
                                    gap-2
                                "
                            >


                                <div
                                    class="
                                        timeline-title
                                    "
                                >

                                    {{
                                        $history->title
                                        ??
                                        'Cập nhật trạng thái'
                                    }}

                                </div>


                                <div
                                    class="
                                        timeline-date
                                    "
                                >

                                    {{
                                        $history
                                            ->created_at
                                            ->format(
                                                'd/m/Y H:i'
                                            )
                                    }}

                                </div>

                            </div>



                            @if(
                                $history->note
                            )

                                <div
                                    class="
                                        timeline-note
                                    "
                                >

                                    {{
                                        $history->note
                                    }}

                                </div>

                            @endif



                            <div
                                class="
                                    timeline-user
                                "
                            >

                                •

                                @if(
                                    $history->user
                                )

                                    {{
                                        $history
                                            ->user
                                            ->name
                                    }}

                                @else

                                    Hệ thống

                                @endif

                            </div>

                        </div>

                    </div>


                @endforeach


            </div>


        @else


            <div
                class="
                    text-center
                    py-4
                "
            >

                <div
                    style="
                        font-size:45px;
                    "
                >

                    •

                </div>


                <div
                    class="
                        fw-bold
                        mt-2
                    "
                >

                    Chưa có lịch sử trạng thái

                </div>


                <small
                    class="
                        text-muted
                    "
                >

                    Các lần thay đổi trạng thái
                    sẽ xuất hiện tại đây.

                </small>

            </div>


        @endif


    </div>

</div>