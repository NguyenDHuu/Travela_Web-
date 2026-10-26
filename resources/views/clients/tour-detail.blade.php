@include('clients.blocks.header')

<section class="page-banner-two rel z-1">
    <div class="container-fluid">
        <hr class="mt-0">
        <div class="container">
            <div class="banner-inner pt-15 pb-25">
                <h2 class="page-title mb-10 aos-init aos-animate"
                    data-aos="fade-left"
                    data-aos-duration="1500"
                    data-aos-offset="50">
                    {{ $tourDetail->destination }}
                </h2>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-20 aos-init aos-animate"
                        data-aos="fade-right"
                        data-aos-delay="200"
                        data-aos-duration="1500"
                        data-aos-offset="50">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $title }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

{{-- Tour Gallery --}}
@php
    $images = $tourDetail->images ?? [];

    if (is_string($images)) {
        $decodedImages = json_decode($images, true);
        $images = is_array($decodedImages) ? $decodedImages : [];
    }

    if (!is_array($images)) {
        $images = [];
    }

    $images = array_values(array_filter($images, function ($image) {
        return is_string($image) && trim($image) !== '';
    }));

    $recommendations = $tourRecommendations ?? [];
@endphp

<div class="tour-gallery">
    <div class="container-fluid">
        <div class="row gap-10 justify-content-center rel">

            @if (count($images) > 0)
                <div class="col-lg-4 col-md-6">
                    @foreach (array_slice($images, 0, 2) as $image)
                        <div class="gallery-item">
                            <img
                                src="{{ asset('admin/assets/images/gallery-tours/' . $image) }}"
                                alt="{{ $tourDetail->title }}"
                                onerror="this.style.display='none';"
                            >
                        </div>
                    @endforeach
                </div>
            @endif

            @if (isset($images[2]))
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item gallery-between">
                        <img
                            src="{{ asset('admin/assets/images/gallery-tours/' . $images[2]) }}"
                            alt="{{ $tourDetail->title }}"
                            onerror="this.style.display='none';"
                        >
                    </div>
                </div>
            @endif

            @if (isset($images[3]) || isset($images[4]))
                <div class="col-lg-4 col-md-6">
                    @foreach (array_slice($images, 3, 2) as $image)
                        <div class="gallery-item">
                            <img
                                src="{{ asset('admin/assets/images/gallery-tours/' . $image) }}"
                                alt="{{ $tourDetail->title }}"
                                onerror="this.style.display='none';"
                            >
                        </div>
                    @endforeach
                </div>
            @endif

            @if (count($images) === 0)
                <div class="col-12 text-center py-4">
                    <p>Tour này hiện chưa có hình ảnh.</p>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Tour Header --}}
<section class="tour-header-area pt-70 rel z-1">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-6 col-lg-7">
                <div class="tour-header-content mb-15"
                    data-aos="fade-left"
                    data-aos-duration="1500"
                    data-aos-offset="50">

                    <span class="location d-inline-block mb-10">
                        <i class="fal fa-map-marker-alt"></i>
                        {{ $tourDetail->destination }}
                    </span>

                    <div class="section-title pb-5">
                        <h2>{{ $tourDetail->title }}</h2>
                    </div>

                    <div class="ratting">
                        @for ($i = 0; $i < 5; $i++)
                            @if (!empty($avgStar) && $i < $avgStar)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 text-lg-end"
                data-aos="fade-right"
                data-aos-duration="1500"
                data-aos-offset="50">
                <div class="tour-header-social mb-10">
                    <a href="#">
                        <i class="far fa-share-alt"></i> Share tours
                    </a>
                    <a href="#">
                        <i class="fas fa-heart bgc-secondary"></i> Wish list
                    </a>
                </div>
            </div>
        </div>

        <hr class="mt-50 mb-70">
    </div>
</section>

