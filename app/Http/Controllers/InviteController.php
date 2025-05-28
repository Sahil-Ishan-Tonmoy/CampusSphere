<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function generate(Request $request)
    {
        $originalUrl = $request->input('original_url');
        $urlObj = parse_url($originalUrl);
        $path = $urlObj['path'] ?? '';
        $pathParts = explode('/', trim($path, '/'));
        $invitePath = '/invite/' . implode('/', array_slice($pathParts,1));
        $inviteUrl = $urlObj['scheme'] . '://' . $urlObj['host'] . $invitePath;

        $inviteCode = strtoupper(Str::random(8));

        // Cache invite URL for 7 days
        Cache::put("invite:$inviteCode", $inviteUrl, now()->addDays(7));

        return response()->json([
            'short_url' => url("/i/$inviteCode")
        ]);
    }

    public function redirect($inviteCode)
    {
        $url = Cache::get("invite:$inviteCode");

        if ($url) {
            return redirect()->to($url);
        }

        abort(404, 'Invite link expired or invalid.');
    }
}
