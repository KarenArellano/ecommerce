<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-content d-flex align-items-center justify-content-between">
                    <!-- Copywrite Text -->
                    <div class="copywrite-text flex-grow-1">
                        <p>
                            {!! __('Desarrollado por <a href=":site" target="_blank">:company</a>', [
                            'site' => 'http://asta.com.mx',
                            'company' => 'ASTA Software'
                            ]) !!}
                        </p>
                        
                    </div>

                    <div class="copywrite-text flex-grow-1">
                         <p>{{ __("DISCOS DUROS PARA DJ'S") }}</p>
                    </div>

                    <!-- Footer Logo -->
                    <div class="footer-logo mr-5">
                        <a href="{{ url('/') }}">
                            <!-- <img src=" {{ url('landing/images/name-records.png') }}" alt="{{ config('app.name') }}" style="width: 115px;height: 25px;"> -->
                            <p>Lady Records</p>
                        </a>
                    </div>

                    <!-- Social Info -->
                    <div class="social-info">
                        <a href="https://www.facebook.com/LadyRecords" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <!-- <a href="#" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a> -->
                        <a href="https://www.instagram.com/lady_records/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>