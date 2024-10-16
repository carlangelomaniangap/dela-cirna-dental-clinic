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

    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:30000', // 30MB Max
        ]);

        $topic = $this->filterBadWords($request->topic);

        $post = new CommunityForum([
            'topic' => $topic,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('forum_images'), $imageName);
            $post->image_path = 'forum_images/' . $imageName;
        }

        $post->save();

        return redirect()->back()->with('success', 'Topic posted successfully!');
    }

    public function index(Request $request)
    {
        $query = CommunityForum::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('topic', 'like', "%{$searchTerm}%")
                ->orWhereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                });
        }

        $communityforums = $query->with(['user', 'comments.user'])->latest()->paginate(10);

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

     public function updateCommunityforum(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:30000', // 30MB Max
        ]);

        $communityforum = CommunityForum::findOrFail($id);
        $communityforum->topic = $this->filterBadWords($request->input('topic'));

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($communityforum->image_path) {
                $oldImagePath = public_path($communityforum->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('forum_images'), $imageName);
            $communityforum->image_path = 'forum_images/' . $imageName;
        }

        $communityforum->save();

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
