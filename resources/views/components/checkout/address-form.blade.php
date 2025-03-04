<div class="shipping-address-form">
    <div class="form-section">
        <h4 class="section-title">
            <svg class="section-icon" viewBox="0 0 24 24" fill="none">
                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 14H8C5.79086 14 4 15.7909 4 18C4 19.1046 4.89543 20 6 20H18C19.1046 20 20 19.1046 20 18C20 15.7909 18.2091 14 16 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Personal Details
        </h4>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" class="form-control" name="name" required="" value="{{old('name')}}" placeholder="Full Name *">
                    @error('name') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9286C16.2985 13.7716 16.0777 13.6932 15.8683 13.7159C15.6836 13.7357 15.5059 13.8105 15.3549 13.9331C15.1837 14.0723 15.0629 14.3046 14.8212 14.7693L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.25 9.16667C9.71524 8.92430 9.94786 8.80312 10.087 8.63189C10.2093 8.48016 10.2842 8.30138 10.3041 8.11546C10.3269 7.90474 10.2476 7.68286 10.089 7.23907L8.90138 4.02316C8.76425 3.64421 8.69569 3.45473 8.57418 3.31481C8.46736 3.19204 8.33043 3.09683 8.17753 3.03865C8.00543 2.97314 7.80338 2.97314 7.39929 2.97314H4.56201C4.08183 2.97314 3.84174 2.97314 3.63648 3.07162C3.46538 3.15447 3.29934 3.30932 3.20487 3.47388C3.09084 3.67262 3.07542 3.88962 3.04458 4.32361C3.01509 4.70278 3 5.09575 3 5.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" class="form-control" name="phone" required="" value="{{old('phone')}}" placeholder="Phone Number *">
                    @error('phone') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h4 class="section-title">
            <svg class="section-icon" viewBox="0 0 24 24" fill="none">
                <path d="M17.6569 16.6569C16.7202 17.5935 14.7616 19.5521 13.4142 20.8995C12.6332 21.6805 11.3668 21.6805 10.5858 20.8995C9.26105 19.5748 7.34477 17.6585 6.34315 16.6569C3.21895 13.5327 3.21895 8.46734 6.34315 5.34315C9.46734 2.21895 14.5327 2.21895 17.6569 5.34315C20.781 8.46734 20.781 13.5327 17.6569 16.6569Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15 11C15 12.6569 13.6569 14 12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Location Information
        </h4>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M5 8H19M5 8C3.89543 8 3 7.10457 3 6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6C21 7.10457 20.1046 8 19 8M5 8L5 18C5 19.1046 5.89543 20 7 20H17C18.1046 20 19 19.1046 19 18V8M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" class="form-control" name="zip" required="" value="{{old('zip')}}" placeholder="Pincode *">
                    @error('zip') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M9 20L3 17V4L9 7M9 20L15 17M9 20V7M15 17L21 20V7L15 4M15 17V4M9 7L15 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" class="form-control" name="state" required="" value="{{old('state')}}" placeholder="State *">
                    @error('state') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M2 20H22M4 20V12H6M18 20V12H20M14 20V12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12V20M8 20V12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12V20M7 8H17M9.5 8V6C9.5 4.89543 10.3954 4 11.5 4H12.5C13.6046 4 14.5 4.89543 14.5 6V8H9.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" class="form-control" name="city" required="" value="{{old('city')}}" placeholder="Town / City *">
                    @error('city') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h4 class="section-title">
            <svg class="section-icon" viewBox="0 0 24 24" fill="none">
                <path d="M3 9L12 2L21 9V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 21V12H15V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Address Details
        </h4>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M3 10.25V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V10.25M3 10.25V6C3 5.44772 3.44772 5 4 5H20C20.5523 5 21 5.44772 21 6V10.25M3 10.25H21M7 15H8M12 15H13M17 15H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" class="form-control" name="address" required="" value="{{old('address')}}" placeholder="House no, Building Name *">
                    @error('address') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M11 19L6.5 14.5M6.5 14.5L2 10M6.5 14.5L11 10M6.5 14.5L15 14.5M11 5L15.5 9.5M15.5 9.5L20 14M15.5 9.5L11 14M15.5 9.5L7 9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" class="form-control" name="locality" required="" value="{{old('locality')}}" placeholder="Road Name, Area, Colony *">
                    @error('locality') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-container">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" class="form-control" name="landmark" required="" value="{{old('landmark')}}" placeholder="Landmark *">
                    @error('landmark') <span class="error-message">{{$message}}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
