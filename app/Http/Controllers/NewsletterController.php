<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ], [
            'email.unique' => 'Este e-mail já está inscrito.'
        ]);

        try {
            NewsletterSubscriber::create([
                'email' => $validated['email'],
                'ip_address' => $request->ip()
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Inscrição realizada com sucesso!']);
            }

            return back()->with('success', 'Inscrição realizada com sucesso!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erro ao processar inscrição.'], 500);
            }
            return back()->with('error', 'Erro ao processar inscrição.');
        }
    }
}
