<?php

namespace App\Http\Controllers\dentistrystudent;
use App\Http\Controllers\Controller;
use App\Models\CommunityForum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DentistryStudentCommunityForumController extends Controller
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

    public function store(Request $request){

        $request->validate([
            'topic' => 'required|string|max:255',
        ]);

        $filteredTopic = $this->filterBadWords($request->topic);

        CommunityForum::create([
            'topic' => $filteredTopic,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Topic posted successfully!');
    }

    public function index(){

        $communityforums = CommunityForum::all();
        $communityforums = CommunityForum::paginate(10);

        return view('dentistrystudent.communityforum.communityforum', compact('communityforums'));
    }

    public function createCommunityforum(){

        return view('dentistrystudent.communityforum.create');
    }

    public function deleteCommunityforum($id){

        $communityforum = CommunityForum::findOrFail($id);
        $communityforum->delete();

        return back()->with('success', 'Topic deleted successfully!');
    }

    
    public function editCommunityforum($id){

        session(['edit_id' => $id]);
        
        return redirect()->route('dentistrystudent.communityforum');
    }

    // Update the community forum post
    public function updateCommunityforum(Request $request, $id){

        $request->validate([
            'topic' => 'required|string|max:255',
        ]);

        $communityforum = CommunityForum::findOrFail($id);
        $communityforum->topic = $this->filterBadWords($request->input('topic'));
        $communityforum->save();

        session()->forget('edit_id');

        return redirect()->route('dentistrystudent.communityforum')->with('success', 'Topic updated successfully!');
    }

    public function showComment($communityforumId){

        $communityforums = CommunityForum::findOrFail($communityforumId);
        $comments = $communityforums->comments;

        return view('dentistrystudent.communityforum.showComment', compact('communityforums', 'comments'));
    }
    public function comment(){
        
        $communityforums = CommunityForum::with('comments')->get();

        return view('dentistrystudent.communityforum', compact('communityforums'));
    }
}
