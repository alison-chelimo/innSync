use App\Models\Room;

public function index()
{
    $rooms = Room::available()->latest()->take(6)->get();
    return view('home.index', compact('rooms')); // use whatever view name you already return
}