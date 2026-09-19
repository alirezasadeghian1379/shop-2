@extends('admin.master')
@section('title', __('web/messenger.title'))


@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm wa-shell">
            <div class="row g-0 h-100">
                <div class="col-md-4 col-lg-3 wa-list bg-white">
                    <div class="p-3 border-bottom"><h6 class="mb-0">{{__('web/messenger.title')}}</h6></div>
                    <div class="p-3 border-bottom">
                        <button type="button" class="btn bg-gradient-primary w-100 mb-0" data-bs-toggle="modal" data-bs-target="#newWhatsAppMessageModal">
                            {{__('web/messenger.create')}}
                        </button>
                    </div>
                    @forelse($conversations as $conversation)
                        <a href="{{ route('admin.whatsapp-chats.index',['phone'=>$conversation->phone]) }}" class="wa-contact d-block p-3 border-bottom text-decoration-none {{ $activePhone===$conversation->phone?'active':'' }}">
                            <div class="d-flex justify-content-between">
                                <strong class="text-dark" dir="ltr">+{{ ltrim($conversation->phone,'+') }}</strong>
                                <span class="badge bg-light text-dark">{{ $conversation->messages_count }}</span>
                            </div>
                            <small class="text-muted">{{ $conversation->getJalaliLastMessageAt() }}</small>
                        </a>
                    @empty
                        <div class="p-4 text-center text-muted">{{__('web/messenger.empty_table')}}</div>
                    @endforelse
                </div>

                <div class="col-md-8 col-lg-9 wa-chat">
                    @if($activePhone)
                        <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center gap-1 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-whatsapp text-success fs-4"></i>
                                <strong dir="ltr">+{{ ltrim($activePhone,'+') }}</strong>
                            </div>
                            <button type="button" id="reloadMessages" class="btn bg-gradient-primary">
                                <i class="bi bi-arrow-clockwise d-flex"></i>
                            </button>
                        </div>

                        @if($messages->isNotEmpty())
                        <div class="d-flex justify-content-center align-items-center mt-2 mb-1 created_at_style">
                            <span>{{$messages->first()->getJalaliCreatedDate()}}</span>
                        </div>
                        @endif


                        <div id="waMessages" class="wa-messages" data-url="{{ route('admin.whatsapp-chats.show',$activePhone) }}">
                            @foreach($messages as $message)
                                <div class="wa-bubble {{ $message->direction==='incoming'?'wa-in':'wa-out' }}">
                                    @if($message->media_type === 'image' && $message->media_url)
                                        <a href="{{ $message->media_url }}" target="_blank" class="wa-media-link"><img src="{{ $message->media_url }}" alt="تصویر واتساپ" class="wa-media"></a>
                                    @elseif($message->media_type === 'video' && $message->media_url)
                                        <video class="wa-media" controls preload="metadata"><source src="{{ $message->media_url }}" type="{{ $message->media_mime }}"></video>
                                    @endif
                                    @if($message->message !== '')<div class="wa-caption">{{ $message->message }}</div>@endif
                                    <div class="wa-time">{{ $message->getSourcePersian() }}  {{ $message->getJalaliSentAt() }}</div>
                                </div>
                            @endforeach
                        </div>
                        <form id="waSendForm" class="p-3 bg-white border-top d-flex gap-2" action="{{ route('admin.whatsapp-chats.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="phone" value="{{ $activePhone }}">

                            <input
                                id="waMedia"
                                type="file"
                                name="media"
                                class="d-none"
                                accept="image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo"
                            >

                            <label for="waMedia" class="btn btn-light mb-0 px-3" title="ارسال عکس یا ویدئو">
                                <i class="bi bi-paperclip"></i>
                            </label>


                            <div class="wa-compose flex-grow-1">
                                <div id="waMediaPreview" class="wa-file-preview d-none"></div>
                                <textarea name="message" class="form-control" rows="1" maxlength="4000" placeholder="{{__('web/messenger.messages.text')}}"></textarea>
                            </div>
                            <button class="btn btn-success mb-0 px-4" type="submit"><i class="bi bi-send"></i></button>
                        </form>
                    @else
                        <div class="m-auto text-center text-muted">
                            <i class="bi bi-chat-dots fs-1"></i>
                            <p>{{__('web/messenger.selected_chat')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newWhatsAppMessageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="waNewMessageForm" class="modal-content" action="{{ route('admin.whatsapp-chats.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('web/messenger.create_modal.description')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{__('web/messenger.create_modal.form.mobile')}}</label>
                        <input type="text" name="phone" class="form-control" dir="ltr" inputmode="tel" maxlength="32" placeholder="989121234567" pattern="[0-9+]+" required oninput="this.value = this.value.replace(/[^0-9]/g,'').replace(/(\..*)\./g,'$1');">
                        <small class="text-muted">{{__('web/messenger.create_modal.form.mobile_placeholder')}}</small>
                    </div>
                    <div>
                        <label class="form-label">{{__('web/messenger.create_modal.form.text')}}</label>
                        <textarea name="message" class="form-control" rows="4" maxlength="4000"></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">عکس یا ویدئو</label>

                        <input
                            type="file"
                            name="media"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo"
                        >

                        <small class="text-muted">
                            عکس: JPG، PNG، WEBP — ویدئو: MP4، MOV، AVI
                        </small>
                    </div>
                    <div class="alert alert-danger mt-3 mb-0 d-none text-white d-flex justify-content-center align-items-center" id="waNewMessageError"></div>
                </div>
                <div class="modal-footer">
                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-6 p-1">
                            <button type="submit" class="btn btn-success mb-0 w-100"><i class="bi bi-send ms-1"></i>{{__('web/messenger.create_modal.buttons.submit')}}</button>
                        </div>
                        <div class="col-md-6 p-1">
                            <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">{{__('web/messenger.create_modal.buttons.close')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('style')
    <style>
        .wa-shell {
            height: calc(100vh - 185px);
            min-height: 560px;
            overflow: hidden
        }

        .wa-list {
            height: 100%;
            overflow-y: auto;
            border-left: 1px solid #eee
        }

        .wa-chat {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-image: url("/assets/images/chat-bg-whatsapp.jfif");
        }

        .wa-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem
        }

        .wa-bubble {
            max-width: 75%;
            padding: .65rem .9rem;
            margin-bottom: .65rem;
            border-radius: 14px;
            word-break: break-word
        }

        .wa-media { display: block; width: min(360px, 100%); max-height: 360px; object-fit: cover; border-radius: 10px; background: #111; }
        .wa-media-link { display: block; }
        .wa-caption { margin-top: .55rem; white-space: pre-wrap; }
        .wa-compose { min-width: 0; }
        .wa-file-preview { font-size: .75rem; color: #344767; background: #eef8f1; border: 1px solid #cdebd5; border-radius: 10px; padding: .4rem .65rem; margin-bottom: .4rem; }

        .wa-in {
            margin-right: auto;
            background: #fff;
            border-bottom-left-radius: 4px
        }

        .wa-out {
            margin-left: auto;
            background: #d9fdd3;
            border-bottom-right-radius: 4px
        }

        .wa-contact.active {
            background: #eef8f1;
            border-right: 3px solid #25d366
        }

        .wa-time {
            font-size: .68rem;
            color: #8392ab;
            margin-top: .3rem
        }

        @media (max-width: 767px) {
            .wa-shell {
                height: auto
            }

            .wa-list {
                max-height: 240px;
                border-left: 0;
                border-bottom: 1px solid #eee
            }

            .wa-chat {
                min-height: 520px
            }
        }
        .created_at_style {
            span {
                background-color: rgba(0, 0, 0, 0.21);
                backdrop-filter: blur(2px);
                border-radius: 10px;
                width: auto;
                padding: 5px 15px;
                color: white;
                font-size: 14px;
            }
        }
    </style>
@endsection
@section('script')
    <script>
        (() => {
            const newForm = document.getElementById('waNewMessageForm');
            newForm.addEventListener('submit', async event => {
                event.preventDefault();
                const message = newForm.querySelector('[name="message"]').value.trim();
                const media = newForm.querySelector('[name="media"]').files[0];

                if (!message && !media) {
                    alert('متن پیام یا فایل را وارد کنید.');
                    return;
                }
                const button = newForm.querySelector('button[type="submit"]');
                const errorBox = document.getElementById('waNewMessageError');
                const phoneInput = newForm.querySelector('[name="phone"]');
                phoneInput.value = phoneInput.value.replace(/\s/g, '');
                button.disabled = true;
                errorBox.classList.add('d-none');
                try {
                    const response = await fetch(newForm.action, {
                        method: 'POST',
                        headers: {Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                        body: new FormData(newForm)
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.data.message || 'ارسال پیام ناموفق بود.');
                    window.location.href = @json(route('admin.whatsapp-chats.index')) + '?phone=' + encodeURIComponent(data.data.message.phone);
                } catch (error) {
                    errorBox.textContent = error.message;
                    errorBox.classList.remove('d-none');
                } finally {
                    button.disabled = false;
                }
            });

            const box = document.getElementById('waMessages'), form = document.getElementById('waSendForm');
            if (!box || !form) return;
            const esc = v => $('<div>').text(v ?? '').html();
            const mediaHtml = x => {
                if (!x.media_url) return '';
                const url = esc(x.media_url);
                if (x.media_type === 'image') return `<a href="${url}" target="_blank" class="wa-media-link"><img src="${url}" class="wa-media" alt="تصویر واتساپ"></a>`;
                if (x.media_type === 'video') return `<video class="wa-media" controls preload="metadata"><source src="${url}" type="${esc(x.media_mime || 'video/mp4')}"></video>`;
                return '';
            };
            const render = items => {
                box.innerHTML = items.map(x => {
                    const date = x.sent_at
                        ? new Date(x.sent_at)
                            .toLocaleString('fa-IR', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            })
                            .replace(',', ' -')
                        : '';

                    const source = x.source === 'ai'
                        ? 'هوش مصنوعی - '
                        : x.source === 'admin'
                            ? 'ادمین - '
                            : '';

                    return `
                        <div class="wa-bubble ${x.direction === 'incoming' ? 'wa-in' : 'wa-out'}">
                            ${mediaHtml(x)}
                            ${x.message ? `<div class="wa-caption">${esc(x.message)}</div>` : ''}
                            <div class="wa-time">${source}${date}</div>
                        </div>
                    `;
                }).join('');

                box.scrollTop = box.scrollHeight;
            };
            const mediaInput = form.querySelector('[name="media"]');
            const mediaPreview = document.getElementById('waMediaPreview');
            mediaInput.addEventListener('change', () => {
                const file = mediaInput.files[0];
                mediaPreview.textContent = file ? `فایل انتخاب‌شده: ${file.name}` : '';
                mediaPreview.classList.toggle('d-none', !file);
            });
            const refresh = () => fetch(box.dataset.url, {headers: {Accept: 'application/json'}}).then(r => r.ok ? r.json() : Promise.reject()).then(d => render(d.data.messages)).catch(() => {
            });
            form.addEventListener('submit', e => {
                e.preventDefault();
                const message = form.querySelector('[name="message"]').value.trim();
                const media = form.querySelector('[name="media"]').files[0];

                if (!message && !media) {
                    alert('متن پیام یا فایل را وارد کنید.');
                    return;
                }
                const b = form.querySelector('button');
                b.disabled = true;
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                }).then(async r => {
                    const d = await r.json();
                    if (!r.ok) throw new Error(d.message || 'ارسال پیام ناموفق بود.');
                    form.querySelector('textarea').value = '';
                    mediaInput.value = '';
                    mediaPreview.classList.add('d-none');
                    await refresh()
                }).catch(e => alert(e.message)).finally(() => b.disabled = false)
            });
            box.scrollTop = box.scrollHeight;
            // setInterval(refresh, 10000)
            $('#reloadMessages').on('click',()=>{
                console.log('ssss')
                refresh()
            })
        })();
    </script>
@endsection
