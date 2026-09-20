{{--
    Article Engagement Partial
    Requires variables passed from PublicController::article():
      - $article       : Article model (with likes, comments.user loaded)
      - $userHasLiked  : bool
      - $likeCount     : int
--}}

<style>
/* ── Animated Like Button ─────────────────────────────────────────────── */
.like-icobutton {
    position: relative;
    margin: 0;
    padding: 0;
    border: 0;
    background: none;
    cursor: pointer;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    display: flex;
    align-items: center;
    gap: 10px;
    outline: none;
}
.like-icobutton:focus { outline: none; }

.like-icon-wrap {
    position: relative;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Ripple ring burst */
.like-icon-wrap::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid #B71032;
    opacity: 0;
    transform: scale(1);
    transition: none;
}
.like-icon-wrap.is-liked::before {
    animation: like-ring 0.45s ease-out forwards;
}
@keyframes like-ring {
    0%   { opacity: .7; transform: scale(1); }
    100% { opacity: 0;  transform: scale(1.9); }
}

/* The thumb icon circle */
.like-thumb-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #d1d5db;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color .2s, background .2s;
    position: relative;
    z-index: 1;
}
.like-icobutton:hover .like-thumb-circle,
.like-icobutton:focus .like-thumb-circle {
    border-color: #B71032;
}
.like-thumb-circle.is-liked {
    background: #fff1f2;
    border-color: #B71032;
}

/* SVG icon */
.like-thumb-svg {
    width: 20px;
    height: 20px;
    stroke: #9ca3af;
    fill: none;
    transition: stroke .2s, fill .2s, transform .15s;
    transform-origin: center bottom;
}
.like-icobutton:hover .like-thumb-svg {
    stroke: #B71032;
}
.like-thumb-svg.is-liked {
    stroke: #B71032;
    fill: #B71032;
}

/* Pop bounce on like */
.like-thumb-svg.pop {
    animation: thumb-pop .4s cubic-bezier(.36,.07,.19,.97) both;
}
@keyframes thumb-pop {
    0%   { transform: scale(1)    rotate(0deg); }
    20%  { transform: scale(1.45) rotate(-12deg); }
    40%  { transform: scale(0.85) rotate(6deg); }
    65%  { transform: scale(1.2)  rotate(-3deg); }
    100% { transform: scale(1)    rotate(0deg); }
}

/* Unlike shrink */
.like-thumb-svg.unpop {
    animation: thumb-unpop .25s ease both;
}
@keyframes thumb-unpop {
    0%   { transform: scale(1); }
    40%  { transform: scale(0.75); }
    100% { transform: scale(1); }
}

.like-label {
    font-size: .875rem;
    font-weight: 600;
    color: #374151;
    font-family: inherit;
    transition: color .2s;
    user-select: none;
}
</style>

