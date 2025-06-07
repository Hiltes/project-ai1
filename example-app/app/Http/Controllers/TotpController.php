<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TotpController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user->totp_secret) {
            $secret = Base32::encodeUpper(random_bytes(20));
            $user->totp_secret = $secret;
            $user->save();
        }

        $totp = TOTP::create($user->totp_secret);
        $totp->setLabel($user->email);
        $uri = $totp->getProvisioningUri();

        // Render QR code as SVG
        $renderer = new ImageRenderer(
            new RendererStyle(250),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($uri);

        return view('profile.totp', [
            'qrCode' => $qrCode,
            'user' => $user
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $totp = TOTP::create($user->totp_secret);

        if ($totp->verify($request->code)) {
            $user->totp_enabled = true;
            $user->save();

            return redirect()->route('totp.show')->with('success', 'TOTP został włączony.');
        }

        return redirect()->back()->withErrors(['code' => 'Nieprawidłowy kod TOTP.']);
    }

    public function disable()
    {
        $user = Auth::user();
        $user->totp_secret = null;
        $user->totp_enabled = false;
        $user->save();

        return redirect()->route('totp.show')->with('success', 'TOTP został wyłączony.');
    }
}
