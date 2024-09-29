<?php

namespace App\Http\Controllers\dentistrystudent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class DentistryStudentCommentController extends Controller
{
    protected function filterBadWords($text){
        
        $badWords = [
            'Stupid', 'Fuck You', 'Tangina mo', 'Bobo', 'bobo','Vovo', 'vovo', 'obob', '0b0b', '8080', 'b0b0', 'B0B0',
            'tanga', 't@nga', 'pakyu', 'FU', 'fuckyou', 'boboh', 'tarantado', 'gago', 'ogag', 'siraulo', 'Tanga', 'Pakyu',
            'Fuckyou,', 'Tarandato', 'Gago', 'Siraulo', 'hudas', 'putangina', 'lintik', 'ulol', 'buwisit', 'leche','ungas',
            'punyeta', 'hinayupak', 'pucha', 'yawa', 'pisteng yawa', 'pakshet', 'Hudas', 'Putangina', 'Lintik', 'Ulol', 'Buwisit',
            'Leche', 'Ungas', 'Punyeta', 'Hinayupak', 'Pucha', 'Yawa', 'Pisteng yawa', 'Pisteng Yawa', 'Pakshet', 'Hudas', 
        ];
    
        // Create a regex pattern
        $pattern = '/\b(' . implode('|', array_map('preg_quote', $badWords)) . ')\b/i';
        
        // Replace matches with ***
        return preg_replace_callback($pattern, function ($matches) {
            // Count the letters excluding spaces
            $cleanedMatch = preg_replace('/\s+/', '', $matches[0]);
            // Create the asterisk replacement maintaining the spaces
            $asterisks = str_repeat('*', strlen($cleanedMatch));
            return preg_replace('/\S/', '*', $matches[0]); // Replace non-space characters with asterisks
        }, $text);
    }
    
    public function addComment(Request $request, $communityforumId){
        
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->communityforum_id = $communityforumId;
        $comment->comment = $this->filterBadWords($request->comment);
        $comment->save();
    
        return redirect()->route('dentistrystudent.communityforum')->with('success', 'Comment added successfully.');
    }
    
    public function editComment($id){

        $comment = Comment::findOrFail($id);
        session()->flash('edit_comment_id', $id);

        return redirect()->route('dentistrystudent.communityforum');
    }
    
    public function updateComment(Request $request, $id){

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $comment = Comment::findOrFail($id);
        $comment->comment = $this->filterBadWords($request->comment);
        $comment->save();
    
        return redirect()->route('dentistrystudent.communityforum')->with('success', 'Comment updated successfully.');
    }
    
    public function deleteComment($id){

        $comment = Comment::findOrFail($id);
        $comment->delete();
    
        return redirect()->route('dentistrystudent.communityforum')->with('success', 'Comment deleted successfully.');
    }
}
