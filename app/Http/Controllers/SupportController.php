<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\User;

class SupportController extends Controller
{
    public function index()
    {
        $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->first();

    $tickets = SupportTicket::where('user_id', $user?->id)->latest()->get();
    return view('support.index', compact('tickets'));
    }


    public function send(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // نحصل على المستخدم من خلال الجلسة
    $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->first();

    SupportTicket::create([
        'user_id' => $user?->id,
        'subject' => $request->subject,
        'message' => $request->message,
    ]);

    return back()->with('success', 'Your message has been sent!');
}

     // دالة لإرسال إشعار للمسؤول عبر تليجرام
     private function sendAdminNotification($subject, $message)
     {
         // هنا يتم تحديد تليجرام ID المسؤول (يجب تغييره إلى تليجرام ID المسؤول الفعلي)
         $adminTelegramId = 'YOUR_ADMIN_TELEGRAM_ID';
 
         // إرسال الرسالة إلى المسؤول عبر تليجرام
         $messageText = "📩 تذكرة دعم جديدة:
         \n🔑 الموضوع: {$subject}
         \n📝 الرسالة: {$message}";
 
         // إرسال الرسالة إلى المسؤول عبر Telegram API
         $response = Http::get("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
             'chat_id' => $adminTelegramId,
             'text' => $messageText,
         ]);
     }
 
     // دالة لتقديم التذكرة
     public function submitTicket(Request $request)
     {
         // التحقق من صحة البيانات
         $request->validate([
             'subject' => 'required|string|max:255',
             'message' => 'required|string|max:1000',
         ]);
 
         // الحصول على بيانات التذكرة
         $subject = $request->input('subject');
         $message = $request->input('message');
         $telegramId = $request->input('telegram_id');
 
         // حفظ التذكرة في قاعدة البيانات
         $user = User::where('telegram_id', $telegramId)->first();
         $ticket = new SupportTicket();
         $ticket->user_id = $user->id;
         $ticket->subject = $subject;
         $ticket->message = $message;
         $ticket->save();
 
         // إرسال إشعار للمسؤول
         $this->sendAdminNotification($subject, $message);
 
         // إرجاع رد للمستخدم
         return back()->with('success', 'تم تقديم تذكرتك بنجاح وسيتم الرد عليك قريبًا.');
     }


     public function show($id)
{
    $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->first();

    $ticket = SupportTicket::where('id', $id)
        ->where('user_id', $user?->id)
        ->firstOrFail();

    return view('support.show', compact('ticket'));
}

}
