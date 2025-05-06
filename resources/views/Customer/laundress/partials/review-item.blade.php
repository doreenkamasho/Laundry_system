<div class="d-flex mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }} review-item" id="review-{{ $review->id }}">
    <div class="flex-shrink-0">
        <div class="avatar-sm">
            @if($review->customer->avatar)
                <img src="{{ asset('storage/'.$review->customer->avatar) }}" 
                    alt="" class="avatar-sm rounded-circle">
            @else
                <div class="avatar-sm rounded-circle bg-primary text-white">
                    <span class="avatar-title">
                        {{ substr($review->customer->name, 0, 1) }}
                    </span>
                </div>
            @endif
        </div>
    </div>
    <div class="flex-grow-1 ms-3">
        <div class="d-flex align-items-center mb-2">
            <h5 class="mb-0">{{ $review->customer->name }}</h5>
            <div class="ms-auto">
                <span class="text-muted fs-12">
                    {{ $review->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        <div class="text-warning mb-2">
            @for($i = 1; $i <= 5; $i++)
                <i class="ri-star-{{ $i <= $review->rating ? 'fill' : 'line' }}"></i>
            @endfor
        </div>
        <p class="text-muted">{{ $review->comment }}</p>
        
        <!-- Social media like reactions -->
        <div class="comment-reactions mt-2">
            <div class="comment-reaction like-btn" data-review-id="{{ $review->id }}">
                <i class="ri-thumb-up-line"></i>
                <span class="reaction-count">0</span>
            </div>
            <div class="comment-reaction reply-btn" data-review-id="{{ $review->id }}">
                <i class="ri-reply-line"></i>
                <span>Reply</span>
                <span class="ms-1 reply-count">(0)</span>
            </div>
        </div>
        
        <!-- Reply form (hidden by default) -->
        <div class="reply-form-container mt-3" id="reply-form-{{ $review->id }}" style="display: none;">
            <div class="d-flex gap-2">
                <div class="flex-shrink-0">
                    <div class="avatar-xs">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" 
                                alt="" class="avatar-xs rounded-circle">
                        @else
                            <div class="avatar-xs rounded-circle bg-primary text-white">
                                <span class="avatar-title">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex-grow-1">
                    <form class="reply-form" data-review-id="{{ $review->id }}">
                        <div class="position-relative">
                            <input type="text" class="form-control border-light bg-light" 
                                placeholder="Write a reply..." required>
                            <div class="position-absolute top-0 end-0 h-100 d-flex align-items-center">
                                <button type="submit" class="btn btn-link text-muted px-2">
                                    <i class="ri-send-plane-fill"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Replies container -->
        <div class="replies-container mt-3 ps-4 border-start ms-3" id="replies-{{ $review->id }}" style="display: none;">
            <!-- Replies will be loaded here -->
        </div>
    </div>
</div>