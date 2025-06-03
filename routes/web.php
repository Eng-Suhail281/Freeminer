<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\MinerController;
use App\Http\Controllers\EarnController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PromoCodeController;
use App\Models\User;
use App\Models\Influencer;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/




// الصفحة الرئيسية: تسجيل الدخول وإنشاء المستخدم
Route::get('/', function (Request $request) {
    $telegram_id = $request->query('telegram_id')
        ?? session('telegram_id')
        ?? '123456';
    session(['telegram_id' => $telegram_id]);

    $user = User::firstOrCreate(
        ['telegram_id' => $telegram_id],
        ['username' => 'test_user', 'referral_code' => \Illuminate\Support\Str::random(10)]
    );

    return view('miner', compact('user'));
});

// API داخلي لجلب الرصيد وتبادل الـ Hashes
Route::get('/get-balance', [MinerController::class, 'getBalance'])->name('get.balance');
Route::post('/exchange-hashes', [MinerController::class, 'exchangeHashes'])->name('exchange.hashes');
Route::put('/admin/users/{telegram_id}/activate', [AdminController::class, 'activateUser'])->name('admin.users.activate');

// تعطيل الحساب
Route::put('/admin/users/{telegram_id}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');

// حذف المستخدم
Route::delete('/admin/users/{telegram_id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

Route::post('/admin/users/{user}/message', [AdminController::class, 'sendMessage'])->name('admin.users.message');

// عرض صفحة إرسال الرسالة
Route::get('/admin/send-message', [AdminController::class, 'showSendMessageForm'])->name('admin.send_message_form');

// معالجة إرسال الرسالة (موجود سابقًا)
Route::post('/admin/send-message', [AdminController::class, 'sendMessage'])->name('admin.send_message');

// -------------------

// 🟧 FaQ

Route::get('/faq', fn() => view('FaQ.index'));
Route::get('/test', fn() => view('Slide'));


// 🟧 Support (المستخدم)
// -------------------

Route::get('/support', [SupportController::class, 'index'])->name('support.index');
Route::post('/support', [SupportController::class, 'send'])->name('support.send');
Route::get('/support/{id}', [SupportController::class, 'show'])->name('support.show');


// -------------------
// 🟧 Transaction History
// -------------------
Route::get('/transactions/history', [TransactionController::class, 'index'])
     ->name('transactions.history');


// -------------------
// 🟩 إيداع
// -------------------
Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.deposit');
Route::post('/deposit/pay', [DepositController::class, 'handlePay'])->name('deposit.handlePay');
Route::get('/deposit/form/{method}', [DepositController::class, 'form']);
Route::get('/deposit/success', fn() => "تم الدفع بنجاح!")->name('deposit.success');
Route::get('/deposit/cancel', fn() => "تم إلغاء الدفع.")->name('deposit.cancel');
Route::post('/payment/callback', [DepositController::class, 'handleNowPayments'])
     ->name('nowpayments.callback');

// -------------------
// 🟦 سحب
// -------------------

Route::prefix('withdraw')->group(function () {
    Route::get('/', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::get('/{method}', [WithdrawController::class, 'showForm'])->name('withdraw.form');
    Route::post('/{method}', [WithdrawController::class, 'submit'])->name('withdraw.submit');
    Route::get('/success', [WithdrawController::class, 'success'])->name('withdraw.success');
    Route::post('/callback', [WithdrawController::class, 'callback'])->name('withdraw.callback');
    Route::post('/submit/{method}', [WithdrawController::class, 'submit'])->name('withdraw.submit');

});

// -------------------
// 🟨 صفحات أخرى
// -------------------
Route::get('/earn', [EarnController::class, 'index'])->name('earn.page');
Route::get('/tasks', fn() => view('tasks'));
Route::get('/get-gpu-power', [MinerController::class, 'getGpuPower']);

// -------------------
// 🟧 تسجيل مستخدم جديد (إحالة)
// -------------------
Route::post('/register_user', [UserController::class, 'registerUser']);
Route::get('/register', function (Request $request) {
    // تخزين كود الإحالة في الجلسة إذا وصل من رابط /register?ref=CODE
    if ($ref = $request->query('ref')) {
        Session::put('referral_code', $ref);
    }
    return redirect()->route('earn.page');
})->name('register');

// -------------------
// 🔐 لوحة الإدارة: إدارة تذاكر الدعم
// -------------------
// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/support/open', [AdminController::class, 'openTickets'])->name('admin.support.open');
Route::get('/support/closed', [AdminController::class, 'closedTickets'])->name('admin.support.closed');
Route::post('/support/reply/{id}', [AdminController::class, 'reply'])->name('admin.support.reply');
Route::get('/users', [AdminController::class, 'showUsers'])->name('admin.users');

    Route::get('/dashboard/promo-codes', [PromoCodeController::class, 'index'])->name('admin.promo-codes.index');
    // حفظ كود جديد
    Route::post('/dashboard/promo-codes', [PromoCodeController::class, 'store'])->name('admin.promo-codes.store');

    Route::post('/dashboard/promo-codes', [PromoCodeController::class, 'edit'])->name('admin.promo-codes.edit');

    // صفحة إنشاء كود
Route::get('/dashboard/promo-codes/create', [PromoCodeController::class, 'create'])->name('admin.promo-codes.create');

Route::get('/admin/dashboard/promo-codes/{id}/users', [PromoCodeController::class, 'users'])->name('admin.promo-codes.users');


Route::resource('/dashboard/promo-codes', \App\Http\Controllers\PromoCodeController::class)
    ->names('admin.promo-codes');


    });



    Route::get('/transaction-history', [UserController::class, 'transactionHistory'])->name('user.transactions');


Route::get('/influencer/login', [InfluencerController::class, 'showLogin'])->name('influencer.login');
Route::post('/influencer/login', [InfluencerController::class, 'login'])->name('influencer.login.submit');
Route::get('/influencer/dashboard', [InfluencerController::class, 'dashboard'])->name('influencer.dashboard');
Route::get('/influencer/logout', [InfluencerController::class, 'logout'])->name('influencer.logout');
Route::post('/influencer/withdraw', [InfluencerController::class, 'withdrawCommission'])->name('influencer.withdraw');
// Webhook من NowPayments
Route::post('/webhook/influencer/nowpayments', [InfluencerController::class, 'handleInfluencerWebhook'])->name('nowpayments.influencer.webhook');