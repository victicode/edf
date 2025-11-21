<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $APPROVE_STATUS = 2;
        $notices = Notice::with(["user"])->where('status', $APPROVE_STATUS)
        ->where("type", 1)->orderBy("created_at", "desc")->get();

        $announces = Notice::with(["user"])
        ->where("type", 2)->orderBy("created_at", "desc");

        if ($request->only_my_posts == 'active') {
            $announces->where('user_id', $request->user()->id);
        } else {
            $announces->where('status', $APPROVE_STATUS);
        }
        // $this->applyPaysFilter($notices, $request);

        return $this->returnSuccess(200, ["notices" => $notices, "announces" => $announces->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) {
            return $this->returnFail(400, $validated[0]);
        }

        $notice = Notice::create([
            'title' => $request->title,
            'description' => htmlspecialchars($request->desciption),
            'group' => $request->group,
            'category' => $request->category,
            'type' => $request->type,
            'data_contact' => $this->dataContactByUser($request->user()),
            'user_id' => $request->user()->id,
            'views' => '[]',
            'status' => $request->user()->rol_id == 1 ? 2 : 1
        ]);

        $this->uploadImages($notice, $request->file('img'));

        return $this->returnSuccess(200, [count($request->img), count($request->file('img'))]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notice = Notice::with(["user"])->find($id);

        return $this->returnSuccess(200, $notice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        //
    }
    public function setViewer(Request $request, $noticeId)
    {
        $notice = Notice::find($noticeId);
        $viewers = json_decode($notice->views, true);

        if (in_array($request->user()->id, $viewers)) {
            return $this->returnSuccess(200, 'ok');
        }

        array_push($viewers, $request->user()->id);
        $notice->update([
            "views" => json_encode($viewers)
        ]);

        return $this->returnSuccess(200, 'ok');
    }

    private function validateFieldsFromInput($inputs)
    {
        $rules = [
            'title' => ['required', 'regex:/^[a-z 0-9 A-Z-À-ÿ .\-]+$/i'],
            'description' => ['required', 'regex:/^[a-z a-z 0-9 A-Z-À-ÿ !+?¡¿:., \- \r \n  &]+$/i'],
            'group' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
        ];
        $messages = [
            'title.required'      => 'El titulo de la publicación es requerido.',
            'title.regex'         => 'Titulo de la publicación no valido',
            'decription.required' => 'Descripción de la publicación es requerida.',
            'decription.regex'    => 'Descripción no valida',
            'group.required'      => 'La publicacón debe pertenecer a un grupo',
            'group.numeric'       => 'Grupo valido',
            'category.required'   => 'La publicacón debe pertenecer a una categoria',
            'category.numeric'    => 'Categoria no valida',
            'type.numeric'        => 'Tipo no valido',
        ];


         $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;
    }
    private function dataContactByUser($user)
    {
        if ($user->rol_id == 1) {
            return 'Admin';
        }
        return '{"name":"' . $user->name . '", "apartment":"' . $user->apartaments[0]->number . '"}';
    }
    private function applyPaysFilter($query, Request $request)
    {
        $VIEW_ALL_STATUS = 4;

        // Filtro por estado
        if ($request->filled('status') && intval($request->status) !== $VIEW_ALL_STATUS) {
            $query->where('status', intval($request->status));
        }

        // Filtro por método de pago
        if ($request->filled('pay_method')) {
            $query->where('pay_method', intval($request->pay_method));
        }

        // Filtro por tipo de pago
        if ($request->filled('type')) {
            $query->where('type', intval($request->type));
        }

        // Filtro por rango de fechas
        if ($request->filled('date_from')) {
            $query->whereDate('pay_date', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('pay_date', '<=', $request->get('date_to'));
        }

        // Ordenamiento
        $validSortFields = ['created_at', 'pay_date', 'amount', 'status'];
        $sortBy = in_array($request->get('sort_by'), $validSortFields)
            ? $request->get('sort_by') : 'created_at';
        $sortDir = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDir);
    }
    private function uploadImages($notice, $images)
    {
        $path = "";
        $allImages = [];

        if ($images) {
            for ($i = 0; $i < count($images); $i++) {
                $path = $this->getFormatNameImage($notice, $images[$i]);
                $imagesPath = public_path() . "/images/post/";
                $images[$i]->move($imagesPath, $path);

                array_push($allImages, $path);
            }
        }

        $notice->update(['img' => json_encode($allImages)]);
    }
    private function getFormatNameImage($notice, $image)
    {
        $rand = rand(1000000, 9999999);
        $fileName = trim(str_replace(" ", "_", $notice->id));
        $extension = $image->extension();
        return "/public/images/posts/{$rand}_{$fileName}.{$extension}";
    }
}
