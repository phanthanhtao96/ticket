<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\Request as ClientRequest;

class RatingsController extends Controller
{
    public function getGuestRating($id = '', $email = '')
    {
        //Check rating
        $check = Rating::join('requests', 'ratings.request_id', 'requests.id')
            ->where('requests.uuid', $id)->first();
        $enable = !$check ? 1 : 0;
        return view('rating')->with(['enable' => $enable, 'id' => $id, 'email' => decrypt($email)]);
    }

    public function postGuestRating(Request $request)
    {
        $request->validate([
            'client_email' => ['required', 'email'],
            'rating1' => ['required', 'numeric', 'min:0', 'max:5'],
            'rating2' => ['required', 'numeric', 'min:0', 'max:5'],
            'rating3' => ['required', 'numeric', 'min:0', 'max:5'],
            'rating4' => ['required', 'numeric', 'min:0', 'max:5'],
            'response_rating' => ['required', 'numeric', 'min:0', 'max:5']
        ]);

        $uuid = $request->uuid ?? '';
        $clientEmail = $request->client_email ?? '';

        $rating1 = $request->rating1 ?? 0;
        $rating2 = $request->rating2 ?? 0;
        $rating3 = $request->rating3 ?? 0;
        $rating4 = $request->rating4 ?? 0;
        $response_rating = $request->response_rating ?? 0;

        $rating = 0;
        $total = $rating1 + $rating2 + $rating3 + $rating4 + $response_rating;
        if ($total > 0) {
            $average = $total / 5;
            $rating = (int)round($average);
        }

        $clientRequest = ClientRequest::where([
            ['uuid', $uuid],
            ['client_email', $clientEmail]
        ])
            ->select('id', 'client_id')
            ->first();

        if (!$clientRequest) return response()->json(['status' => false, 'message' => __('admin.failed')]);

        $update = [
            'request_id' => $clientRequest->id,
            'rating' => $rating,
            'rating1' => $rating1,
            'rating2' => $rating2,
            'rating3' => $rating3,
            'rating4' => $rating4,
            'response_rating' => $response_rating
        ];
        $result = (new Rating())->updateOrCreate([
            'request_id' => $clientRequest->id
        ], $update);

        return !isset($result->id) ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.thank_you_for_rating')]);
    }
}
