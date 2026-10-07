<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::with('user', 'messages.user')->get();
        
        // Get conversation from URL parameter if exists
        $conversation = null;
        if(request()->has('conversation_id')) {
            $conversation = Conversation::with('messages.user')
                ->find(request('conversation_id'));
        }
    
        return view('messages.index', compact('conversations', 'conversation'));
    }

    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        if (strlen($request->content) > 25) {
            return redirect()->back()->with('error', 'Bericht kan niet worden verzonden omdat het te lang is.');
        }

        try {
            // Replace firstOrCreate with create to always make a new conversation
            $conversation = Conversation::create(['user_id' => Auth::id()]);

            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);

            return redirect()->route('messages.index', ['conversation_id' => $conversation->id])
                ->with('success', 'Nieuw gesprek succesvol gestart!');
        } catch (Exception $e) {
            Log::error('Failed to create message: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Het bericht kon niet worden verzonden. Probeer het later opnieuw.')
                ->withInput();
        }
    }

    public function reply(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $maxLength = 25; // Set your desired maximum length here

        if (strlen($request->content) > $maxLength) {
            return redirect()->back()->with('error', 'Bericht kan niet worden verzonden omdat het te lang is.');
        }

        // Check if we should simulate an error
        if ($request->has('simulate_error')) {
            // Simulate a server error for testing
            Log::info('Simulating server error for message reply');
            return redirect()->back()
                ->with('error', 'Het bericht kon niet worden verzonden. Probeer het later opnieuw.')
                ->withInput();
        }

        try {
            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);

            return redirect()->back()->with('success', 'Antwoord succesvol verzonden!');
        } catch (Exception $e) {
            // Log the error
            Log::error('Failed to reply to conversation: ' . $e->getMessage());

            // Return with server error message
            return redirect()->back()
                ->with('error', 'Het bericht kon niet worden verzonden. Probeer het later opnieuw.')
                ->withInput();
        }
    }

    public function markAsRead(Message $message)
    {
        try {
            $message->is_read = true;
            $message->save();

            return redirect()->route('messages.index');
        } catch (Exception $e) {
            Log::error('Failed to mark message as read: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Het bericht kon niet worden gemarkeerd als gelezen. Probeer het later opnieuw.');
        }
    }

    public function createConversation(Request $request)
    {
        // Check if we should simulate an error
        if ($request->has('simulate_error')) {
            // Simulate a server error for testing
            Log::info('Simulating server error for conversation creation');
            return redirect()->back()
                ->with('error', 'Het gesprek kon niet worden aangemaakt. Probeer het later opnieuw.');
        }

        try {
            // Create a new conversation
            $conversation = Conversation::create([
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('dashboard', ['conversation_id' => $conversation->id])
                ->with('success', 'Nieuw gesprek succesvol aangemaakt!');
        } catch (Exception $e) {
            Log::error('Failed to create conversation: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Het gesprek kon niet worden aangemaakt. Probeer het later opnieuw.');
        }
    }

    public function update(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $maxLength = 25; // Set your desired maximum length here

        if (strlen($request->content) > $maxLength) {
            return redirect()->back()->with('error', 'Bericht kan niet worden bijgewerkt omdat het te lang is.');
        }

        // Check if we should simulate an error
        if ($request->has('simulate_error')) {
            // Simulate a server error for testing
            Log::info('Simulating server error for message update');
            return redirect()->back()
                ->with('error', 'Het bericht kon niet worden bijgewerkt. Probeer het later opnieuw.')
                ->withInput();
        }

        try {
            $lastMessage = $conversation->messages()->where('user_id', Auth::id())->latest()->first();
            if ($lastMessage) {
                $lastMessage->content = $request->content;
                $lastMessage->save();
            }

            return redirect()->back()->with('success', 'Bericht succesvol bijgewerkt!');
        } catch (Exception $e) {
            Log::error('Failed to update message: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Het bericht kon niet worden bijgewerkt. Probeer het later opnieuw.')
                ->withInput();
        }
    }

    public function deleteLastMessage(Request $request, Conversation $conversation)
    {
        try {
            $lastMessage = $conversation->messages()
                ->where('user_id', Auth::id())
                ->latest()
                ->first();
    
            if ($lastMessage) {
                $lastMessage->delete();
                return redirect()->route('messages.index', ['conversation_id' => $conversation->id])
                    ->with('success', 'Laatste bericht succesvol verwijderd!');
            }
    
            return redirect()->back()
                ->with('error', 'Geen berichten gevonden om te verwijderen.');
    
        } catch (Exception $e) {
            Log::error('Failed to delete last message: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Het bericht kon niet worden verwijderd. Probeer het later opnieuw.');
        }
    }

    public function destroy(Conversation $conversation)
    {
        try {
            // Delete all messages first to avoid foreign key constraints
            $conversation->messages()->delete();
            $conversation->delete();
    
            return redirect()->route('messages.index')
                ->with('success', 'Gesprek succesvol verwijderd!');
        } catch (Exception $e) {
            Log::error('Failed to delete conversation: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Het gesprek kon niet worden verwijderd. Probeer het later opnieuw.');
        }
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id',
        ]);

        // Check if we should simulate an error
        if ($request->has('simulate_error')) {
            // Simulate a server error for testing
            Log::info('Simulating server error for delete selected messages');
            return redirect()->back()
                ->with('error', 'De geselecteerde berichten konden niet worden verwijderd. Probeer het later opnieuw.');
        }

        try {
            Message::whereIn('id', $request->message_ids)->delete();

            return redirect()->route('messages.index')->with('success', 'Geselecteerde berichten succesvol verwijderd!');
        } catch (Exception $e) {
            Log::error('Failed to delete selected messages: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'De geselecteerde berichten konden niet worden verwijderd. Probeer het later opnieuw.');
        }
    }
}
