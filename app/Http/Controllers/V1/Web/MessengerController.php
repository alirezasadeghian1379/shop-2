<?php

namespace App\Http\Controllers\V1\Web;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Messenger\WhatsappStoreRequest;
use App\Services\Gallery\GalleryStorageService;
use App\Services\MessengerService;
use App\Services\WhatsAppBridgeService;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class MessengerController extends Controller
{
    public function __construct(
        protected MessengerService  $messengerService,
        protected WhatsappService $whatsappService,
        protected WhatsAppBridgeService  $whatsappBridgeService,
        protected GalleryStorageService $galleryStorageService,
    ) {
        $this->middleware('checkPermission:whatsapp');
    }
    public function index(Request $request)
    {
        try {
            $conversations = $this->whatsappService->getAll();
            $activePhone = (string) ($request->query('phone') ?: $conversations->first()?->phone);
            $messages = $activePhone === '' ? collect() : $this->whatsappService->messagesFor($activePhone);
            return view('admin.whatsapp.index', compact('conversations', 'activePhone', 'messages'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.whatsapp-chats.index');
        }
    }

    public function show(string $phone)
    {
        try {
            $messages = $this->whatsappService->messagesFor($phone);
            return Response::success(['messages' => $messages],'اطلاعات با موفقیت دریافت شد',200);
        } catch (Exception $exception){
            return Response::error('error',$exception->getMessage(), $exception->getCode());
        } catch (Throwable $exception){
            return Response::error($exception,$exception->getMessage(), 500);
        }
    }
    public function store(WhatsappStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['phone'] = $this->whatsappService->normalizePhone($data['phone']);
            $data['message'] = trim((string) ($data['message'] ?? ''));
            $result = $this->messengerService->sendMessage($data['phone'], $data['message'], $request->file('media'));
            $data['media_type'] = $result['media_type'] ?? null;
            $data['media_mime'] = $result['media_mime'] ?? null;
            $data['media_name'] = $result['media_name'] ?? null;
            $message = $this->whatsappService->store((string) ($result['id'] ?? ''), $data);
            if ($request->hasFile('media')) {
                $this->galleryStorageService->upload(
                    $request->file('media'),
                    'whatsapp',
                    $message->id,
                    StorageTypeEnum::WHATSAPP,
                    $data['media_type'] === 'video' ? 'video' : 'image'
                );
            }
            return Response::success(['message' => $message],'اطلاعات با موفقیت دریافت شد',200);
        } catch (Exception $exception){
            return Response::error($exception,$exception->getMessage(), $exception->getCode());
        } catch (Throwable $exception) {
            return Response::error($exception, $exception->getMessage(), 500);
        }
    }
    public function status()
    {
        return $this->run(fn () => $this->whatsappBridgeService->status());
    }
    public function connect()
    {
        return $this->run(fn () => $this->whatsappBridgeService->connect());
    }
    public function disconnect()
    {
        return $this->run(fn () => $this->whatsappBridgeService->disconnect());
    }
    public function run(callable $action)
    {
        try {
            return response()->json($action());
        } catch (Throwable $exception) {
            report($exception);
            return response()->json([
                'status' => 'unavailable',
                'message' => 'سرویس واتساپ در دسترس نیست. تنظیمات و اجرای Bridge را بررسی کنید.',
            ], 503);
        }
    }
}

