
@include('clients.blocks.header')
@include('clients.blocks.banner')

@php
    /*
     * Lấy ảnh đầu tiên một cách an toàn.
     * Hỗ trợ Collection, mảng và chuỗi JSON.
     */
    $getFirstTourImage = function ($images) {
        if ($images instanceof \Illuminate\Support\Collection) {
            $images = $images->values()->all();
        } elseif (is_string($images)) {
            $decoded = json_decode($images, true);
            $images = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($images)) {
            return null;
        }

        $firstImage = $images[0] ?? null;

        if (is_array($firstImage)) {
            $firstImage = $firstImage['imageUrl'] ?? $firstImage['image'] ?? null;
        }

        return is_string($firstImage) && trim($firstImage) !== ''
            ? trim($firstImage)
            : null;
    };

    // Đường dẫn ảnh dự phòng. Hãy bảo đảm file này tồn tại.
    $defaultTourImage = asset('clients/assets/images/about/about.png');
@endphp

<!-- Tour List Area start -->
<section class="tour-list-page py-100 rel z-1">
    <div class="container">
        <div class="row">

            <!-- Sidebar: Tours phổ biến -->
            <div class="col-lg-3 col-md-6 col-sm-10 rmb-75">
                <div class="shop-sidebar mb-30">

                    @if (isset($toursPopular) && !$toursPopular->isEmpty())
                        <div class="widget widget-tour"
                            data-aos="fade-up"
                            data-aos-duration="1500"
                            data-aos-offset="50">

                            <h6 class="widget-title">Tour phổ biến</h6>

                            @foreach ($toursPopular as $popularTour)
                                @php
                                    $popularImage = $getFirstTourImage($popularTour->images ?? []);
                                @endphp

                                <div class="destination-item tour-grid style-three bgc-lighter">
                                    <div class="image">
                                        <img
                                            src="{{ $popularImage ? asset('admin/assets/images/gallery-tours/' . $popularImage) : $defaultTourImage }}"
                                            alt="{{ $popularTour->title ?? 'Tour' }}"
                                            onerror="this.onerror=null; this.src='{{ $defaultTourImage }}';">
                                    </div>

                                    <div class="content">
                                        <div class="destination-header">
                                            <span class="location">
                                                <i class="fal fa-map-marker-alt"></i>
                                                {{ $popularTour->destination ?? '' }}
                                            </span>

                                            <div class="ratting">
                                                <i class="fas fa-star"></i>
                                                <span>{{ $popularTour->rating ?? 0 }}</span>
                                            </div>
                                        </div>

                                        <h6>
                                            <a href="{{ route('tour-detail', ['id' => $popularTour->tourId]) }}">
                                                {{ $popularTour->title ?? 'Tour' }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

            <!-- Danh sách tour đã đặt -->
            <div class="col-lg-9">

                @forelse ($myTours as $tour)
                    @php
                        $tourImage = $getFirstTourImage($tour->images ?? []);
                    @endphp

                    <div class="destination-item style-three bgc-lighter"
                        data-aos="fade-up"
                        data-aos-duration="1500"
                        data-aos-offset="50">

                        <div class="image">

                            @if ($tour->bookingStatus == 'b')
                                <span class="badge">Đợi xác nhận</span>
                            @elseif ($tour->bookingStatus == 'y')
                                <span class="badge bgc-pink">Sắp khởi hành</span>
                            @elseif ($tour->bookingStatus == 'f')
                                <span class="badge bgc-primary">Hoàn thành</span>
                            @elseif ($tour->bookingStatus == 'c')
                                <span class="badge" style="background-color: red">
                                    Đã hủy
                                </span>
                            @endif

                            <img
                                src="{{ $tourImage ? asset('admin/assets/images/gallery-tours/' . $tourImage) : $defaultTourImage }}"
                                alt="{{ $tour->title ?? 'Tour đã đặt' }}"
                                onerror="this.onerror=null; this.src='{{ $defaultTourImage }}';">
                        </div>

                        <div class="content">

                            <div class="destination-header">
                                <span class="location">
                                    <i class="fal fa-map-marker-alt"></i>
                                    {{ $tour->destination ?? '' }}
                                </span>

                                <div class="ratting">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if (!empty($tour->rating) && $i < $tour->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <h5>
                                <a href="{{ route('tour-booked', [
                                    'bookingId' => $tour->bookingId,
                                    'checkoutId' => $tour->checkoutId
                                ]) }}">
                                    {{ $tour->title ?? 'Tour đã đặt' }}
                                </a>
                            </h5>

                            <div class="truncate-3-lines">
                                {!! $tour->description ?? '' !!}
                            </div>

                            <ul class="blog-meta">
                                <li>
                                    <i class="far fa-clock"></i>
                                    {{ $tour->time ?? '' }}
                                </li>
                                <li>
                                    <i class="far fa-user"></i>
                                    {{ ($tour->numAdults ?? 0) + ($tour->numChildren ?? 0) }} người
                                </li>
                            </ul>

                            <div class="destination-footer">
                                <span class="price">
                                    <span>{{ number_format($tour->totalPrice ?? 0, 0, ',', '.') }}</span>/VNĐ
                                </span>

                                @if ($tour->bookingStatus == 'f')
                                    <a href="{{ route('tour-detail', ['id' => $tour->tourId]) }}"
                                        class="theme-btn style-two style-three">

                                        @if (!empty($tour->rating))
                                            <span data-hover="Đã đánh giá">Đã đánh giá</span>
                                        @else
                                            <span data-hover="Đánh giá">Đánh giá</span>
                                        @endif

                                        <i class="fal fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="alert alert-info">
                        Bạn chưa đặt tour nào.
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</section>
<!-- Tour List Area end -->

@include('clients.blocks.footer')
