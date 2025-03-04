@props(['address'])

<div class="row mt-3">
    <div class="col-md-12">
        <div class="address-card">
            <div class="address-card__header">
                <div class="address-card__badge">
                    <svg class="address-svg-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Default Address
                </div>
                <h5 class="address-card__name">{{ $address->name }}</h5>
            </div>
            <div class="address-card__body">
                <div class="address-card__icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="address-card__content">
                    <div class="address-card__details">
                        <p class="address-card__line">{{ $address->address }}</p>
                        <p class="address-card__line">{{ $address->landmark }}</p>
                        <p class="address-card__line">{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                        <p class="address-card__line">
                            <svg class="address-zip-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M5 8H19M5 8C3.89543 8 3 7.10457 3 6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6C21 7.10457 20.1046 8 19 8M5 8L5 18C5 19.1046 5.89543 20 7 20H17C18.1046 20 19 19.1046 19 18V8M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="zip-code">{{ $address->zip }}</span>
                        </p>
                    </div>
                    <div class="address-card__divider">
                        <svg class="divider-svg" viewBox="0 0 100 2" preserveAspectRatio="none">
                            <line x1="0" y1="1" x2="100" y2="1" vector-effect="non-scaling-stroke" />
                        </svg>
                    </div>
                    <div class="address-card__contact">
                        <svg class="address-phone-icon" viewBox="0 0 24 24" fill="none">
                            <path d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9286C16.2985 13.7716 16.0777 13.6932 15.8683 13.7159C15.6836 13.7357 15.5059 13.8105 15.3549 13.9331C15.1837 14.0723 15.0629 14.3046 14.8212 14.7693L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.25 9.16667C9.71524 8.92430 9.94786 8.80312 10.087 8.63189C10.2093 8.48016 10.2842 8.30138 10.3041 8.11546C10.3269 7.90474 10.2476 7.68286 10.089 7.23907L8.90138 4.02316C8.76425 3.64421 8.69569 3.45473 8.57418 3.31481C8.46736 3.19204 8.33043 3.09683 8.17753 3.03865C8.00543 2.97314 7.80338 2.97314 7.39929 2.97314H4.56201C4.08183 2.97314 3.84174 2.97314 3.63648 3.07162C3.46538 3.15447 3.29934 3.30932 3.20487 3.47388C3.09084 3.67262 3.07542 3.88962 3.04458 4.32361C3.01509 4.70278 3 5.09575 3 5.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $address->phone }}</span>
                    </div>
                </div>
            </div>
            <div class="address-card__footer">
                <a href="{{ route('user.index', ['tab' => 'address']) }}" class="address-edit-btn">
                    <svg class="edit-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M11 5H6C4.89543 5 4 5.89543 4 7V18C4 19.1046 4.89543 20 6 20H17C18.1046 20 19 19.1046 19 18V13M17.5858 3.58579C18.3668 2.80474 19.6332 2.80474 20.4142 3.58579C21.1953 4.36683 21.1953 5.63316 20.4142 6.41421L11.8284 15H9V12.1716L17.5858 3.58579Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Change Address
                </a>
            </div>
        </div>
    </div>
</div>
