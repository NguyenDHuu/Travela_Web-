@include('clients.blocks.header')
@include('clients.blocks.banner')

<!-- Popular Destinations Area start -->
<section class="popular-destinations-area pt-100 pb-90 rel z-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-title text-center counter-text-wrap mb-40"
                    data-aos="fade-up"
                    data-aos-duration="1500"
                    data-aos-offset="50">

                    <h2>Khám phá các điểm đến phổ biến</h2>

                    <p>
                        Website
                        <span class="count-text plus"
                            data-speed="3000"
                            data-stop="34500">0</span>
                        trải nghiệm phổ biến nhất mà bạn sẽ nhớ
                    </p>

                    <ul class="destinations-nav mt-30">
                        <li data-filter="*" class="active">Tất cả</li>
                        <li data-filter=".domain-b">Miền Bắc</li>
                        <li data-filter=".domain-t">Miền Trung</li>
                        <li data-filter=".domain-n">Miền Nam</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row gap-10 destinations-active justify-content-center">

                @php
                    $count = 0;
                @endphp

                @forelse ($tours as $tour)

                    @php
                        // Lấy dữ liệu ảnh của tour
                        $images = $tour->images;

                        // Chuyển JSON thành mảng nếu cần
                        if (is_string($images)) {
                            $images = json_decode($images, true);
                        }

                        // Lấy ảnh đầu tiên nếu có
                        $firstImage = is_array($images)
                            ? ($images[0] ?? null)
                            : null;

                        // Ảnh dự phòng khi tour chưa có ảnh
                        $imagePath = !empty($firstImage)
                            ? asset('admin/assets/images/gallery-tours/' . $firstImage)
                            : asset('clients/assets/images/about/about.png');

                        // Xác định khu vực để lọc
                        $domain = $tour->domain ?? '';
                    @endphp

                    @if ($count % 3 == 2)
                        <div class="col-md-6 item domain-{{ $domain }}">
                    @else
                        <div class="col-xl-3 col-md-6 item domain-{{ $domain }}">
                    @endif

                        <div class="destination-item style-two"
                            data-aos="fade-up"
                            data-aos-duration="1500"
                            data-aos-offset="50">

                            <div class="image" style="max-height: 250px; overflow: hidden;">
                                <a href="#" class="heart">
                                    <i class="fas fa-heart"></i>
                                </a>

                                <img
                                    src="{{ $imagePath }}"
                                    alt="{{ $tour->title ?? 'Destination' }}"
                                    style="width: 100%; height: 250px; object-fit: cover;">
                            </div>

                            <div class="content">
                                <h6 class="tour-title">
                                    <a href="{{ route('tour-detail', ['id' => $tour->tourId]) }}">
                                        {{ $tour->title }}
                                    </a>
                                </h6>

                                <span class="time">
                                    {{ $tour->time }}
                                </span>

                                <a href="{{ route('tour-detail', ['id' => $tour->tourId]) }}"
                                    class="more">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                    @php
                        $count++;
                    @endphp

                @empty

                    <div class="col-12 text-center">
                        <p>Hiện tại chưa có tour du lịch nào.</p>
                    </div>

                @endforelse

            </div>
        </div>
    </div>
</section>
<!-- Popular Destinations Area end -->

@include('clients.blocks.new_letter')
@include('clients.blocks.footer')
```
