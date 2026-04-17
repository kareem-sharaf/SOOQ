<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $apiKey = config('services.openrouter.key');

        if (!$apiKey) {
            return response()->json(['reply' => 'مفتاح API غير مضبوط'], 500);
        }

        $systemPrompt = <<<'PROMPT'
أنت مساعد SOOQ الذكي — مساعد ذكاء اصطناعي متخصص في مساعدة التجار السوريين في بناء متاجرهم الإلكترونية على منصة SOOQ.

دورك:
- مساعدة التاجر في تصميم متجره (ألوان، خطوط، تخطيط الصفحات)
- نصائح لتصوير المنتجات وعرضها باحترافية
- استراتيجيات تسعير مناسبة للسوق السوري (بالليرة السورية ل.س)
- نصائح شحن وتوصيل للمحافظات السورية الـ 14
- أفكار تسويقية لزيادة المبيعات
- مساعدة في كتابة أوصاف المنتجات بالعربية
- اقتراح قوالب مناسبة لنوع المتجر

قواعد مهمة:
- أجب دائماً بالعربية الفصحى البسيطة
- كن موجزاً ومفيداً (3-6 أسطر كحد أقصى)
- استخدم أمثلة عملية وأرقام بالليرة السورية عند الحاجة
- كن إيجابياً ومشجعاً ومحفزاً
- لا تذكر أنك نموذج لغوي — أنت "مساعد SOOQ الذكي"
- استخدم الإيموجي باعتدال لجعل الردود أكثر حيوية
PROMPT;

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'anthropic/claude-3.5-haiku',
                'max_tokens' => 400,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $request->message],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'لم أتمكن من فهم سؤالك، حاول مرة أخرى.';
                return response()->json(['reply' => $reply]);
            }

            return response()->json([
                'reply' => 'عذراً، لم أتمكن من المعالجة حالياً. جرب مرة أخرى.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'عذراً، حدث خطأ في الاتصال. تأكد من اتصالك بالإنترنت وحاول مرة أخرى.',
            ], 200);
        }
    }
}
