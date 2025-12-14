<?php

namespace Modules\Services\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Services\Entities\Invitation;
use Modules\Services\Http\Filters\ServiceFilter;
use Modules\Services\Transformers\InvitationResource;
use Modules\Support\Traits\ApiTrait;
use Carbon\Carbon;

class InvitationsController extends Controller
{
    use ApiTrait;

    private $filter;

    public function __construct(ServiceFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     *  -------------------------
     *   GET  /invitations
     *   Filters: ?current=1  ,  ?previous=1
     *  -------------------------
     */
    public function index()
    {
        $userId = auth()->id();

        $query = Invitation::query()
            ->where('user_id', $userId);

        // Filter: current events = future and today
        if (request()->has('current')) {
            $query->whereDate('event_date', '>=', now()->toDateString());
        }

        // Filter: previous events = older
        if (request()->has('previous')) {
            $query->whereDate('event_date', '<', now()->toDateString());
        }

        // No filter → return all
        $data = $query->orderByDesc('id')->get();

        return $this->sendResponse(
            InvitationResource::collection($data),
            __('success')
        );
    }

    /**
     *  -------------------------
     *   GET /invitations/{id}
     *  -------------------------
     */
    public function show($id)
    {
        $invitation = Invitation::where('user_id', auth()->id())->findOrFail($id);

        return $this->sendResponse(
            new InvitationResource($invitation),
            __('تم العثور على الدعوة')
        );
    }

    /**
     *  -------------------------
     *    POST /invitations
     *  -------------------------
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'groom_name'      => 'nullable|string|max:100',
            'bride_name'      => 'nullable|string|max:100',
            'event_date'      => 'nullable|date',
            'event_time'      => 'nullable|date_format:H:i:s',
            'location_text'   => 'nullable|string',
            'invitation_text' => 'nullable|string',
            'event_type'      => 'nullable|string|max:50',
            'quran_verse'     => 'nullable|string',
        ]);

        // prevent empty "" becoming 0000-00-00
        $validatedData['event_date'] = $request->filled('event_date')
            ? $request->event_date
            : null;

        $validatedData['event_time'] = $request->filled('event_time')
            ? $request->event_time
            : null;

        $invitation = Invitation::create([
            'user_id' => auth()->id(),
            'status'  => 'draft',
            ...$validatedData
        ]);

        if ($request->hasFile('image')) {
            $invitation
                ->addMediaFromRequest('image')
                ->toMediaCollection('main_photo');
        }

        return $this->sendResponse(
            new InvitationResource($invitation),
            __('تم إنشاء الدعوة بنجاح.')
        );
    }

    /**
     *  -------------------------
     *   PUT /invitations/{id}
     *  -------------------------
     */
    public function update(Request $request, $id)
    {
        $invitation = Invitation::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'groom_name'      => 'sometimes|string|max:100',
            'bride_name'      => 'sometimes|string|max:100',
            'event_date'      => 'sometimes|date',
            'event_time'      => 'sometimes|date_format:H:i:s',
            'location_text'   => 'sometimes|string',
            'invitation_text' => 'sometimes|string',
            'status'          => 'sometimes|in:draft,active,archived',
            'image'           => 'sometimes|file|image',
        ]);

        // fix event_date: empty "" → null
        if ($request->has('event_date')) {
            $validated['event_date'] = $request->filled('event_date')
                ? $request->event_date
                : null;
        }

        // fix event_time: empty "" → null
        if ($request->has('event_time')) {
            $validated['event_time'] = $request->filled('event_time')
                ? $request->event_time
                : null;
        }

        $invitation->update($validated);

        // new image uploaded?
        if ($request->hasFile('image')) {
            $invitation->clearMediaCollection('main_photo');
            $invitation
                ->addMediaFromRequest('image')
                ->toMediaCollection('main_photo');
        }

        return $this->sendResponse(
            new InvitationResource($invitation),
            __('تم تحديث الدعوة بنجاح.')
        );
    }

    /**
     *  -------------------------
     *   DELETE /invitations/{id}
     *  -------------------------
     */
    public function destroy($id)
    {
        $invitation = Invitation::where('user_id', auth()->id())->findOrFail($id);

        $invitation->delete();

        return $this->sendResponse(null, __('تم حذف الدعوة بنجاح.'));
    }
}
