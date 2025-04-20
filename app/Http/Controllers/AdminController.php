<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\SupportTicket;
use App\Models\Payment;
use App\Models\User;

class AdminController extends Controller
{
    // 1. عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        return view('admin.login');
    }

    // 2. معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $adminEmail    = 'admin@example.com';
        $adminPassword = 'admin123';

        if ($request->email === $adminEmail && $request->password === $adminPassword) {
            session(['is_admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'بيانات الدخول غير صحيحة');
    }

    // 3. تسجيل الخروج
    public function logout()
    {
        Session::forget('is_admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج.');
    }

    // 4. لوحة التحكم الرئيسية
    public function dashboard()
    {
        // حماية الصفحة
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')
                             ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $userCount     = User::count();
        $totalDeposits = Payment::where('status', 'completed')->sum('amount');
        $openTickets   = SupportTicket::whereNull('reply')->latest()->get();
         // جلب التذاكر المغلقة
        $closedTickets = SupportTicket::whereNotNull('reply')->latest()->get();

        return view('admin.dashboard', compact(
            'userCount',
            'totalDeposits',
            'openTickets',
            'closedTickets'
        ));
    }

    // 5. صفحة التذاكر المفتوحة
    public function openTickets()
    {
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')
                             ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $openTickets   = SupportTicket::whereNull('reply')->latest()->get();
        return view('admin.open_tickets', compact('openTickets'));
    }

    // 6. صفحة التذاكر التي تم الرد عليها
    public function closedTickets()
    {
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')
                             ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $closedTickets = SupportTicket::whereNotNull('reply')->latest()->get();
        return view('admin.closed_tickets', compact('closedTickets'));
    }

    // 7. صفحة عرض المستخدمين مع إيداعهم وطاقة التعدين
    public function showUsers()
    {
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')
                             ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // نستخدم eager loading لجلب المدفوعات وحساب المجاميع
        $users = User::with('payments')->get();
        return view('admin.users', compact('users'));
    }

    // 8. الرد على تذكرة دعم
    public function reply(Request $request, $id)
    {
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')
                             ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $request->validate([
            'reply' => 'required|string',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $ticket->reply = $request->reply;
        $ticket->save();

        // إرسال إشعار للمستخدم عبر تليجرام
        $this->sendTelegramMessage(
            $ticket->telegram_id,
            "📩 تم الرد على تذكرتك. الرجاء التحقق من قسم الدعم."
        );

        return redirect()->back()->with('success', 'تم الرد على التذكرة.');
    }

    // دالة لإرسال رسالة عبر Telegram Bot
    private function sendTelegramMessage($telegramId, $message)
    {
        Http::get("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
            'chat_id' => $telegramId,
            'text'    => $message,
        ]);
    }


    public function replyToTicket(Request $request, $id)
{
    $ticket = SupportTicket::findOrFail($id);
    $ticket->reply = $request->reply;
    $ticket->save();

    return back()->with('message', 'تم إرسال الرد على التذكرة.');
}

}