{{-- Tour Details --}}
<section class="tour-details-page pb-100">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                <div class="tour-details-content">
                    <h3>Khám phá Tours</h3>
                    <p>{!! $tourDetail->description !!}</p>

                    <div class="row pb-55">
                        <div class="col-md-6">
                            <div class="tour-include-exclude mt-30">
                                <h5>Bao gồm và không bao gồm</h5>

                                <ul class="list-style-one check mt-25">
                                    <li><i class="far fa-check"></i> Dịch vụ đón và trả khách</li>
                                    <li><i class="far fa-check"></i> 1 bữa ăn mỗi ngày</li>
                                    <li><i class="far fa-check"></i> Bữa tối trên du thuyền & Sự kiện âm nhạc</li>
                                    <li><i class="far fa-check"></i> Tham quan 7 địa điểm tuyệt vời nhất trong thành phố</li>
                                    <li><i class="far fa-check"></i> Nước đóng chai trên xe buýt</li>
                                    <li><i class="far fa-check"></i> Phương tiện di chuyển Xe buýt du lịch hạng sang</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="tour-include-exclude mt-30">
                                <h5>Không bao gồm</h5>

                                <ul class="list-style-one mt-25">
                                    <li><i class="far fa-times"></i> Tiền boa</li>
                                    <li><i class="far fa-times"></i> Đón và trả khách tại khách sạn</li>
                                    <li><i class="far fa-times"></i> Bữa trưa, Đồ ăn & Đồ uống</li>
                                    <li><i class="far fa-times"></i> Nâng cấp tùy chọn lên một ly</li>
                                    <li><i class="far fa-times"></i> Dịch vụ bổ sung</li>
                                    <li><i class="far fa-times"></i> Bảo hiểm</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lịch trình --}}
                <h3>Lịch trình</h3>

                <div class="accordion-two mt-25 mb-60" id="faq-accordion-two">
                    @php
                        $day = 1;
                    @endphp

                    @forelse (($tourDetail->timeline ?? []) as $timeline)
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo{{ $timeline->timeLineId }}"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo{{ $timeline->timeLineId }}">
                                    Ngày {{ $day++ }} - {{ $timeline->title }}
                                </button>
                            </h5>

                            <div
                                id="collapseTwo{{ $timeline->timeLineId }}"
                                class="accordion-collapse collapse"
                                data-bs-parent="#faq-accordion-two">
                                <div class="accordion-body">
                                    <p>{!! $timeline->description !!}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Chưa có thông tin lịch trình cho tour này.</p>
                    @endforelse
                </div>

                {{-- Đánh giá --}}
                <div id="partials_reviews">
                    @include('clients.partials.reviews')
                </div>

                <h3 class="{{ $checkDisplay ?? '' }}">Thêm Đánh giá</h3>

                <form
                    id="comment-form"
                    class="comment-form bgc-lighter z-1 rel mt-30 {{ $checkDisplay ?? '' }}"
                    name="review-form"
                    action="{{ route('reviews') }}"
                    method="POST"
                    data-aos="fade-up"
                    data-aos-duration="1500"
                    data-aos-offset="50">

                    @csrf

                    <div class="comment-review-wrap">
                        <div class="comment-ratting-item">
                            <span class="title">Đánh giá</span>

                            <div class="ratting" id="rating-stars">
                                <i class="far fa-star" data-value="1"></i>
                                <i class="far fa-star" data-value="2"></i>
                                <i class="far fa-star" data-value="3"></i>
                                <i class="far fa-star" data-value="4"></i>
                                <i class="far fa-star" data-value="5"></i>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-30 mb-40">

                    <h5>Để lại phản hồi</h5>

                    <div class="row gap-20 mt-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message">Nội dung</label>
                                <textarea
                                    name="message"
                                    id="message"
                                    class="form-control"
                                    rows="5"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <button
                                    type="submit"
                                    class="theme-btn bgc-secondary style-two"
                                    id="submit-reviews"
                                    data-url-checkBooking="{{ route('checkBooking') }}"
                                    data-tourId-reviews="{{ $tourDetail->tourId }}">
                                    <span data-hover="Gửi đánh giá">Gửi đánh giá</span>
                                    <i class="fal fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4 col-md-8 col-sm-10 rmt-75">
                <div class="blog-sidebar tour-sidebar">

                    {{-- Đặt tour --}}
                    <div class="widget widget-booking"
                        data-aos="fade-up"
                        data-aos-duration="1500"
                        data-aos-offset="50">

                        <h5 class="widget-title">Tour Booking</h5>

                        <form action="{{ route('booking', ['id' => $tourDetail->tourId]) }}" method="POST">
                            @csrf

                            <div class="date mb-25">
                                <b>Ngày bắt đầu</b>
                                <input
                                    type="text"
                                    value="{{ $tourDetail->startDate ? date('d-m-Y', strtotime($tourDetail->startDate)) : '' }}"
                                    disabled>
                            </div>

                            <hr>

                            <div class="date mb-25">
                                <b>Ngày kết thúc</b>
                                <input
                                    type="text"
                                    value="{{ $tourDetail->endDate ? date('d-m-Y', strtotime($tourDetail->endDate)) : '' }}"
                                    disabled>
                            </div>

                            <hr>

                            <div class="time py-5">
                                <b>Thời gian:</b>
                                <p>{{ $tourDetail->time }}</p>
                                <input type="hidden" name="time" value="{{ $tourDetail->time }}">
                            </div>

                            <hr class="mb-25">

                            <h6>Vé:</h6>

                            <ul class="tickets clearfix">
                                <li>
                                    Người lớn
                                    <span class="price">
                                        {{ number_format($tourDetail->priceAdult, 0, ',', '.') }} VND
                                    </span>
                                </li>

                                <li>
                                    Trẻ em
                                    <span class="price">
                                        {{ number_format($tourDetail->priceChild, 0, ',', '.') }} VND
                                    </span>
                                </li>
                            </ul>

                            <button type="submit" class="theme-btn style-two w-100 mt-15 mb-5">
                                <span data-hover="Đặt ngay">Đặt ngay</span>
                                <i class="fal fa-arrow-right"></i>
                            </button>

                            <div class="text-center">
                                <a href="{{ route('contact') }}">Bạn cần trợ giúp không?</a>
                            </div>
                        </form>
                    </div>

                    {{-- Thông tin liên hệ --}}
                    <div class="widget widget-contact"
                        data-aos="fade-up"
                        data-aos-duration="1500"
                        data-aos-offset="50">

                        <h5 class="widget-title">Cần trợ giúp?</h5>

                        <ul class="list-style-one">
                            <li>
                                <i class="far fa-envelope"></i>
                                <a href="mailto:23010238@gmail.com">23010238@gmail.com</a>
                            </li>
                            <li>
                                <i class="far fa-phone-volume"></i>
                                <a href="tel:0368693261">0368693261</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Tour tương tự --}}
                    @if (count($recommendations) > 0)
                        <div class="widget widget-tour"
                            data-aos="fade-up"
                            data-aos-duration="1500"
                            data-aos-offset="50">

                            <h6 class="widget-title">Tours tương tự</h6>

                            @foreach ($recommendations as $tour)
                                @php
                                    $recommendationImages = $tour->images ?? [];

                                    if (is_string($recommendationImages)) {
                                        $decoded = json_decode($recommendationImages, true);
                                        $recommendationImages = is_array($decoded) ? $decoded : [];
                                    }

                                    if (!is_array($recommendationImages)) {
                                        $recommendationImages = [];
                                    }

                                    $recommendationImage = $recommendationImages[0] ?? null;
                                @endphp

                                <div class="destination-item tour-grid style-three bgc-lighter">
                                    <div class="image">
                                        @if ($recommendationImage)
                                            <img
                                                src="{{ asset('admin/assets/images/gallery-tours/' . $recommendationImage) }}"
                                                alt="{{ $tour->title }}"
                                                style="max-height: 137px"
                                                onerror="this.style.display='none';">
                                        @else
                                            <div class="p-3 text-center">
                                                <span>Chưa có hình ảnh</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="content">
                                        <div class="destination-header">
                                            <span class="location">
                                                <i class="fal fa-map-marker-alt"></i>
                                                {{ $tour->destination }}
                                            </span>

                                            <div class="ratting">
                                                <i class="fas fa-star"></i>
                                                <span>({{ $tour->rating ?? 0 }})</span>
                                            </div>
                                        </div>

                                        <h6>
                                            <a href="{{ route('tour-detail', ['id' => $tour->tourId]) }}">
                                                {{ $tour->title }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>

@include('clients.blocks.new_letter')
@include('clients.blocks.footer')