<div class="mt-10 mb-8 space-y-10" id="engagement-section">

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- LIKE + SHARE BAR                                                  --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div class="flex items-center justify-between border-t border-b border-gray-200 py-4 gap-4 flex-wrap">

        {{-- Like Button (animated icobutton style) --}}
        <button
            id="like-btn"
            data-article-id="{{ $article->id }}"
            data-liked="{{ $userHasLiked ? 'true' : 'false' }}"
            data-login-url="{{ route('login') }}"
            data-toggle-url="{{ auth()->guard('web')->check() ? route('articles.like.toggle', $article) : '' }}"
            class="like-icobutton"
            aria-label="Like artikel ini"
        >
            <div class="like-icon-wrap {{ $userHasLiked ? 'is-liked' : '' }}" id="like-icon-wrapper">
                <div class="like-thumb-circle {{ $userHasLiked ? 'is-liked' : '' }}" id="like-thumb-circle">
                    <svg id="like-icon"
                        class="like-thumb-svg {{ $userHasLiked ? 'is-liked' : '' }}"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                </div>
            </div>
            <span class="like-label">
                <span id="like-count">{{ $likeCount }}</span>
                <span class="font-normal text-gray-500 hidden sm:inline"> Suka</span>
            </span>
        </button>

        {{-- Right side: Comment count + Share --}}
        <div class="flex items-center gap-4">
            <a href="#comments-section"
                class="flex items-center gap-2 text-sm text-gray-500 hover:text-navy transition-colors group">
                <span class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-300 group-hover:border-navy transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
                <span class="font-semibold" id="comment-bar-count">{{ $article->comments->count() }}</span>
                <span class="hidden sm:inline font-normal text-gray-500">Komentar</span>
            </a>

            <button id="share-btn"
                class="flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-navy transition-colors group"
                aria-label="Bagikan artikel">
                <span class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-300 group-hover:border-navy transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </span>
                <span class="hidden sm:inline">Bagikan</span>
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- SHARE MODAL                                                        --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div id="share-modal"
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 sm:p-0"
        style="display:none !important;"
        role="dialog" aria-modal="true" aria-labelledby="share-modal-title">

        <div id="share-backdrop"
            class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-200 opacity-0"></div>

        <div id="share-panel"
            class="relative w-full sm:w-auto sm:min-w-[400px] bg-[#1a1a2e] rounded-2xl p-6 sm:p-8
                shadow-2xl text-white translate-y-4 sm:translate-y-0 sm:scale-95
                transition-all duration-200 opacity-0">

            <button id="share-close"
                class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors"
                aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <p id="share-modal-title" class="text-center font-sans font-semibold text-base mb-6 text-[#4fc3f7]">
                Bagikan artikel ini melalui
            </p>

            <div class="grid grid-cols-3 sm:grid-cols-6 gap-4 place-items-center">

                {{-- Facebook --}}
                <a id="share-facebook" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex flex-col items-center gap-2 group">
                    <span class="w-12 h-12 rounded-full bg-[#1877F2] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-150">
                        <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </span>
                    <span class="text-xs text-gray-300 group-hover:text-white transition-colors">Facebook</span>
                </a>

                {{-- X --}}
                <a id="share-x" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex flex-col items-center gap-2 group">
                    <span class="w-12 h-12 rounded-full bg-black border border-gray-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-150">
                        <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.742l7.73-8.835L2.25 2.25h6.875l4.256 5.621L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/></svg>
                    </span>
                    <span class="text-xs text-gray-300 group-hover:text-white transition-colors">X</span>
                </a>

                {{-- WhatsApp --}}
                <a id="share-whatsapp" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex flex-col items-center gap-2 group">
                    <span class="w-12 h-12 rounded-full bg-[#25D366] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-150">
                        <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </span>
                    <span class="text-xs text-gray-300 group-hover:text-white transition-colors">Whatsapp</span>
                </a>

                {{-- LINE --}}
                <a id="share-line" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex flex-col items-center gap-2 group">
                    <span class="w-12 h-12 rounded-full bg-[#00B900] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-150">
                        <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.281.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
                    </span>
                    <span class="text-xs text-gray-300 group-hover:text-white transition-colors">Line</span>
                </a>

                {{-- Telegram --}}
                <a id="share-telegram" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex flex-col items-center gap-2 group">
                    <span class="w-12 h-12 rounded-full bg-[#229ED9] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-150">
                        <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    </span>
                    <span class="text-xs text-gray-300 group-hover:text-white transition-colors">Telegram</span>
                </a>

                {{-- Copy Link --}}
                <button id="copy-link-btn" class="flex flex-col items-center gap-2 group">
                    <span class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-150">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </span>
                    <span class="text-xs text-gray-300 group-hover:text-white transition-colors">Copy Link</span>
                </button>
            </div>

            <div id="copy-toast"
                class="mt-5 text-center text-xs font-semibold text-green-400 opacity-0 transition-opacity duration-300 h-4">
                ✓ Link berhasil disalin!
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- COMMENT SECTION                                                    --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div id="comments-section">
        <h2 class="text-2xl font-serif font-bold text-navy mb-6 flex items-center gap-3">
            Komentar
            <span class="text-base font-sans font-normal text-gray-400"
                id="comment-count-label">({{ $article->comments->count() }})</span>
        </h2>

        {{-- Comment Form --}}
        @auth('web')
            <div class="mb-8">
                <div class="flex gap-3 sm:gap-4">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex-shrink-0 overflow-hidden bg-navy border border-gray-200">
                        @php $authUser = auth()->guard('web')->user(); @endphp
                        @if($authUser->avatar_path)
                            @if(Str::startsWith($authUser->avatar_path, ['http://', 'https://']))
                                <img src="{{ $authUser->avatar_path }}" alt="{{ $authUser->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('storage/' . $authUser->avatar_path) }}" alt="{{ $authUser->name }}" class="w-full h-full object-cover">
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($authUser->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <textarea id="comment-input" rows="3" maxlength="1000"
                            placeholder="Tulis komentarmu…"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-sans text-gray-800
                                placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-crimson/30
                                focus:border-crimson resize-none transition-all"></textarea>
                        <div class="flex items-center justify-between mt-2">
                            <span id="comment-char-count" class="text-xs text-gray-400">0 / 1000</span>
                            <button id="comment-submit-btn"
                                data-store-url="{{ route('articles.comments.store', $article) }}"
                                class="inline-flex items-center gap-2 bg-[#B71032] hover:bg-red-800 text-white
                                    text-xs font-bold uppercase tracking-wider px-5 py-2.5 rounded-full
                                    transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/>
                                </svg>
                                Kirim
                            </button>
                        </div>
                        <p id="comment-error" class="mt-1.5 text-xs text-red-500 hidden"></p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-8 border border-dashed border-gray-300 rounded-xl p-5 text-center">
                <p class="text-sm text-gray-600 font-sans mb-3">Silakan login untuk meninggalkan komentar.</p>
                <a href="{{ route('login') }}?intended={{ urlencode(request()->url()) }}"
                    class="inline-flex items-center gap-2 bg-[#B71032] text-white text-xs font-bold uppercase
                        tracking-wider px-5 py-2.5 rounded-full hover:bg-red-800 transition-colors">
                    Login untuk Berkomentar
                </a>
            </div>
        @endauth

        {{-- Comment List --}}
        <div id="comment-list" class="space-y-5">
            @forelse($article->comments as $comment)
                <div class="comment-item flex gap-3 sm:gap-4" data-comment-id="{{ $comment->id }}">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex-shrink-0 overflow-hidden bg-navy border border-gray-200">
                        @if($comment->user->avatar_path)
                            @if(Str::startsWith($comment->user->avatar_path, ['http://', 'https://']))
                                <img src="{{ $comment->user->avatar_path }}" alt="{{ $comment->user->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('storage/' . $comment->user->avatar_path) }}" alt="{{ $comment->user->name }}" class="w-full h-full object-cover">
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                        <div class="flex items-center justify-between mb-1.5 gap-2 flex-wrap">
                            <span class="font-sans font-semibold text-sm text-navy">{{ $comment->user->name }}</span>
                            <div class="flex items-center gap-2 ml-auto">
                                <span class="text-xs text-gray-400 font-sans">{{ $comment->created_at->diffForHumans() }}</span>
                                @if(auth()->guard('web')->check() &&
                                    (auth()->guard('web')->user()->id === $comment->user_id || auth()->guard('web')->user()->isAdmin()))
                                    <button class="comment-delete-btn text-gray-300 hover:text-red-500 transition-colors"
                                        data-comment-id="{{ $comment->id }}"
                                        data-delete-url="{{ route('comments.destroy', $comment) }}"
                                        aria-label="Hapus komentar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 font-sans leading-relaxed whitespace-pre-line">{{ $comment->body }}</p>
                    </div>
                </div>
            @empty
                <div id="empty-comments" class="text-center py-10 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-sm font-sans">Belum ada komentar. Jadilah yang pertama!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                                               --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
(function () {
    'use strict';

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function apiRequest(url, method, body) {
        return fetch(url, {
            method: method || 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: body ? JSON.stringify(body) : undefined,
        }).then(function(res) {
            if (!res.ok) return res.json().then(function(d) { throw d; });
            return res.json();
        });
    }

    /* ── Like Toggle (animated) ──────────────────────────────────────────── */

    var likeBtn        = document.getElementById('like-btn');
    var likeIcon       = document.getElementById('like-icon');
    var likeIconWrapper= document.getElementById('like-icon-wrapper');
    var likeThumbCircle= document.getElementById('like-thumb-circle');
    var likeCountEl    = document.getElementById('like-count');

    if (likeBtn) {
        var liked = likeBtn.dataset.liked === 'true';

        function setLikedUI(state, animate) {
            liked = state;

            // Remove old animation classes first
            likeIcon.classList.remove('pop', 'unpop');
            likeIconWrapper.classList.remove('is-liked');

            // Force reflow so animation can restart
            void likeIcon.offsetWidth;

            if (state) {
                likeIcon.classList.add('is-liked');
                likeThumbCircle.classList.add('is-liked');
                if (animate) {
                    likeIcon.classList.add('pop');
                    likeIconWrapper.classList.add('is-liked');
                } else {
                    likeIconWrapper.classList.remove('is-liked');
                }
            } else {
                likeIcon.classList.remove('is-liked');
                likeThumbCircle.classList.remove('is-liked');
                if (animate) likeIcon.classList.add('unpop');
            }
        }

        // Set initial state without animation
        setLikedUI(liked, false);

        likeBtn.addEventListener('click', function() {
            var toggleUrl = likeBtn.dataset.toggleUrl;
            if (!toggleUrl) {
                window.location.href = likeBtn.dataset.loginUrl;
                return;
            }
            likeBtn.disabled = true;
            // Optimistic UI — animate immediately
            var nextState = !liked;
            setLikedUI(nextState, true);

            apiRequest(toggleUrl, 'POST')
                .then(function(data) {
                    // Sync with server truth
                    if (data.liked !== nextState) setLikedUI(data.liked, false);
                    likeCountEl.textContent = data.count;
                })
                .catch(function() {
                    // Revert on error
                    setLikedUI(!nextState, false);
                })
                .finally(function() { likeBtn.disabled = false; });
        });
    }

    /* ── Comment Form ────────────────────────────────────────────────────── */

    var commentInput     = document.getElementById('comment-input');
    var commentSubmitBtn = document.getElementById('comment-submit-btn');
    var commentError     = document.getElementById('comment-error');
    var commentList      = document.getElementById('comment-list');
    var commentCountLbl  = document.getElementById('comment-count-label');
    var commentBarCount  = document.getElementById('comment-bar-count');
    var commentCharCount = document.getElementById('comment-char-count');

    function updateCommentCount(delta) {
        [commentCountLbl, commentBarCount].forEach(function(el) {
            if (!el) return;
            var n = parseInt(el.textContent.replace(/\D/g, ''), 10) || 0;
            el.textContent = el === commentCountLbl ? '(' + (n + delta) + ')' : (n + delta);
        });
    }

    if (commentInput) {
        commentInput.addEventListener('input', function() {
            var len = commentInput.value.length;
            commentCharCount.textContent = len + ' / 1000';
            commentSubmitBtn.disabled = len === 0;
        });

        commentSubmitBtn.addEventListener('click', function() {
            var body = commentInput.value.trim();
            if (!body) return;
            commentSubmitBtn.disabled = true;
            commentError.classList.add('hidden');

            apiRequest(commentSubmitBtn.dataset.storeUrl, 'POST', { body: body })
                .then(function(data) {
                    commentInput.value = '';
                    commentCharCount.textContent = '0 / 1000';

                    var empty = document.getElementById('empty-comments');
                    if (empty) empty.remove();

                    var c   = data.comment;
                    var av  = c.user.avatar_path;
                    var avatarHtml = av
                        ? '<img src="' + (av.startsWith('http') ? av : '/storage/' + av) + '" class="w-full h-full object-cover" alt="' + c.user.name + '">'
                        : '<div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">' + c.user.name.charAt(0).toUpperCase() + '</div>';

                    var el = document.createElement('div');
                    el.className = 'comment-item flex gap-3 sm:gap-4';
                    el.dataset.commentId = c.id;
                    el.innerHTML =
                        '<div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex-shrink-0 overflow-hidden bg-navy border border-gray-200">' + avatarHtml + '</div>' +
                        '<div class="flex-1 bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">' +
                            '<div class="flex items-center justify-between mb-1.5 gap-2 flex-wrap">' +
                                '<span class="font-sans font-semibold text-sm text-navy">' + c.user.name + '</span>' +
                                '<div class="flex items-center gap-2 ml-auto">' +
                                    '<span class="text-xs text-gray-400 font-sans">' + c.created_at + '</span>' +
                                    '<button class="comment-delete-btn text-gray-300 hover:text-red-500 transition-colors"' +
                                        ' data-comment-id="' + c.id + '"' +
                                        ' data-delete-url="/comments/' + c.id + '"' +
                                        ' aria-label="Hapus komentar">' +
                                        '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">' +
                                            '<path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>' +
                                        '</svg>' +
                                    '</button>' +
                                '</div>' +
                            '</div>' +
                            '<p class="text-sm text-gray-700 font-sans leading-relaxed whitespace-pre-line">' + c.body.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</p>' +
                        '</div>';

                    commentList.prepend(el);
                    bindDelete(el.querySelector('.comment-delete-btn'));
                    updateCommentCount(1);
                })
                .catch(function(err) {
                    var msg = (err && err.errors && err.errors.body) ? err.errors.body[0]
                            : ((err && err.message) ? err.message : 'Gagal mengirim komentar. Coba lagi.');
                    commentError.textContent = msg;
                    commentError.classList.remove('hidden');
                    commentSubmitBtn.disabled = false;
                });
        });
    }

    /* ── Comment Delete ──────────────────────────────────────────────────── */

    function bindDelete(btn) {
        if (!btn) return;
        btn.addEventListener('click', function() {
            var doDelete = function() {
                var id   = btn.dataset.commentId;
                var url  = btn.dataset.deleteUrl;
                var item = document.querySelector('[data-comment-id="' + id + '"]');
                apiRequest(url, 'DELETE')
                    .then(function() {
                        if (item) item.remove();
                        updateCommentCount(-1);
                        if (commentList && commentList.querySelectorAll('.comment-item').length === 0) {
                            var empty = document.createElement('div');
                            empty.id = 'empty-comments';
                            empty.className = 'text-center py-10 text-gray-400';
                            empty.innerHTML = '<svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg><p class="text-sm font-sans">Belum ada komentar. Jadilah yang pertama!</p>';
                            commentList.appendChild(empty);
                        }
                    })
                    .catch(function(err) {
                        alert(err.message || 'Gagal menghapus komentar.');
                    });
            };

            if (window.showAlertDialog) {
                window.showAlertDialog({
                    title: 'Delete comment?',
                    description: 'Are you sure you want to permanently delete this comment?',
                    confirmText: 'Delete',
                    cancelText: 'Cancel',
                    variant: 'destructive',
                    icon: 'trash'
                }).then(function(confirmed) {
                    if (confirmed) doDelete();
                });
            } else if (confirm('Hapus komentar ini?')) {
                doDelete();
            }
        });
    }

    document.querySelectorAll('.comment-delete-btn').forEach(bindDelete);

    /* ── Share Modal ─────────────────────────────────────────────────────── */

    var shareBtn      = document.getElementById('share-btn');
    var shareModal    = document.getElementById('share-modal');
    var sharePanel    = document.getElementById('share-panel');
    var shareBackdrop = document.getElementById('share-backdrop');
    var shareClose    = document.getElementById('share-close');
    var copyLinkBtn   = document.getElementById('copy-link-btn');
    var copyToast     = document.getElementById('copy-toast');

    var articleUrl   = '{{ url()->current() }}';
    var articleTitle = {{ Js::from($article->title) }};

    var el_fb   = document.getElementById('share-facebook');
    var el_x    = document.getElementById('share-x');
    var el_wa   = document.getElementById('share-whatsapp');
    var el_line = document.getElementById('share-line');
    var el_tg   = document.getElementById('share-telegram');

    if (el_fb)   el_fb.href   = 'https://www.facebook.com/sharer/sharer.php?u='   + encodeURIComponent(articleUrl);
    if (el_x)    el_x.href    = 'https://twitter.com/intent/tweet?text='          + encodeURIComponent(articleTitle) + '&url=' + encodeURIComponent(articleUrl);
    if (el_wa)   el_wa.href   = 'https://wa.me/?text='                            + encodeURIComponent(articleTitle + '\n' + articleUrl);
    if (el_line) el_line.href = 'https://social-plugins.line.me/lineit/share?url=' + encodeURIComponent(articleUrl);
    if (el_tg)   el_tg.href   = 'https://t.me/share/url?url='                    + encodeURIComponent(articleUrl) + '&text=' + encodeURIComponent(articleTitle);

    function openModal() {
        shareModal.style.removeProperty('display');
        requestAnimationFrame(function() {
            shareBackdrop.classList.replace('opacity-0','opacity-100');
            sharePanel.classList.remove('opacity-0','sm:scale-95','translate-y-4');
            sharePanel.classList.add('opacity-100','sm:scale-100','translate-y-0');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        shareBackdrop.classList.replace('opacity-100','opacity-0');
        sharePanel.classList.add('opacity-0','sm:scale-95','translate-y-4');
        sharePanel.classList.remove('opacity-100','sm:scale-100','translate-y-0');
        setTimeout(function() {
            shareModal.style.setProperty('display','none','important');
            document.body.style.overflow = '';
        }, 200);
    }

    if (shareBtn)      shareBtn.addEventListener('click', openModal);
    if (shareClose)    shareClose.addEventListener('click', closeModal);
    if (shareBackdrop) shareBackdrop.addEventListener('click', closeModal);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && shareModal && !shareModal.style.display.includes('none')) closeModal();
    });

    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            var show = function() {
                copyToast.classList.replace('opacity-0','opacity-100');
                setTimeout(function() { copyToast.classList.replace('opacity-100','opacity-0'); }, 2500);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(articleUrl).then(show).catch(show);
            } else {
                var ta = document.createElement('textarea');
                ta.value = articleUrl;
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); } catch(e) {}
                document.body.removeChild(ta);
                show();
            }
        });
    }

})();
</script>
@endpush
