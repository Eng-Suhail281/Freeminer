<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\SupportTicket;
use App\Models\Payment;
use App\Models\User;
use App\Models\PromoCode;

class AdminController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        return view('admin.login');
    }

    public function showUsers(Request $request)
{
    $query = User::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%$search%")
              ->orWhere('deposit_amount', 'like', "%$search%");
        });
    }

     // فلترة الحالة
     if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->date_filter == 'last_7_days') {
        $query->where('created_at', '>=', now()->subDays(7));
    } elseif ($request->date_filter == 'this_month') {
        $query->whereMonth('created_at', now()->month);
    }

    $users = $query->latest()->paginate(10);

    return view('admin.users', compact('users'));
}

// تفعيل الحساب
public function activateUser($telegram_id)
{
    // البحث عن المستخدم باستخدام telegram_id
    $user = User::where('telegram_id', $telegram_id)->firstOrFail();

    // تحديث حالة المستخدم إلى 'active'
    $user->update(['status' => 'active']);

    return redirect()->route('admin.users')->with('success', 'تم تفعيل الحساب بنجاح.');
}

// تعطيل الحساب
public function deactivateUser($telegram_id)
{
    // البحث عن المستخدم باستخدام telegram_id
    $user = User::where('telegram_id', $telegram_id)->firstOrFail();

    // تحديث حالة المستخدم إلى 'disabled'
    $user->update(['status' => 'disabled']);

    return redirect()->route('admin.users')->with('success', 'تم تعطيل الحساب بنجاح.');
}

// حذف المستخدم
public function destroyUser($telegram_id)
{
    // البحث عن المستخدم باستخدام telegram_id
    $user = User::where('telegram_id', $telegram_id)->firstOrFail();

    // حذف المستخدم
    $user->delete();

    return redirect()->route('admin.users')->with('success', 'تم حذف المستخدم بنجاح.');
}



    // معالجة تسجيل الدخول
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

    // تسجيل الخروج
    public function logout()
    {
        Session::forget('is_admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج.');
    }

    // لوحة التحكم الرئيسية
    public function dashboard()
    {
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')
                             ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $userCount     = User::count();
        $totalDeposits = Payment::where('status', 'completed')->sum('amount');
        $openTickets   = SupportTicket::whereNull('reply')->latest()->get();
        $closedTickets = SupportTicket::whereNotNull('reply')->latest()->get();

        return view('admin.dashboard', compact(
            'userCount',
            'totalDeposits',
            'openTickets',
            'closedTickets'
      ));
    }

        public function showSendMessageForm()
{
    if (! session('is_admin_logged_in')) {
        return redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول أولاً');
    }

    return view('admin.send_message');
}


     public function sendMessage(Request $request)
    {
        if (! session('is_admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $request->validate([
            'message' => 'required|string|max:1000',
            'send_to' => 'required|in:all,depositors',
            'subject' => 'required|string|max:255',
        ]);

        $message = $request->message;
        $sendTo = $request->send_to;
         $subject = $request->input('subject');

        if ($sendTo == 'all') {
            // جلب كل المستخدمين
            $users = User::all();
        } else {
            // جلب المستخدمين الذين لديهم إيداع (مثلاً حقل deposit_amount > 0)
            $users = User::where('deposit_amount', '>', 0)->get();
        }

        foreach ($users as $user) {
            // حفظ رسالة دعم لكل مستخدم
            SupportTicket::create([
                'telegram_id' => $user->telegram_id,
                'subject'     => $subject,  // تأكد من إرسال هذا الحقل
                'message'     => $message,
                'reply'       => null,
            ]);

            // إرسال إشعار عبر Telegram (اختياري)
            $this->sendTelegramMessage($user->telegram_id, "📢 رسالة من الإدارة:\n\n" . $message);
        }

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح.');
    }


public function closedTickets()
{
    $closedTickets = SupportTicket::whereNotNull('reply')->latest()->paginate(20);
    return view('admin.closed_tickets', compact('closedTickets'));
}

public function openTickets()
{
    $openTickets = SupportTicket::whereNull('reply')->latest()->paginate(20);
    return view('admin.open_tickets', compact('openTickets'));
}

    // الرد على تذكرة دعم
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
}
