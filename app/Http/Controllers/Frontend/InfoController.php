<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\InformationRequest;
use App\Models\Lead;
use App\Models\SphereMask;
use Sentinel;

class InfoController extends Controller
{
    public $id;

    /**
     * InfoController constructor.
     */
    public function __construct()
    {

        $this->id = Sentinel::getUser()->id;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $informations = Lead::with('phone')
            ->whereHas('obtainedBy', function ($query) {
               $query->where('agent_id', $this->id);
            })
            ->get();

        return view('views.page.info', compact('informations'));
    }

    /**
     * @param InformationRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(InformationRequest $request)
    {
        $sphereMask = new SphereMask(1, $this->id);
        $key = array_keys($sphereMask->findShortMask());

        $leadInfo = Lead::with([
            'phone',
            'sphereAttributes' => function($query) use ($key) {
                $query->whereHas('options', function ($query) use ($key) {
                        $query->select('value')
                            ->whereIn('id', $key)
                            ->orderBy('id');
                    });
                }
            ])
            ->whereHas('obtainedBy', function ($query) {
                $query->where('agent_id', $this->id);
            })
            ->findOrFail($request->id);

        return view('views.page.detail', compact('leadInfo'));
    }


}
