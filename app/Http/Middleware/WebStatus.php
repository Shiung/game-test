<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\System\ParameterService;

class WebStatus
{
    protected $parameterService;
    public function __construct(ParameterService $parameterService) 
    {
        $this->parameterService = $parameterService;
    }
    /**
     * 檢查網站是否維修中
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {

        //網站關閉
        if($this->parameterService->find('web_status') == '0'){
            return redirect()->route('front.maintenance');
        }
        

        
        return $next($request);

        
    }
}
