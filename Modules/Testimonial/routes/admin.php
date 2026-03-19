<?php

use Illuminate\Support\Facades\Route;
use Modules\Testimonial\Http\Controllers\Admin\TestimonialController;

Route::resource('testimonials', TestimonialController::class);