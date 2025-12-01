<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.',
    'deleted' => 'تم حذف هذا الحساب.',
    'has_account' => 'هذا الرقم مسجل مسبقاً.',
    'blocked' => 'تم حظر هذا الحساب.',
    'password' => 'كلمة المرور التي ادخلتها غير صحيحة!',
    'new-password' => 'كلمة المرور الجديدة التي ادخلتها غير أمنة!',
    'throttle' => 'عدد كبير جدا من محاولات الدخول. يرجى المحاولة مرة أخرى بعد :seconds ثانية.',
    'attributes' => [
        'code' => 'رمز التحقق',
        'token' => 'شفرة التحقق',
        'email' => 'البريد الالكتروني',
        'phone' => 'رقم الهاتف',
        'username' => 'البريد الالكترونى او رقم الهاتف',
        'password' => 'كلمة المرور',
    ],
    'messages' => [
        'forget-password-code-sent' => 'لفد تم ارسال رمز استعادة كلمة المرور على هاتفك الجوال',
        'email-verification-sent' => 'لفد تم ارسال رمز التفعيل على بريدك الالكتروني',
    ],
    'emails' => [
        'forget-password' => [
            'subject' => 'رمز التحقق لتسجيل الدخول',
            'greeting' => 'عزيزي :user',
            'line' => ":code  رمز التحقق الخاص بك",
            //            'code' => " (:code)",
            'time' => " صالح لمدة :minutes دقائق",
            'footer' => 'شكراً لاستخدامك لتطبيقنا',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
        'password-less' => [
            'subject' => 'رمز التحقق لتسجيل الدخول',
            'greeting' => 'عزيزي :user',
            'line' => ":code  رمز التحقق الخاص بك",
            'time' => " صالح لمدة :minutes دقائق",
            'footer' => 'شكراً لاستخدامك لتطبيقنا',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
        // 'new-account-password' => [
        //     'subject' => 'بيانات تسجيل الدخول',
        //     'greeting' => 'عزيزي :user',
        //     'email' => "البريد الالكتروني :email",
        //     'password' => "الرقم السري :password",
        //     'footer' => 'شكراً لاستخدامك لتطبيقنا',
        //     'salutation' => 'مع تحيات فريق عمل :app',
        // ],

        'new-account-password' => [
            'subject' => 'اعاده تعيين كلمة المرور',
            'greeting' => 'عزيزي : :user',
            'email' => "البريد الالكتروني : :email",
            'password' => "الرقم السري :password",
            'line' => ':password تم تغيير كلمة المرور الخاصة بك',
            'footer' => 'الموضوع: كلمة المرور الجديدة وخطوات المتابعة

نوصي بالاحتفاظ بهذه المعلومات في مكان آمن وعدم مشاركتها مع أي شخص.

للمتابعة:
يمكنك تسجيل الدخول إلى حسابك باستخدام كلمة المرور الجديدة.

إذا كنت بحاجة إلى أي مساعدة أو لديك أي استفسارات، لا تتردد في التواصل معنا.

مع أطيب التحيات،',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
        'reset-password' => [
            'subject' => 'استعادة كلمة المرور',
            'greeting' => 'عزيزي :user',
            'line' => 'تم تغيير كلمة المرور الخاصة بك',
            'footer' => 'شكراً لاستخدامك لتطبيقنا',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
    ],
    'orderaccept' => [
        'subject' => 'تم قبول عرضك',
        'body' => 'لقد تم قبول عرضك بنجاح. يرجى الاستعداد لتنفيذ الطلب.',
    ],
    'orderdecline' => [
        'subject' => 'تم رفض الطلب',
        'body' => 'تم رفض الطلب الخاص بك من قبل الموصل.',
    ],
    'youaccepted' => [
        'subject' => 'تم قبول عرض السائق',
        'body' => 'لقد قمت بقبول عرض السائق بنجاح، نأمل أن تسير الأمور بسلاسة.',
    ],
    'wallet' => [
        'subject' => 'تم اضافه رصيد مالي الي محفظتك',
        'body' => 'تم اضافه رصيد مالي الى المحفظه الخاصه بك يمكنك الان الاستمتاع بالرصيد المضاف'
    ],
    'register' => [
        'verification' => [
            'subject' => 'رمز التحقق',
            'greeting' => 'عزيزي :user',
            'line' => 'رمز التحقق الخاص بك ل :app هو :code',
            'footer' => 'شكرا لك على استخدام تطبيقنا!',
            'salutation' => 'مع تحيات فريق عمل, :app',
        ]
    ],
    'marketing' => [
        'subject' => 'تم قبول الطلب',
        'body' =>'تم قبول طلب الاستشارة الخاص بك',
    ],
];
