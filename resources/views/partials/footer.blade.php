<footer class="footer-custom">
    <div class="container">
        <div class="row gy-4 align-items-start">
            {{-- logo dan alamat --}}
            <div class="col-lg-5 col-md-6 footer-info-col">
                <div class="footer-logo mb-2">
                    <a class="d-flex align-items-center" href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo HikmalAir" width="36" height="36" class="me-3">
                    </a>
                </div>
                <div class="footer-address ps-3" style="border-left: 3px solid #ffffff; height: 80px;">
                    <p class="fw-bold fs-5">HikmalAir</p>
                    <p>Jl. Ketintang, Kec. Gayungan</p>
                    <p>Kota Surabaya, Jawa Timur, Indonesia 60231</p>
                </div>
            </div>

            {{-- cs--}}
            <div class="col-lg-4 col-md-6 footer-links-col">
                <h5 class="footer-title">Customer Care</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">FAQ / Bantuan</a></li>
                    <li><a href="#">Tentang HikmalAir</a></li>
                </ul>
            </div>

            {{-- sosmed --}}
            <div class="col-lg-3 col-md-12 footer-social-col"> {{-- Kamu pakai col-lg-3 di sini, sebelumnya col-lg-4 --}}
                <h5 class="footer-title">Follow Sosial Media HikmalAir</h5>
                <div class="social-icons mt-3">
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-2"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-2"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter-x fs-2"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-youtube fs-2"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- copyright --}}
    <div class="footer-bottom text-center py-3 mt-4">
        <small>&copy; {{ date('Y') }} HikmalAir. All Rights Reserved.</small>
    </div>
</footer>
