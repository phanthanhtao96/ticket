<?php
/***SaoBacDauTelecom***/

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * @param $request
     * @param Closure $next
     * @param string $capability
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next, $capability = '')
    {
        $role = new Role();
        $capabilities = $role->currentCapabilities();
        return in_array($capability, $capabilities) || Auth::user()->id == 1 ? $next($request) :
            redirect()->to('/access-denied');
    }
}
